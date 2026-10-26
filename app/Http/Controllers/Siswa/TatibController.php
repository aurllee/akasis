<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Siswatatib;

class TatibController extends Controller
{
    public function index()
    {
        $siswa = auth()->user()->siswa;
        abort_unless($siswa, 404);

        $riwayat = Siswatatib::query()
            ->with('tatib')
            ->where('id_siswa', $siswa->id)
            ->orderByDesc('tanggal')
            ->paginate(15);

        $totalPoin = Siswatatib::query()
            ->join('tatib', 'siswa_tatib.id_tatib', '=', 'tatib.id')
            ->where('siswa_tatib.id_siswa', $siswa->id)
            ->sum('tatib.poin_pelanggaran');

        return view('siswa.tatib.index', compact('siswa', 'riwayat', 'totalPoin'));
    }
}
