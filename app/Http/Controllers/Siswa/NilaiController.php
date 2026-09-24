<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Jadwal_pelajaran;
use App\Models\PenilaianMapel;

class NilaiController extends Controller
{
    public function index()
    {
        $siswa = auth()->user()->siswa;

        if (!$siswa) {
            abort(403, 'Akun Anda belum terhubung dengan data siswa.');
        }

        $kelas = $siswa->siswaKelas()
            ->with('kelas')
            ->first()?->kelas;

        $nilai = PenilaianMapel::with([
            'jadwal.guru',
            'jadwal.kelas.tahunAjaran',
            'jadwal.mataPelajaran',
        ])
            ->where('siswa_id', $siswa->id)
            ->latest()
            ->get();

        $penilaianMapel = $nilai
            ->groupBy(fn ($item) => $item->jadwal?->mataPelajaran?->nama_mapel ?? 'Mata Pelajaran')
            ->sortKeys();

        $namaMapelKelas = $kelas
            ? Jadwal_pelajaran::with('mataPelajaran')
                ->where('kelas_id', $kelas->id)
                ->get()
                ->pluck('mataPelajaran.nama_mapel')
                ->filter()
                ->unique()
                ->sort()
                ->values()
            : collect();

        $namaMapel = $namaMapelKelas
            ->merge($penilaianMapel->keys())
            ->filter()
            ->unique()
            ->sort()
            ->values();

        $penilaianMapel = $namaMapel->mapWithKeys(fn ($nama) => [
            $nama => $penilaianMapel->get($nama, collect()),
        ]);

        $mataPelajaran = $namaMapel
            ->map(fn ($nama) => (object) ['nama_mapel' => $nama])
            ->values();

        $rataRataMapel = $nilai->isNotEmpty()
            ? number_format((float) $nilai->avg('nilai'), 1, '.', '')
            : '0.0';

        return view('siswa.nilai.index', compact(
            'siswa',
            'penilaianMapel',
            'mataPelajaran',
            'rataRataMapel'
        ));
    }
}
