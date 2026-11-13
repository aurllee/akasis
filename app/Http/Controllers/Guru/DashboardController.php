<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Jadwal_pelajaran;

class DashboardController extends Controller
{
    public function index()
    {
        $guru = auth()->user()->guru;

        if (!$guru) {
            abort(403, 'Akun Anda belum terhubung dengan data guru.');
        }

        $jadwal = Jadwal_pelajaran::with([
            'kelas.jurusan',
            'mapel',
            'ruangan',
        ])
            ->where('guru_id', $guru->id)
            ->where('is_published', true)
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        return view('guru.dashboard', compact('guru', 'jadwal'));
    }
}
