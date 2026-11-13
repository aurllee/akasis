<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\Dispen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DispenController extends Controller
{
    public function index()
    {
        $data = Dispen::with('siswa')
            ->where('status', 'menunggu')
            ->latest()
            ->get();

        return view(
            'kesiswaan.dispen.index',
            compact('data')
        );
    }

    public function setujui(Dispen $dispen)
    {
        $dispen->update([
            'kesiswaan_id' => Auth::id(),
            'status' => 'disetujui',
            'waktu_verifikasi' => now(),
        ]);

        return back()->with(
            'success',
            'Pengajuan dispensasi disetujui.'
        );
    }

    public function tolak(
        Request $request,
        Dispen $dispen
    ) {
        $request->validate([
            'catatan' => 'required|string',
        ]);

        $dispen->update([
            'kesiswaan_id' => Auth::id(),
            'status' => 'ditolak',
            'waktu_verifikasi' => now(),
            'catatan' => $request->catatan,
        ]);

        return back()->with(
            'success',
            'Pengajuan dispensasi ditolak.'
        );
    }
}