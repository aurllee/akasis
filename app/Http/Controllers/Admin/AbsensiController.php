<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $query = Absensi::with([
            'siswa',
            'sesi.jadwal'
        ]);


        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $absensi = $query
            ->latest('jam_masuk')
            ->paginate(20)
            ->appends($request->query());

        return view('admin.absensi.index', compact('absensi'));
    }

    public function show($id)
    {
        $absensi = Absensi::with([
            'siswa',
            'sesi.jadwal',
        ])->findOrFail($id);

        return view('admin.absensi.show', compact('absensi'));
    }
}
