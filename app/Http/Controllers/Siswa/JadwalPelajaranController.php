<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Jadwal_pelajaran;
use App\Models\SiswaKelas;

class JadwalPelajaranController extends Controller
{
    public function index()
    {
        
        $siswa = auth()->user()->siswa;
        $hari = [
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
        ];
        $jumlahJpPerHari = [
            'Senin' => 10,
            'Selasa' => 12,
            'Rabu' => 10,
            'Kamis' => 12,
            'Jumat' => 6,
        ];

        
        if (!$siswa) {
            abort(403, 'Akun Anda belum terhubung dengan data siswa.');
        }

        
        $siswaKelas = SiswaKelas::where('siswa_id', $siswa->id)
            ->first();

        
        if (!$siswaKelas) {
            return view('siswa.jadwal.index', [
                'jadwal' => collect(),
                'hari' => $hari,
                'kelas' => null,
                'jumlahJpPerHari' => $jumlahJpPerHari,
            ]);
        }

        $kelas = $siswaKelas->kelas;
        
        
        $jadwal = Jadwal_pelajaran::with([
            'kelas.jurusan',
            'mapel',
            'guru',
            'ruangan',
        ])
            ->where('kelas_id', $siswaKelas->kelas_id)
            ->where('is_published', 1)
            ->get();

        return view('siswa.jadwal.index', compact('jadwal', 'hari', 'kelas', 'jumlahJpPerHari'));
    }
}
