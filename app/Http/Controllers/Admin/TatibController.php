<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tatib;

class TatibController extends Controller
{
    /**
     * Menampilkan daftar master tata tertib.
     */
    public function index()
    {
        $tatib = Tatib::orderBy('poin_pelanggaran', 'asc')
            ->get();

        return view('admin.master-data.tatib.index', compact('tatib'));
    }
}
