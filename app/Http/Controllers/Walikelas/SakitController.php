<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\Sakit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SakitController extends Controller
{
    public function index(Request $request)
    {
        $guruId = Auth::user()->guru_id;

        $query = Sakit::with('siswa')
            ->where('walikelas_id', $guruId);

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where(function ($subQuery) use ($search) {
                    $subQuery->where('nama', 'like', "%{$search}%")
                        ->orWhere('nis', 'like', "%{$search}%")
                        ->orWhere('nisn', 'like', "%{$search}%");
                });
            });
        }

        if ($request->filled('status')) {
            $status = $request->status;

            $query->where('status_walikelas', match ($status) {
                'menunggu' => 'menunggu',
                'disetujui' => 'disetujui',
                'ditolak' => 'ditolak',
                default => null,
            });
        }

        $data = $query
            ->latest()
            ->get();

        return view(
            'wali-kelas.sakit.index',
            compact('data')
        );
    }

    public function setujui(Sakit $sakit)
    {
        $guruId = Auth::user()->guru_id;

        abort_unless(
            $sakit->walikelas_id == $guruId,
            403
        );

        $sakit->update([
            'status_walikelas' => 'disetujui',
            'status' => 'menunggu_guru',
            'waktu_verifikasi_walikelas' => now(),
            'catatan_walikelas' => null,
        ]);

        return back()->with(
            'success',
            'Pengajuan sakit disetujui.'
        );
    }

    public function tolak(
        Request $request,
        Sakit $sakit
    ) {
        $guruId = Auth::user()->guru_id;

        abort_unless(
            $sakit->walikelas_id == $guruId,
            403
        );

        $request->validate([
            'catatan' => 'required|string',
        ]);

        $sakit->update([
            'status_walikelas' => 'ditolak',
            'status' => 'ditolak',
            'waktu_verifikasi_walikelas' => now(),
            'catatan_walikelas' => $request->catatan,
        ]);

        return back()->with(
            'success',
            'Pengajuan sakit ditolak.'
        );
    }
}
