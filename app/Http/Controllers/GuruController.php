<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GuruController extends Controller
{

    public function index()
    {
        $gurus = Guru::with('mataPelajaran')
            ->latest('id')
            ->paginate(10);

        return view('admin.master-data.guru.index', compact('gurus'));
    }


    public function create()
    {
        $mataPelajaran = MataPelajaran::orderBy('nama_mapel')->get();

        return view('admin.master-data.guru.create', compact('mataPelajaran'));
    }


    public function store(Request $request)
{
    $data = $request->validate($this->guruRules());

    [$guru, $passwordAwal] = DB::transaction(function () use ($data) {

        do {
            $kodeGuru = 'GR' . strtoupper(Str::random(8));
        } while (Guru::where('kode_guru', $kodeGuru)->exists());

        $data['kode_guru'] = $kodeGuru;


            $guru = Guru::create($data);


        $passwordAwal = Str::random(8);

        User::create([
            'username' => $guru->nip,
            'password' => Hash::make($passwordAwal),
            'role_id' => 2,
            'guru_id' => $guru->id,
        ]);

        return [$guru, $passwordAwal];
    });

    return redirect()
        ->route('guru.index')
        ->with('success', 'Data guru berhasil ditambahkan.')
        ->with('username', $guru->nip)
        ->with('password_awal', $passwordAwal);
}


    public function show(string $id) {}


    public function edit(string $id)
    {
        $guru = Guru::findOrFail($id);
        $mataPelajaran = MataPelajaran::orderBy('nama_mapel')->get();

        return view('admin.master-data.guru.edit', compact('guru', 'mataPelajaran'));
    }


    public function update(Request $request, string $id)
    {
        $data = $request->validate($this->guruRules($id));

        Guru::findOrFail($id)->update($data);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }


    public function destroy(string $id)
    {
        Guru::findOrFail($id)->delete();

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus.');
    }

    private function guruRules(?string $id = null): array
    {
        return [
            'kode_guru' => 'required|max:30|unique:dataguru,kode_guru' . ($id ? ',' . $id : ''),
            'nip' => 'required|max:30|unique:dataguru,nip' . ($id ? ',' . $id : ''),
            'nama' => 'required|max:255',
            'jk' => 'required|in:Laki-laki,Perempuan',
            'tgl_lahir' => 'required|date',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Budha,Konghucu',
            'alamat' => 'required',
            'no_hp' => 'required|max:30',
            'email' => 'required|email|max:255',
            'status_kepegawaian' => 'required|in:PNS,PPPK,Honorer,Guru_tetap,Guru_tidak_tetap',
            'jabatan' => 'required|in:Guru,Kepala_sekolah,Waka_sekolah',
            'tmt' => 'required|date',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
        ];
    }
}
