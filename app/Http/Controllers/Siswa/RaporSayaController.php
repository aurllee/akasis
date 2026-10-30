<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RaporSayaController extends Controller
{
    private function siswaLogin()
    {
        $user = auth()->user();

        abort_unless($user && (int) $user->role_id === 5, 403);

        $siswa = DB::table('datasiswa')
            ->where('nis', $user->username)
            ->first();

        abort_unless($siswa !== null, 404, 'Data siswa tidak ditemukan.');

        return $siswa;
    }

    public function index()
    {
        $siswa = $this->siswaLogin();

        $rapor = DB::table('rapor_siswa as r')
            ->join('kelas as k', 'k.id', '=', 'r.kelas_id')
            ->join('tahun_ajaran as ta', 'ta.id', '=', 'r.tahun_ajaran_id')
            ->where('r.siswa_id', $siswa->id)
            ->where('r.status', 'final')
            ->whereNotNull('r.dipublikasikan_at')
            ->select(
                'r.id',
                'r.semester',
                'r.status',
                'r.dipublikasikan_at',
                'r.catatan_wali_kelas',
                'k.tingkat',
                'k.nama_kelas',
                'ta.tahun_ajaran'
            )
            ->orderByDesc('r.dipublikasikan_at')
            ->get();

        return view('siswa.rapor.index', compact('siswa', 'rapor'));
    }

    public function detail($raporId)
    {
        $siswa = $this->siswaLogin();

        $rapor = DB::table('rapor_siswa as r')
            ->join('kelas as k', 'k.id', '=', 'r.kelas_id')
            ->join('tahun_ajaran as ta', 'ta.id', '=', 'r.tahun_ajaran_id')
            ->where('r.id', $raporId)
            ->where('r.siswa_id', $siswa->id)
            ->where('r.status', 'final')
            ->whereNotNull('r.dipublikasikan_at')
            ->select(
                'r.*',
                'k.tingkat',
                'k.nama_kelas',
                'ta.tahun_ajaran'
            )
            ->first();

        abort_unless($rapor !== null, 404);

        $detail = DB::table('rapor_detail as rd')
    ->leftJoin(
        'mata_pelajaran as mp',
        'mp.id',
        '=',
        'rd.mata_pelajaran_id'
    )
    ->where('rd.rapor_id', $rapor->id)
    ->select(
        'rd.*',
        'mp.nama_mapel'
    )
    ->get();

        return view(
            'siswa.rapor.detail',
            compact('siswa', 'rapor', 'detail')
        );
    }
}
