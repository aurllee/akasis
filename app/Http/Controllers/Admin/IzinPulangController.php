<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Perizinan;
use App\Models\Dispen;
use Illuminate\Http\Request;

class IzinPulangController extends Controller
{
    public function index(Request $request)
    {
        $perizinan = Perizinan::with('siswa')
            ->get()
            ->map(function ($item) {
                return (object) [
                    'id' => $item->id,
                    'sumber' => 'perizinan',
                    'siswa' => $item->siswa,
                    'jenis' => ucfirst($item->jenis),
                    'tanggal' => $item->tanggal,
                    'tanggal_mulai' => $item->tanggal,
                    'tanggal_selesai' => $item->tanggal,
                    'jam_mulai' => $item->jam_mulai,
                    'jam_selesai' => $item->jam_selesai,
                    'alasan' => $item->alasan,
                    'dokumen' => $item->dokumen,
                    'status' => $item->status,
                    'catatan' => $item->catatan_walikelas,
                ];
            });

        $dispen = Dispen::with('siswa')
            ->get()
            ->map(function ($item) {
                return (object) [
                    'id' => $item->id,
                    'sumber' => 'dispen',
                    'siswa' => $item->siswa,
                    'jenis' => 'Dispen',
                    'tanggal' => $item->tanggal_mulai,
                    'tanggal_mulai' => $item->tanggal_mulai,
                    'tanggal_selesai' => $item->tanggal_selesai,
                    'jam_mulai' => null,
                    'jam_selesai' => null,
                    'alasan' => $item->alasan,
                    'dokumen' => $item->surat,
                    'status' => $item->status,
                    'catatan' => $item->catatan,
                ];
            });

        $data = $perizinan
            ->merge($dispen)
            ->sortByDesc(function ($item) {
                return $item->tanggal;
            })
            ->values();

        if ($request->filled('search')) {
            $search = strtolower(trim($request->search));

            $data = $data->filter(function ($item) use ($search) {
                return str_contains(strtolower($item->siswa->nama ?? ''), $search)
                    || str_contains(strtolower($item->siswa->nis ?? ''), $search)
                    || str_contains(strtolower($item->siswa->nisn ?? ''), $search);
            })->values();
        }

        if ($request->filled('jenis')) {
            $jenis = strtolower($request->jenis);

            $data = $data->filter(function ($item) use ($jenis) {
                return strtolower($item->jenis) === $jenis;
            })->values();
        }

        if ($request->filled('status')) {
            $status = strtolower($request->status);

            $data = $data->filter(function ($item) use ($status) {
                return strtolower($item->status) === $status;
            })->values();
        }

        $perPage = 20;
        $currentPage = $request->input('page', 1);
        $items = $data->forPage($currentPage, $perPage);

        $izinPulang = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $data->count(),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view(
            'admin.izin-pulang.index',
            compact('izinPulang')
        );
    }

    public function show(Request $request, $id)
    {
        if ($request->query('sumber') === 'dispen') {
            $dispen = Dispen::with('siswa')->findOrFail($id);

            $izinPulang = (object) [
                'siswa' => $dispen->siswa,
                'jenis' => 'dispen',
                'tanggal' => $dispen->tanggal_mulai,
                'tanggal_selesai' => $dispen->tanggal_selesai,
                'jam_mulai' => null,
                'jam_selesai' => null,
                'alasan' => $dispen->alasan ?? $dispen->kegiatan,
                'dokumen' => $dispen->surat,
                'status' => $dispen->status,
                'catatan_walikelas' => $dispen->catatan,
            ];
        } else {
            $izinPulang = Perizinan::with('siswa')->findOrFail($id);
        }

        return view(
            'admin.izin-pulang.show',
            compact('izinPulang')
        );
    }
}
