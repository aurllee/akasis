<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringRaporController extends Controller
{
    public function index(Request $request)
    {
        $tahunAjaranId = $request->input('tahun_ajaran_id');
        $semester = $request->input('semester');
        $kelasId = $request->input('kelas_id');
        $cari = trim($request->input('cari', ''));

        $tahunAjaran = DB::table('tahun_ajaran')
            ->orderByDesc('id')
            ->get();

        $kelas = DB::table('kelas')
            ->orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->get();

        $filterRapor = function ($query) use (
            $tahunAjaranId,
            $semester,
            $kelasId,
            $cari
        ) {
            if ($tahunAjaranId) {
                $query->where('rs.tahun_ajaran_id', $tahunAjaranId);
            }

            if ($semester) {
                $query->where('rs.semester', $semester);
            }

            if ($kelasId) {
                $query->where('rs.kelas_id', $kelasId);
            }

            if ($cari !== '') {
                $query->where(function ($q) use ($cari) {
                    $q->where('ds.nama', 'like', "%{$cari}%")
                        ->orWhere('ds.nis', 'like', "%{$cari}%");
                });
            }

            return $query;
        };

        $queryRapor = DB::table('rapor_siswa as rs')
            ->leftJoin('datasiswa as ds', 'ds.id', '=', 'rs.siswa_id')
            ->leftJoin('kelas as k', 'k.id', '=', 'rs.kelas_id')
            ->leftJoin('tahun_ajaran as ta', 'ta.id', '=', 'rs.tahun_ajaran_id')
            ->leftJoin('dataguru as dg', 'dg.id', '=', 'k.wali_kelas_id')
            ->select(
                'rs.id',
                'rs.siswa_id',
                'rs.kelas_id',
                'rs.tahun_ajaran_id',
                'rs.semester',
                'rs.status',
                'rs.deskripsi_capaian',
                'rs.catatan_wali_kelas',
                'rs.finalized_at',
                'ds.nama as nama_siswa',
                'ds.nis',
                'k.tingkat',
                'k.nama_kelas',
                'ta.tahun_ajaran',
                'dg.nama as nama_wali_kelas'
            );

        $filterRapor($queryRapor);

        $rapor = $queryRapor
            ->orderBy('k.tingkat')
            ->orderBy('k.nama_kelas')
            ->orderBy('ds.nama')
            ->paginate(10)
            ->appends($request->query());

        $raporIds = collect($rapor->items())->pluck('id');

        $detailNilai = collect();

        if ($raporIds->isNotEmpty()) {
            $detailNilai = DB::table('rapor_detail as rd')
                ->leftJoin('mata_pelajaran as mp', 'mp.id', '=', 'rd.mata_pelajaran_id')
                ->whereIn('rd.rapor_id', $raporIds)
                ->select(
                    'rd.id',
                    'rd.rapor_id',
                    'rd.mata_pelajaran_id',
                    'rd.nilai_mapel',
                    'rd.nilai_pjbl',
                    'rd.nilai_akhir',
                    'rd.status',
                    'rd.deskripsi_capaian',
                    'mp.nama_mapel',
                    'mp.kode_mapel'
                )
                ->orderBy('mp.nama_mapel')
                ->get()
                ->groupBy('rapor_id');
        }

        foreach ($rapor->items() as $item) {
            $item->detail_nilai = $detailNilai->get($item->id, collect());
        }

        $queryStatistik = DB::table('rapor_siswa as rs');

        if ($tahunAjaranId) {
            $queryStatistik->where('rs.tahun_ajaran_id', $tahunAjaranId);
        }

        if ($semester) {
            $queryStatistik->where('rs.semester', $semester);
        }

        if ($kelasId) {
            $queryStatistik->where('rs.kelas_id', $kelasId);
        }

        $statistik = (clone $queryStatistik)
            ->selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN status = 'draft' THEN 1 ELSE 0 END) as draft,
                SUM(CASE WHEN status = 'perlu_revisi' THEN 1 ELSE 0 END) as perlu_revisi,
                SUM(CASE WHEN status = 'final' THEN 1 ELSE 0 END) as final
            ")
            ->first();

        $queryRekapKelas = DB::table('rapor_siswa as rs')
            ->leftJoin('kelas as k', 'k.id', '=', 'rs.kelas_id')
            ->leftJoin('rapor_detail as rd', 'rd.rapor_id', '=', 'rs.id')
            ->select(
                'rs.kelas_id',
                'k.tingkat',
                'k.nama_kelas'
            )
            ->selectRaw('COUNT(DISTINCT rs.id) as jumlah_rapor')
            ->selectRaw("COUNT(DISTINCT CASE WHEN rs.status = 'final' THEN rs.id END) as jumlah_final")
->selectRaw("COUNT(DISTINCT CASE WHEN rs.status = 'draft' THEN rs.id END) as jumlah_draft")
->selectRaw("COUNT(DISTINCT CASE WHEN rs.status = 'perlu_revisi' THEN rs.id END) as jumlah_revisi")
            ->selectRaw('AVG(CASE WHEN rs.status = \'final\' THEN rd.nilai_akhir ELSE NULL END) as rata_rata_nilai')
            ->groupBy('rs.kelas_id', 'k.tingkat', 'k.nama_kelas');

        if ($tahunAjaranId) {
            $queryRekapKelas->where('rs.tahun_ajaran_id', $tahunAjaranId);
        }

        if ($semester) {
            $queryRekapKelas->where('rs.semester', $semester);
        }

        if ($kelasId) {
            $queryRekapKelas->where('rs.kelas_id', $kelasId);
        }

        $rekapKelas = $queryRekapKelas
            ->orderBy('k.tingkat')
            ->orderBy('k.nama_kelas')
            ->get();

        $queryRevisi = DB::table('permintaan_revisi_rapor as pr')
            ->leftJoin('datasiswa as ds', 'ds.id', '=', 'pr.siswa_id')
            ->leftJoin('kelas as k', 'k.id', '=', 'pr.kelas_id')
            ->leftJoin('tahun_ajaran as ta', 'ta.id', '=', 'pr.tahun_ajaran_id')
            ->leftJoin('mata_pelajaran as mp', 'mp.id', '=', 'pr.mata_pelajaran_id')
            ->leftJoin('dataguru as dg', 'dg.id', '=', 'pr.guru_id')
            ->select(
                'pr.id',
                'pr.siswa_id',
                'pr.kelas_id',
                'pr.tahun_ajaran_id',
                'pr.semester',
                'pr.alasan_revisi',
                'pr.status',
                'pr.created_at',
                'ds.nama as nama_siswa',
                'ds.nis',
                'k.tingkat',
                'k.nama_kelas',
                'ta.tahun_ajaran',
                'mp.nama_mapel',
                'dg.nama as nama_guru'
            );

        if ($tahunAjaranId) {
            $queryRevisi->where('pr.tahun_ajaran_id', $tahunAjaranId);
        }

        if ($semester) {
            $queryRevisi->where('pr.semester', $semester);
        }

        if ($kelasId) {
            $queryRevisi->where('pr.kelas_id', $kelasId);
        }

        if ($cari !== '') {
            $queryRevisi->where(function ($q) use ($cari) {
                $q->where('ds.nama', 'like', "%{$cari}%")
                    ->orWhere('ds.nis', 'like', "%{$cari}%")
                    ->orWhere('mp.nama_mapel', 'like', "%{$cari}%")
                    ->orWhere('dg.nama', 'like', "%{$cari}%")
                    ->orWhere('pr.alasan_revisi', 'like', "%{$cari}%");
            });
        }

        $permintaanRevisi = $queryRevisi
            ->orderByRaw("CASE WHEN pr.status = 'menunggu' THEN 0 ELSE 1 END")
            ->orderByDesc('pr.created_at')
            ->paginate(10, ['*'], 'halaman_revisi')
            ->appends($request->query());

        return view('admin.rapor.index', compact(
            'tahunAjaran',
            'kelas',
            'rapor',
            'statistik',
            'rekapKelas',
            'permintaanRevisi',
            'tahunAjaranId',
            'semester',
            'kelasId',
            'cari'
        ));
    }
}
