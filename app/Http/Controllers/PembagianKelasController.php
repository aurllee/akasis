<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\CalonSiswa;
use App\Models\Siswa;
use App\Models\SiswaKelas;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PembagianKelasImport;

class PembagianKelasController extends Controller
{
    public function index(Request $request)
    {
        $query = SiswaKelas::with(['siswa', 'kelas.jurusan']);

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $pembagian = $query
            ->paginate(10)
            ->withQueryString();

        $kelas = Kelas::with('jurusan')
            ->orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->get();

        return view(
            'admin.pembagian_kelas.index',
            compact('pembagian', 'kelas')
        );
    }

    public function create()
    {
        $siswa = CalonSiswa::notAssignedToClass()
            ->orderBy('nama_lengkap')
            ->get();

        $kelas = Kelas::with('jurusan')
            ->orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->get();

        return view(
            'admin.pembagian_kelas.create',
            compact('siswa', 'kelas')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:calon_siswa,id',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $calonSiswa = CalonSiswa::findOrFail($request->siswa_id);

        $siswa = Siswa::firstOrCreate(
            ['nisn' => $calonSiswa->nisn],
            [
                'nis' => Siswa::generateNis(),
                'nik' => $calonSiswa->nik,
                'nama' => $calonSiswa->nama_lengkap,
                'tempat_lahir' => $calonSiswa->tempat_lahir,
                'tanggal_lahir' => $calonSiswa->tanggal_lahir,
                'jk' => $calonSiswa->jenis_kelamin,
                'alamat' => $calonSiswa->alamat,
                'nama_orang_tua' => $calonSiswa->nama_ayah,
            ]
        );

        $sudahAda = SiswaKelas::where('siswa_id', $siswa->id)->exists();

        if ($sudahAda) {
            return back()
                ->withInput()
                ->with('error', 'Siswa tersebut sudah memiliki kelas.');
        }

        SiswaKelas::create([
            'siswa_id' => $siswa->id,
            'kelas_id' => $request->kelas_id,
        ]);

        return redirect()
            ->route('pembagian_kelas.index')
            ->with('success', 'Siswa berhasil dimasukkan ke kelas dan data siswa telah dibuat.');
    }

    public function edit($id)
    {
        $pembagian = SiswaKelas::with(['siswa', 'kelas'])
            ->findOrFail($id);

        $kelas = Kelas::with('jurusan')
            ->orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->get();

        return view(
            'admin.pembagian_kelas.edit',
            compact('pembagian', 'kelas')
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $pembagian = SiswaKelas::findOrFail($id);

        $pembagian->update([
            'kelas_id' => $request->kelas_id,
        ]);

        return redirect()
            ->route('pembagian_kelas.index')
            ->with(
                'success',
                'Pembagian kelas berhasil diperbarui.'
            );
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv',
            ],
        ]);

        $import = new PembagianKelasImport();

        try {
            if (!class_exists(Excel::class)) {
                return back()
                    ->with('error', 'Import belum dapat dijalankan karena paket Laravel Excel belum terpasang.');
            }

            Excel::import(
                $import,
                $request->file('file')
            );

            $jumlahGagal = count($import->gagal);

            if ($import->berhasil > 0 && $jumlahGagal > 0) {
                return redirect()
                    ->route('pembagian_kelas.index')
                    ->with('warning', "Import selesai sebagian: {$import->berhasil} siswa berhasil masuk, {$jumlahGagal} data gagal.")
                    ->with('gagal_import', $import->gagal);
            }

            if ($import->berhasil === 0) {
                return redirect()
                    ->route('pembagian_kelas.index')
                    ->with('error', 'Import tidak memasukkan data siswa. Periksa format file dan data yang diunggah.')
                    ->with('gagal_import', $import->gagal);
            }

            return redirect()
                ->route('pembagian_kelas.index')
                ->with('success', "Import berhasil: {$import->berhasil} siswa dimasukkan ke kelas.");
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->with('error', 'Import gagal diproses. Periksa format file dan coba lagi.');
        }
    }

    public function destroy($id)
    {
        $pembagian = SiswaKelas::findOrFail($id);

        $pembagian->delete();

        return redirect()
            ->route('pembagian_kelas.index')
            ->with(
                'success',
                'Siswa berhasil dikeluarkan dari kelas.'
            );
    }
}