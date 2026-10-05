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
            'jenis' => ['required', 'in:sakit,izin,keluar,pulang'],
            'tanggal' => ['required', 'date'],
            'alasan' => ['required', 'string'],
            'dokumen' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:2048'
            ],
        ];

        $requiresWaliKelas = in_array($jenis, ['sakit', 'izin'], true);

        if ($requiresWaliKelas) {

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

            $rules['jp_pulang'] = [
                'required',
                'integer',
                'min:1',
                'max:12',
            ];

            $rules['jam_selesai'] = ['nullable'];
        }

        $request->validate($rules);

        $siswa = Auth::user()->siswa;

        $walikelasId = null;

        if ($requiresWaliKelas) {

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

        $dokumen = $request->file('dokumen')
            ->store('dokumen-' . $jenis, 'public');

        Perizinan::create([
            'siswa_id' => $siswa->id,
            'jenis' => $jenis,
            'tanggal' => $request->tanggal,

            'jam_mulai' => $requiresWaliKelas
                ? null
                : $request->jam_mulai,

            'jp_pulang' => $jenis === 'pulang'
                ? $request->jp_pulang
                : null,

            'jam_selesai' => $jenis === 'keluar'
                ? $request->jam_selesai
                : null,

            'alasan' => $request->alasan,
            'dokumen' => $dokumen,

            'walikelas_id' => $walikelasId,
            'status_walikelas' => $requiresWaliKelas
                ? 'menunggu'
                : null,

            'waktu_verifikasi_walikelas' => null,
            'catatan_walikelas' => null,
            'status' => $requiresWaliKelas
                ? 'menunggu'
                : 'disetujui',
        ]);

        return redirect()
            ->route('siswa.perizinan.index')
            ->with('success', 'Pengajuan perizinan berhasil dikirim.');
    }

    public function edit($id)
    {
        $siswa = Auth::user()->siswa;

        $perizinan = Perizinan::where('id', $id)
            ->where('siswa_id', $siswa->id)
            ->firstOrFail();

        if (
            !in_array($perizinan->jenis, ['sakit', 'izin'], true) ||
            $perizinan->status !== 'menunggu'
        ) {
            return redirect()
                ->route('siswa.perizinan.index')
                ->with('error', 'Perizinan ini sudah tidak dapat diedit.');
        }

        return view('siswa.perizinan.sakit-create', compact('perizinan'));
    }
    public function update(Request $request, $id)
    {
        $siswa = Auth::user()->siswa;

        $perizinan = Perizinan::where('id', $id)
            ->where('siswa_id', $siswa->id)
            ->firstOrFail();
        if (
            !in_array($perizinan->jenis, ['sakit', 'izin'], true) ||
            $perizinan->status !== 'menunggu'
        ) {
            return redirect()
                ->route('siswa.perizinan.index')
                ->with('error', 'Perizinan ini sudah tidak dapat diedit.');
        }

        $request->validate([
            'jenis' => ['required', 'in:sakit,izin'],
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
            'jenis' => $request->jenis,
            'tanggal' => $request->tanggal,
            'alasan' => $request->alasan,
        ];
        if ($request->hasFile('dokumen')) {

            $dokumenBaru = $request->file('dokumen')
                ->store('dokumen-' . $request->jenis, 'public');
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

    public function destroy($id)
    {
        $siswa = Auth::user()->siswa;

        $perizinan = Perizinan::where('id', $id)
            ->where('siswa_id', $siswa->id)
            ->firstOrFail();
        if (
            !in_array($perizinan->jenis, ['sakit', 'izin'], true) ||
            $perizinan->status !== 'menunggu'
        ) {
            return redirect()
                ->route('siswa.perizinan.index')
                ->with('error', 'Perizinan ini sudah tidak dapat dihapus.');
        }
        if ($perizinan->dokumen) {
            Storage::disk('public')->delete($perizinan->dokumen);
        }

        $perizinan->delete();

        return redirect()
            ->route('siswa.perizinan.index')
            ->with('success', 'Pengajuan perizinan berhasil dihapus.');
    }
}
