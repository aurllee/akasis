<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\IzinKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IzinKeluarController extends Controller
{
    public function index()
    {
        $data = IzinKeluar::with([
            'siswa',
            'guru',
            'jadwal'
        ])
        ->where('status_kesiswaan', 'menunggu')
        ->latest()
        ->get();

        return view(
            'kesiswaan.izin-keluar.index',
            compact('data')
        );
    }

    public function setujui(IzinKeluar $izinKeluar)
    {
        $izinKeluar->update([
            'kesiswaan_id' => Auth::id(),
            'status_kesiswaan' => 'disetujui',
            'waktu_verifikasi_kesiswaan' => now(),
            'status' => 'menunggu_guru',
        ]);

        return back()->with(
            'success',
            'Izin keluar disetujui dan diteruskan ke guru mapel.'
        );
    }

    public function tolak(
        Request $request,
        IzinKeluar $izinKeluar
    ) {
        $request->validate([
            'catatan' => 'required|string',
        ]);

        $izinKeluar->update([
            'kesiswaan_id' => Auth::id(),
            'status_kesiswaan' => 'ditolak',
            'waktu_verifikasi_kesiswaan' => now(),
            'catatan_kesiswaan' => $request->catatan,
            'status' => 'ditolak',
        ]);

        return back()->with(
            'success',
            'Izin keluar ditolak.'
        );
    }
}