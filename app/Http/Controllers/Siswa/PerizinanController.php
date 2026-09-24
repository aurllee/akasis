<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Perizinan;
use App\Models\SiswaKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PerizinanController extends Controller
{
    /**
     * Menampilkan semua riwayat perizinan siswa.
     */
    public function index()
    {
        $siswa = Auth::user()->siswa;

        $data = Perizinan::where('siswa_id', $siswa->id)
            ->orderByDesc('tanggal')
            ->orderByDesc('created_at')
            ->get();

        return view('siswa.perizinan.sakit', compact('data'));
    }
    public function create()
    {
        return view('siswa.perizinan.sakit-create');
    }
    public function store(Request $request)
    {
        $jenis = $request->jenis;
        $rules = [
            'jenis' => ['required', 'in:sakit,keluar,pulang'],
            'tanggal' => ['required', 'date'],
            'alasan' => ['required', 'string'],
            'dokumen' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:2048'
            ],
        ];

        // =========================
        // VALIDASI BERDASARKAN JENIS
        // =========================

        if ($jenis === 'sakit') {

            $rules['jam_mulai'] = ['nullable'];
            $rules['jam_selesai'] = ['nullable'];
        } elseif ($jenis === 'keluar') {

            $rules['jam_mulai'] = [
                'required',
                'date_format:H:i'
            ];

            $rules['jam_selesai'] = [
                'required',
                'date_format:H:i',
                'after:jam_mulai'
            ];
        } elseif ($jenis === 'pulang') {

            $rules['jam_mulai'] = [
                'required',
                'date_format:H:i'
            ];

            $rules['jam_selesai'] = ['nullable'];
        }

        $request->validate($rules);

        $siswa = Auth::user()->siswa;

        // =========================
        // CARI WALI KELAS
        // KHUSUS IZIN SAKIT
        // =========================

        $walikelasId = null;

        if ($jenis === 'sakit') {

            $siswaKelas = SiswaKelas::with('kelas')
                ->where('siswa_id', $siswa->id)
                ->latest('id')
                ->first();

            $walikelasId = $siswaKelas?->kelas?->wali_kelas_id;

            if (!$walikelasId) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'jenis' => 'Wali kelas kamu belum terdata.'
                    ]);
            }
        }

        // =========================
        // SIMPAN DOKUMEN
        // =========================

        $dokumen = $request->file('dokumen')
            ->store('dokumen-' . $jenis, 'public');

        // =========================
        // SIMPAN PERIZINAN
        // =========================

        Perizinan::create([
            'siswa_id' => $siswa->id,
            'jenis' => $jenis,
            'tanggal' => $request->tanggal,

            'jam_mulai' => $jenis === 'sakit'
                ? null
                : $request->jam_mulai,

            'jam_selesai' => $jenis === 'keluar'
                ? $request->jam_selesai
                : null,

            'alasan' => $request->alasan,
            'dokumen' => $dokumen,

            // Khusus sakit
            'walikelas_id' => $walikelasId,
            'status_walikelas' => $jenis === 'sakit'
                ? 'menunggu'
                : null,

            'waktu_verifikasi_walikelas' => null,
            'catatan_walikelas' => null,

            // Sakit menunggu wali kelas.
            // Keluar & pulang langsung disetujui
            // karena dokumen sudah bertanda tangan offline.
            'status' => $jenis === 'sakit'
                ? 'menunggu'
                : 'disetujui',
        ]);

        return redirect()
            ->route('siswa.perizinan.index')
            ->with('success', 'Pengajuan perizinan berhasil dikirim.');
    }

    /**
     * Menampilkan form edit.
     */
    public function edit($id)
    {
        $siswa = Auth::user()->siswa;

        $perizinan = Perizinan::where('id', $id)
            ->where('siswa_id', $siswa->id)
            ->firstOrFail();

        // Sakit hanya bisa diedit selama masih menunggu.
        // Keluar dan pulang langsung disetujui,
        // sehingga tidak boleh diubah setelah dikirim.
        if (
            $perizinan->jenis !== 'sakit' ||
            $perizinan->status !== 'menunggu'
        ) {
            return redirect()
                ->route('siswa.perizinan.index')
                ->with('error', 'Perizinan ini sudah tidak dapat diedit.');
        }

        return view('siswa.perizinan.create', compact('perizinan'));
    }

    /**
     * Memperbarui pengajuan sakit.
     */
    public function update(Request $request, $id)
    {
        $siswa = Auth::user()->siswa;

        $perizinan = Perizinan::where('id', $id)
            ->where('siswa_id', $siswa->id)
            ->firstOrFail();

        // Hanya izin sakit yang masih menunggu
        // yang boleh diedit.
        if (
            $perizinan->jenis !== 'sakit' ||
            $perizinan->status !== 'menunggu'
        ) {
            return redirect()
                ->route('siswa.perizinan.index')
                ->with('error', 'Perizinan ini sudah tidak dapat diedit.');
        }

        $request->validate([
            'jenis' => ['required', 'in:sakit'],
            'tanggal' => ['required', 'date'],
            'alasan' => ['required', 'string'],
            'dokumen' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:2048'
            ],
        ]);

        $data = [
            'tanggal' => $request->tanggal,
            'alasan' => $request->alasan,
        ];

        // Kalau upload dokumen baru
        if ($request->hasFile('dokumen')) {

            $dokumenBaru = $request->file('dokumen')
                ->store('dokumen-sakit', 'public');

            // Hapus dokumen lama
            if ($perizinan->dokumen) {
                Storage::disk('public')->delete($perizinan->dokumen);
            }

            $data['dokumen'] = $dokumenBaru;
        }

        $perizinan->update($data);

        return redirect()
            ->route('siswa.perizinan.index')
            ->with('success', 'Perizinan berhasil diperbarui.');
    }

    /**
     * Menghapus pengajuan.
     */
    public function destroy($id)
    {
        $siswa = Auth::user()->siswa;

        $perizinan = Perizinan::where('id', $id)
            ->where('siswa_id', $siswa->id)
            ->firstOrFail();

        // Hanya sakit yang masih menunggu
        // yang boleh dihapus.
        if (
            $perizinan->jenis !== 'sakit' ||
            $perizinan->status !== 'menunggu'
        ) {
            return redirect()
                ->route('siswa.perizinan.index')
                ->with('error', 'Perizinan ini sudah tidak dapat dihapus.');
        }

        // Hapus file dokumen
        if ($perizinan->dokumen) {
            Storage::disk('public')->delete($perizinan->dokumen);
        }

        $perizinan->delete();

        return redirect()
            ->route('siswa.perizinan.index')
            ->with('success', 'Pengajuan perizinan berhasil dihapus.');
    }
}
