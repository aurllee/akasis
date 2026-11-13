<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\PenilaianMapel;

class NilaiController extends Controller
{
    public function index()
    {
        $siswa = auth()->user()->siswa;

        if (!$siswa) {
            abort(403, 'Akun Anda belum terhubung dengan data siswa.');
        }

        $nilai = PenilaianMapel::with([
            'jadwal.guru',
            'jadwal.kelas.tahunAjaran',
            'jadwal.mapel',
        ])
            ->where('siswa_id', $siswa->id)
            ->latest('tanggal_penilaian')
            ->get();

        $penilaianMapel = $nilai->groupBy(fn($item) => $item->jadwal?->mapel?->nama_mapel ?? 'Mata Pelajaran');
        $mataPelajaran = $nilai
            ->map(fn($item) => $item->jadwal?->mapel)
            ->filter()
            ->unique('id')
            ->values();
        $rataRataMapel = $nilai->isNotEmpty()
            ? number_format((float) $nilai->avg('nilai'), 1)
            : '-';

        return view('siswa.nilai.index', compact(
            'siswa',
            'penilaianMapel',
            'mataPelajaran',
            'rataRataMapel'
        ));
    }
}
