<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\SakitGuru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SakitController extends Controller
{
    public function index()
    {
        $guruId = Auth::user()->guru_id;

        $data = SakitGuru::with([
            'sakit.siswa',
            'jadwal'
        ])
        ->where('guru_id', $guruId)
        ->where('status', 'menunggu')
        ->whereHas('sakit', function ($query) {
            $query->whereIn('status', [
                'menunggu_guru',
                'disetujui'
            ]);
        })
        ->latest()
        ->get();

        return view(
            'guru.sakit.index',
            compact('data')
        );
    }

    public function setujui(SakitGuru $sakitGuru)
    {
        $guruId = Auth::user()->guru_id;

        abort_unless(
            $sakitGuru->guru_id == $guruId,
            403
        );

        $sakitGuru->update([
            'status' => 'disetujui',
            'waktu_verifikasi' => now(),
            'catatan' => null,
        ]);

        $this->updateStatusSakit(
            $sakitGuru->sakit_id
        );

        return back()->with(
            'success',
            'Pengajuan sakit disetujui.'
        );
    }

    public function tolak(
        Request $request,
        SakitGuru $sakitGuru
    ) {
        $guruId = Auth::user()->guru_id;

        abort_unless(
            $sakitGuru->guru_id == $guruId,
            403
        );

        $request->validate([
            'catatan' => 'required|string',
        ]);

        $sakitGuru->update([
            'status' => 'ditolak',
            'waktu_verifikasi' => now(),
            'catatan' => $request->catatan,
        ]);

        $sakitGuru->sakit->update([
            'status' => 'ditolak',
        ]);

        return back()->with(
            'success',
            'Pengajuan sakit ditolak.'
        );
    }

    private function updateStatusSakit($sakitId)
    {
        $sakit = \App\Models\Sakit::with('guru')
            ->findOrFail($sakitId);

        if ($sakit->guru->contains(function ($item) {
            return $item->status === 'ditolak';
        })) {
            $sakit->update([
                'status' => 'ditolak'
            ]);

            return;
        }

        $semuaDisetujui =
            $sakit->guru->isNotEmpty()
            &&
            $sakit->guru->every(function ($item) {
                return $item->status === 'disetujui';
            });

        if ($semuaDisetujui) {
            $sakit->update([
                'status' => 'disetujui'
            ]);
        }
    }
}