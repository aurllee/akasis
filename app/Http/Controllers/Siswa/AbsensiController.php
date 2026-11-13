<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SesiAbsensi;
use App\Models\Absensi;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    
    public function index()
    {
        return view('siswa.absensi.index');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $sesi = SesiAbsensi::where('token', $request->token)
            ->where('status', 'Dibuka')
            ->first();

        if (!$sesi) {
            return back()->with('error', 'Kode absensi tidak ditemukan atau sudah ditutup.');
        }

        
        $siswa = auth()->user()->siswa;

        
        $sudahAbsen = Absensi::where('sesi_absensi_id', $sesi->id)
            ->where('siswa_id', $siswa->id)
            ->exists();

        if ($sudahAbsen) {
            return back()->with('error', 'Kamu sudah melakukan absensi.');
        }

        
        $sekarang = Carbon::now();

        
        
        
        $status = 'hadir';

        Absensi::create([
            'sesi_absensi_id' => $sesi->id,
            'siswa_id' => $siswa->id,
            'tanggal' => $sekarang->toDateString(),
            'jam_masuk' => $sekarang->format('H:i:s'),
            'status' => $status,
        ]);

        return back()->with('success', 'Absensi berhasil dicatat.');
    }
}