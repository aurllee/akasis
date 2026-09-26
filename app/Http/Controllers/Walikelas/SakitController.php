<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\Dispen;
use App\Models\Perizinan;
use App\Models\SiswaKelas;
use App\Models\WaliKelas;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class SakitController extends Controller
{
    public function index(Request $request)
    {
        $guruId = Auth::user()->guru_id;
        $kelasIds = WaliKelas::where('guru_id', $guruId)->pluck('kelas_id');
        $siswaIds = SiswaKelas::whereIn('kelas_id', $kelasIds)->pluck('siswa_id');

        $izinQuery = Perizinan::with('siswa')
            ->whereIn('siswa_id', $siswaIds);

        if ($request->filled('search')) {
            $search = trim($request->search);

            $izinQuery->whereHas('siswa', function ($q) use ($search) {
                $q->where(function ($subQuery) use ($search) {
                    $subQuery->where('nama', 'like', "%{$search}%")
                        ->orWhere('nis', 'like', "%{$search}%")
                        ->orWhere('nisn', 'like', "%{$search}%");
                });
            });
        }

        $izin = $izinQuery->get()->map(function (Perizinan $item) {
            return (object) [
                'id' => $item->id,
                'sumber' => 'perizinan',
                'jenis' => ucfirst($item->jenis ?? 'Izin'),
                'siswa' => $item->siswa,
                'walikelas_id' => $item->walikelas_id,
                'tanggal' => $item->tanggal,
                'alasan' => $item->alasan,
                'dokumen' => $item->dokumen,
                'status' => $item->status_walikelas ?? $item->status ?? 'menunggu',
                'catatan' => $item->catatan_walikelas,
            ];
        });

        $dispenQuery = Dispen::with('siswa')->whereIn('siswa_id', $siswaIds);

        if ($request->filled('search')) {
            $search = trim($request->search);

            $dispenQuery->whereHas('siswa', function ($q) use ($search) {
                $q->where(function ($subQuery) use ($search) {
                    $subQuery->where('nama', 'like', "%{$search}%")
                        ->orWhere('nis', 'like', "%{$search}%")
                        ->orWhere('nisn', 'like', "%{$search}%");
                });
            });
        }

        $dispen = $dispenQuery->get()->map(function (Dispen $item) {
            $alasan = array_filter([$item->kegiatan, $item->alasan]);

            return (object) [
                'id' => $item->id,
                'sumber' => 'dispen',
                'jenis' => 'Dispen',
                'siswa' => $item->siswa,
                'tanggal' => $item->tanggal_mulai,
                'tanggal_selesai' => $item->tanggal_selesai,
                'alasan' => implode(' - ', $alasan),
                'dokumen' => $item->surat,
                'status' => $item->status ?? 'menunggu',
                'catatan' => $item->catatan,
            ];
        });

        $allData = $izin->merge($dispen)
            ->sortByDesc(fn($item) => $item->tanggal)
            ->values();

        if ($request->filled('status') && in_array($request->status, ['menunggu', 'disetujui', 'ditolak'])) {
            $allData = $allData
                ->where('status', $request->status)
                ->values();
        }

        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $data = new LengthAwarePaginator(
            $allData->forPage($currentPage, $perPage),
            $allData->count(),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view(
            'wali-kelas.sakit.index',
            compact('data')
        );
    }

    public function setujui(Perizinan $sakit)
    {
        $guruId = Auth::user()->guru_id;

        abort_unless(
            $sakit->walikelas_id == $guruId,
            403
        );

        $sakit->update([
            'status_walikelas' => 'disetujui',
            'status' => 'disetujui',
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
        Perizinan $sakit
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
