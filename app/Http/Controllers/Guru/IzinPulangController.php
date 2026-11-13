<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\IzinPulang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IzinPulangController extends Controller
{
    public function index()
    {
        $guruId = Auth::user()->guru_id;

        $data = IzinPulang::with('siswa')
            ->where('guru_mapel_id', $guruId)
            ->where('status', 'menunggu_guru')
            ->latest()
            ->get();

        return view(
            'guru.izin-pulang.index',
            compact('data')
        );
    }

    public function setujui(IzinPulang $izinPulang)
    {
        abort_unless(
            $izinPulang->guru_mapel_id ==
            Auth::user()->guru_id,
            403
        );

        $izinPulang->update([
            'status_guru' => 'disetujui',
            'waktu_verifikasi_guru' => now(),
            'status' => 'disetujui',
        ]);

        return back()->with(
            'success',
            'Izin pulang disetujui.'
        );
    }

    public function tolak(
        Request $request,
        IzinPulang $izinPulang
    ) {
        abort_unless(
            $izinPulang->guru_mapel_id ==
            Auth::user()->guru_id,
            403
        );

        $request->validate([
            'catatan' => 'required|string',
        ]);

        $izinPulang->update([
            'status_guru' => 'ditolak',
            'waktu_verifikasi_guru' => now(),
            'catatan_guru' => $request->catatan,
            'status' => 'ditolak',
        ]);

        return back()->with(
            'success',
            'Izin pulang ditolak.'
        );
    }
}