<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dispen;
use Illuminate\Http\Request;

class DispenController extends Controller
{
    public function index(Request $request)
    {
        $query = Dispen::with([
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


        $dispen = $query
            ->latest('id')
            ->paginate(20)
            ->appends($request->query());


        return view(
            'admin.dispen.index',
            compact('dispen')
        );
    }


    public function show($id)
    {
        $dispen = Dispen::with([
            'siswa'
        ])->findOrFail($id);


        return view(
            'admin.dispen.show',
            compact('dispen')
        );
    }
}