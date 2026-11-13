<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $siswa = auth()->user()->siswa;
        $kelas = $siswa?->siswaKelas?->first()?->kelas;

        return view('siswa.dashboard', compact('siswa', 'kelas'));
    }
}
