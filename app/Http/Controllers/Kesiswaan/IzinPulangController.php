<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\IzinPulang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IzinPulangController extends Controller
{
    public function index()
    {
        $data = IzinPulang::with([
            'siswa',
            'guru',
            'jadwal'
        ])
        ->where('status_kesiswaan', 'menunggu')
        ->latest()
        ->get();

        return view(
            'kesiswaan.izin-pulang.index',
            compact('data')
        );
    }

    public function setujui(IzinPulang $izinPulang)
    {
        $izinPulang->update([
            'kesiswaan_id' => Auth::id(),
            'status_kesiswaan' => 'disetujui',
            'waktu_verifikasi_kesiswaan' => now(),
            'status' => 'menunggu_guru',
        ]);

        return back()->with(
            'success',
            'Izin pulang diteruskan ke guru mapel.'
        );
    }

    public function tolak(
        Request $request,
        IzinPulang $izinPulang
    ) {
        $request->validate([
            'catatan' => 'required|string',
        ]);

        $izinPulang->update([
            'kesiswaan_id' => Auth::id(),
            'status_kesiswaan' => 'ditolak',
            'waktu_verifikasi_kesiswaan' => now(),
            'catatan_kesiswaan' => $request->catatan,
            'status' => 'ditolak',
        ]);

        return back()->with(
            'success',
            'Izin pulang ditolak.'
        );
    }
}