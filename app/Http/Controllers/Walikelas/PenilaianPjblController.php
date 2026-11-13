<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\PenilaianPjbl;
use App\Models\PjblPenguji;
use Illuminate\Http\Request;

class PenilaianPjblController extends Controller
{
    public function index()
    {
        $guru = auth()->user()?->guru;

        if (!$guru) {
            abort(403, 'Akun Anda belum terhubung dengan data guru.');
        }

        $pjblPenguji = PjblPenguji::with([
            'pjbl.kelas.jurusan',
            'pjbl.kelas.siswaKelas',
            'pjbl.tahunAjaran',
            'penilaian' => function ($query) {
                $query->latest('updated_at');
            },
        ])
            ->where('guru_id', $guru->id)
            ->whereHas('pjbl', function ($query) {
                $query->whereDate('tanggal', now()->toDateString());
            })
            ->get()
            ->filter(fn ($penguji) => !$this->diLuarWaktuPenilaian($penguji->pjbl))
            ->values();

        return view('wali-kelas.penilaian.pjbl.index', compact('pjblPenguji', 'guru'));
    }

    public function nilai($pjblId)
    {
        $guru = auth()->user()?->guru;

        if (!$guru) {
            abort(403, 'Akun Anda belum terhubung dengan data guru.');
        }

        $penguji = PjblPenguji::with([
            'pjbl.kelas',
            'pjbl.tahunAjaran',
            'penilaian',
        ])
            ->where('pjbl_id', $pjblId)
            ->where('guru_id', $guru->id)
            ->firstOrFail();

        $pjbl = $penguji->pjbl;

        if ($this->diLuarWaktuPenilaian($pjbl)) {
            return redirect()
                ->route('wali-kelas.penilaian-pjbl.index')
                ->with('error', 'Waktu pengisian nilai PJBL belum dibuka atau sudah ditutup.');
        }

        $siswaKelas = $pjbl->kelas
            ->siswaKelas()
            ->with('siswa')
            ->join('datasiswa', 'siswa_kelas.siswa_id', '=', 'datasiswa.id')
            ->orderBy('datasiswa.nama')
            ->select('siswa_kelas.*')
            ->get();

        $nilaiSiswa = $penguji->penilaian->pluck('nilai', 'siswa_id');

        return view('wali-kelas.penilaian.pjbl.nilai', compact(
            'pjbl',
            'penguji',
            'guru',
            'siswaKelas',
            'nilaiSiswa'
        ));
    }

    public function simpan(Request $request, $pjblId)
    {
        $guru = auth()->user()?->guru;

        if (!$guru) {
            abort(403, 'Akun Anda belum terhubung dengan data guru.');
        }

        $penguji = PjblPenguji::with('pjbl.kelas')
            ->where('pjbl_id', $pjblId)
            ->where('guru_id', $guru->id)
            ->firstOrFail();

        if ($this->diLuarWaktuPenilaian($penguji->pjbl)) {
            return redirect()
                ->route('wali-kelas.penilaian-pjbl.index')
                ->with('error', 'Waktu pengisian nilai PJBL belum dibuka atau sudah ditutup.');
        }

        $validated = $request->validate([
            'nilai' => 'required|array',
            'nilai.*' => 'required|numeric|min:0|max:100',
        ]);

        $siswaIds = $penguji->pjbl->kelas
            ->siswaKelas()
            ->pluck('siswa_id')
            ->all();

        foreach ($validated['nilai'] as $siswaId => $nilai) {
            if (!in_array((int) $siswaId, $siswaIds, true)) {
                abort(422, 'Siswa tidak terdaftar di kelas PJBL ini.');
            }

            PenilaianPjbl::updateOrCreate(
                [
                    'pjbl_id' => $pjblId,
                    'pjbl_penguji_id' => $penguji->id,
                    'siswa_id' => $siswaId,
                ],
                ['nilai' => $nilai]
            );
        }

        return redirect()
            ->route('wali-kelas.penilaian-pjbl.index')
            ->with('success', 'Penilaian PJBL berhasil disimpan.');
    }

    public function riwayat()
    {
        $guru = auth()->user()?->guru;

        if (!$guru) {
            abort(403, 'Akun Anda belum terhubung dengan data guru.');
        }

        $riwayat = PjblPenguji::with([
            'pjbl.kelas.jurusan',
            'pjbl.tahunAjaran',
            'penilaian' => function ($query) {
                $query->latest('updated_at');
            },
        ])
            ->where('guru_id', $guru->id)
            ->whereHas('penilaian')
            ->latest('updated_at')
            ->get();

        return view('wali-kelas.penilaian.pjbl.riwayat', compact('riwayat', 'guru'));
    }

    public function riwayatDetail($pengujiId)
    {
        $guru = auth()->user()?->guru;

        if (!$guru) {
            abort(403, 'Akun Anda belum terhubung dengan data guru.');
        }

        $penguji = PjblPenguji::with([
            'pjbl.kelas.jurusan',
            'pjbl.tahunAjaran',
            'penilaian' => function ($query) {
                $query->with('siswa')->latest('updated_at');
            },
        ])
            ->where('id', $pengujiId)
            ->where('guru_id', $guru->id)
            ->firstOrFail();

        $penguji->setRelation(
            'penilaian',
            $penguji->penilaian
                ->sortBy(fn ($item) => mb_strtolower($item->siswa?->nama ?? ''))
                ->values()
        );

        return view('wali-kelas.penilaian.pjbl.riwayat-detail', compact('penguji', 'guru'));
    }

    private function diLuarWaktuPenilaian($pjbl): bool
    {
        if (!$pjbl) {
            return true;
        }

        $sekarang = now();

        return ($pjbl->mulai_penilaian && $sekarang->lt($pjbl->mulai_penilaian))
            || ($pjbl->batas_penilaian && $sekarang->gt($pjbl->batas_penilaian));
    }
}
