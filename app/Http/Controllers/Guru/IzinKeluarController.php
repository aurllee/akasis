<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IzinKeluar;
use Illuminate\Http\Request;

class IzinKeluarController extends Controller
{
    public function index(Request $request)
    {
        $query = IzinKeluar::with([
            'siswa'
        ]);


        if ($request->filled('search')) {

            $search = $request->search;

            $query->whereHas('siswa', function ($q) use ($search) {

                $q->where(function ($q) use ($search) {

                    $q->where('nama', 'like', "%{$search}%")
                      ->orWhere('nis', 'like', "%{$search}%")
                      ->orWhere('nisn', 'like', "%{$search}%");

                });

            });

        }


        if ($request->filled('status_kesiswaan')) {

            $query->where(
                'status_kesiswaan',
                $request->status_kesiswaan
            );

        }


        $izinKeluar = $query
            ->latest('id')
            ->paginate(20)
            ->withQueryString();


        return view(
            'admin.izin-keluar.index',
            compact('izinKeluar')
        );
    }


    public function show($id)
    {
        $izinKeluar = IzinKeluar::with([
            'siswa'
        ])->findOrFail($id);


        return view(
            'admin.izin-keluar.show',
            compact('izinKeluar')
        );
    }
}