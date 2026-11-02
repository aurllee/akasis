<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use App\Models\CalonSiswa;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\TahunAjaran;

class DashboardController extends Controller
{
    public function index()
    {
        $tahunAjaran = TahunAjaran::where('status', 1)->orderByDesc('id')->first();
        $tahunAjaranAktif = $tahunAjaran
            ? $tahunAjaran->tahun_ajaran . ' - ' . $tahunAjaran->semester
            : 'Belum ditentukan';
        $jumlahSiswaBaruBelumPunyaKelas = CalonSiswa::notAssignedToClass()
            ->where('status_penerimaan', 'diterima')
            ->where('status_daftar_ulang', 'terverifikasi')
            ->count();

        return view('kurikulum.dashboard', [
            'tahunAjaranAktif' => $tahunAjaranAktif,
            'jumlahGuru' => Guru::whereHas('user')->count(),
            'jumlahSiswa' => Siswa::count(),
            'jumlahSiswaBaruBelumPunyaKelas' => $jumlahSiswaBaruBelumPunyaKelas,
            'jumlahKelas' => Kelas::count(),
        ]);
    }
}
