<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RaporMapelController extends Controller
{
    
private function jadwalGuru($jadwalId)
{
    $user = auth()->user();

    abort_unless($user && $user->guru_id, 403);

    $jadwal = DB::table('jadwal_pelajaran as jp')
        ->join('kelas as k', 'k.id', '=', 'jp.kelas_id')
        ->join('mata_pelajaran as mp', 'mp.id', '=', 'jp.mata_pelajaran_id')
        ->join('tahun_ajaran as ta', 'ta.id', '=', 'k.tahun_ajaran_id')
        ->where('jp.id', $jadwalId)
        ->where('jp.guru_id', $user->guru_id)
        ->select(
            'jp.id as jadwal_id',
            'jp.guru_id',
            'jp.kelas_id',
            'jp.mata_pelajaran_id',
            'k.tingkat',
            'k.nama_kelas',
            'ta.id as tahun_ajaran_id',
            'ta.tahun_ajaran',
            'ta.semester',
            'mp.nama_mapel'
        )
        ->first();

    abort_unless($jadwal !== null, 404);

    return $jadwal;
}
    public function index()
    {
        $user = auth()->user();

        abort_unless($user && $user->guru_id, 403);

        $jadwal = DB::table('jadwal_pelajaran as jp')
            ->join('kelas as k', 'k.id', '=', 'jp.kelas_id')
            ->join('mata_pelajaran as mp', 'mp.id', '=', 'jp.mata_pelajaran_id')
            ->leftJoin('tahun_ajaran as ta', 'ta.id', '=', 'k.tahun_ajaran_id')
            ->where('jp.guru_id', $user->guru_id)
            ->select(
                'jp.id as jadwal_id',
                'k.id as kelas_id',
                'k.tingkat',
                'k.nama_kelas',
                'mp.id as mata_pelajaran_id',
                'mp.nama_mapel',
                'ta.id as tahun_ajaran_id',
                'ta.tahun_ajaran',
                'ta.semester'
            )
            ->orderBy('ta.tahun_ajaran', 'desc')
            ->orderBy('k.tingkat')
            ->orderBy('k.nama_kelas')
            ->orderBy('mp.nama_mapel')
            ->get();

        return view('guru.rapor-mapel.index', compact('jadwal'));
    }



public function input(Request $request, $jadwalId)
{
    $jadwal = $this->jadwalGuru($jadwalId);

    $siswa = DB::table('siswa_kelas as sk')
        ->join('datasiswa as ds', 'ds.id', '=', 'sk.siswa_id')
        ->where('sk.kelas_id', $jadwal->kelas_id)
        ->select('ds.id', 'ds.nis', 'ds.nama')
        ->orderBy('ds.nama')
        ->get();

    $idSiswa = $siswa->pluck('id');

    $nilaiSumber = DB::table('penilaian_mapel')
        ->where('jadwal_pelajaran_id', $jadwal->jadwal_id)
        ->whereIn('siswa_id', $idSiswa)
        ->select('siswa_id', 'jenis_nilai', 'nilai')
        ->get()
        ->groupBy('siswa_id');

    $rekap = $siswa->mapWithKeys(function ($item) use ($nilaiSumber) {
        $nilai = $nilaiSumber->get($item->id, collect());

        $harian = $nilai
            ->where('jenis_nilai', 'harian')
            ->pluck('nilai')
            ->filter(fn ($n) => $n !== null && $n !== '');

        $ujian = $nilai
            ->where('jenis_nilai', 'ujian')
            ->pluck('nilai')
            ->filter(fn ($n) => $n !== null && $n !== '');

        $rataHarian = $harian->isNotEmpty()
            ? round($harian->avg(), 2)
            : null;

        $rataUjian = $ujian->isNotEmpty()
            ? round($ujian->avg(), 2)
            : null;

        $nilaiTersedia = collect([$rataHarian, $rataUjian])
            ->filter(fn ($n) => $n !== null);

        return [
            $item->id => [
                'jumlah_harian' => $harian->count(),
                'jumlah_ujian' => $ujian->count(),
                'rata_harian' => $rataHarian,
                'rata_ujian' => $rataUjian,
                'nilai_awal' => $nilaiTersedia->isNotEmpty()
                    ? round($nilaiTersedia->avg(), 2)
                    : null,
            ],
        ];
    });

    $nilaiAkhirTersimpan = DB::table('nilai_akhir_rapor_mapel')
        ->where('kelas_id', $jadwal->kelas_id)
        ->where('tahun_ajaran_id', $jadwal->tahun_ajaran_id)
        ->where('semester', $jadwal->semester)
        ->where('mata_pelajaran_id', $jadwal->mata_pelajaran_id)
        ->whereIn('siswa_id', $idSiswa)
        ->pluck('nilai_akhir', 'siswa_id');

    return view('guru.rapor-mapel.input', compact(
        'jadwal',
        'siswa',
        'rekap',
        'nilaiAkhirTersimpan'
    ));
}

    
public function store(Request $request, $jadwalId)
{
    $jadwal = $this->jadwalGuru($jadwalId);

    $data = $request->validate([
        'nilai_akhir' => 'required|array',
        'nilai_akhir.*' => 'nullable|numeric|min:0|max:100',
    ]);

    $anggota = DB::table('siswa_kelas')
        ->where('kelas_id', $jadwal->kelas_id)
        ->pluck('siswa_id')
        ->map(fn ($id) => (int) $id)
        ->all();

    $idSiswaDikirim = array_map(
        'intval',
        array_keys($data['nilai_akhir'])
    );

    if (array_diff($idSiswaDikirim, $anggota)) {
        abort(403, 'Terdapat siswa yang bukan anggota kelas ini.');
    }

    $nilaiDiisi = collect($data['nilai_akhir'])
        ->filter(fn ($nilai) => $nilai !== null && $nilai !== '')
        ->keys()
        ->map(fn ($id) => (int) $id)
        ->all();

    $raporFinal = DB::table('rapor_siswa')
        ->where('kelas_id', $jadwal->kelas_id)
        ->where('tahun_ajaran_id', $jadwal->tahun_ajaran_id)
        ->where('semester', $jadwal->semester)
        ->where('status', 'final')
        ->whereIn('siswa_id', $nilaiDiisi)
        ->exists();

    if ($raporFinal) {
        return back()->withInput()->with(
            'error',
            'Nilai tidak disimpan karena ada rapor siswa yang sudah final.'
        );
    }

    DB::transaction(function () use ($data, $jadwal) {
        foreach ($data['nilai_akhir'] as $siswaId => $nilai) {
            if ($nilai === null || $nilai === '') {
                continue;
            }

            $kunci = [
                'siswa_id' => $siswaId,
                'kelas_id' => $jadwal->kelas_id,
                'tahun_ajaran_id' => $jadwal->tahun_ajaran_id,
                'semester' => $jadwal->semester,
                'mata_pelajaran_id' => $jadwal->mata_pelajaran_id,
            ];

            DB::table('nilai_akhir_rapor_mapel')->updateOrInsert(
                $kunci,
                [
                    'nilai_akhir' => round((float) $nilai, 2),
                    'updated_at' => now(),
                    ...(
                        !DB::table('nilai_akhir_rapor_mapel')
                            ->where($kunci)
                            ->exists()
                            ? ['created_at' => now()]
                            : []
                    ),
                ]
            );
        }
    });

    return redirect()
        ->route('guru.rapor-mapel.input', [
            'jadwalId' => $jadwal->jadwal_id,
        ])
        ->with('success', 'Nilai akhir berhasil disimpan.');
}

    public function deskripsi(Request $request, $jadwalId)
    {
        $jadwal = $this->jadwalGuru($jadwalId);

        $siswa = DB::table('siswa_kelas as sk')
            ->join('datasiswa as ds', 'ds.id', '=', 'sk.siswa_id')
            ->where('sk.kelas_id', $jadwal->kelas_id)
            ->select('ds.id', 'ds.nis', 'ds.nama')
            ->orderBy('ds.nama')
            ->get();

        $deskripsiCapaian = DB::table('deskripsi_capaian_mapel')
            ->where('kelas_id', $jadwal->kelas_id)
            ->where('tahun_ajaran_id', $jadwal->tahun_ajaran_id)
            ->where('semester', $jadwal->semester)
            ->where('mata_pelajaran_id', $jadwal->mata_pelajaran_id)
            ->pluck('deskripsi_capaian', 'siswa_id');

        $jumlahNilai = DB::table('penilaian_mapel')
            ->select('siswa_id', DB::raw('COUNT(*) as jumlah'))
            ->where('jadwal_pelajaran_id', $jadwal->jadwal_id)
            ->where('sumber_input', 'rapor_mapel')
            ->whereIn('siswa_id', $siswa->pluck('id'))
            ->groupBy('siswa_id')
            ->pluck('jumlah', 'siswa_id');

        return view('guru.rapor-mapel.deskripsi', compact(
            'jadwal',
            'siswa',
            'deskripsiCapaian',
            'jumlahNilai'
        ));
    }

    public function storeDeskripsi(Request $request, $jadwalId)
    {
        $jadwal = $this->jadwalGuru($jadwalId);

        $data = $request->validate([
            'deskripsi_capaian' => 'required|array',
            'deskripsi_capaian.*' => 'nullable|string|max:2000',
        ]);

        $anggota = DB::table('siswa_kelas')
            ->where('kelas_id', $jadwal->kelas_id)
            ->pluck('siswa_id')
            ->map(fn ($id) => (int) $id)
            ->all();

        $idSiswaDikirim = array_map(
            'intval',
            array_keys($data['deskripsi_capaian'])
        );

        if (array_diff($idSiswaDikirim, $anggota)) {
            abort(403, 'Terdapat siswa yang bukan anggota kelas ini.');
        }

        $raporFinal = DB::table('rapor_siswa')
            ->where('kelas_id', $jadwal->kelas_id)
            ->where('tahun_ajaran_id', $jadwal->tahun_ajaran_id)
            ->where('semester', $jadwal->semester)
            ->where('status', 'final')
            ->whereIn('siswa_id', $anggota)
            ->exists();

        if ($raporFinal) {
            return back()->withInput()->with(
                'error',
                'Ada rapor siswa yang sudah final. Deskripsi tidak disimpan agar rapor final tidak berubah.'
            );
        }

        DB::transaction(function () use ($data, $jadwal) {
            foreach ($data['deskripsi_capaian'] as $siswaId => $deskripsi) {
                $deskripsi = trim($deskripsi ?? '');

                $kunci = [
                    'siswa_id' => $siswaId,
                    'kelas_id' => $jadwal->kelas_id,
                    'tahun_ajaran_id' => $jadwal->tahun_ajaran_id,
                    'semester' => $jadwal->semester,
                    'mata_pelajaran_id' => $jadwal->mata_pelajaran_id,
                ];

                $sudahAda = DB::table('deskripsi_capaian_mapel')
                    ->where($kunci)
                    ->exists();

                DB::table('deskripsi_capaian_mapel')->updateOrInsert(
                    $kunci,
                    [
                        'deskripsi_capaian' => $deskripsi !== '' ? $deskripsi : null,
                        'updated_at' => now(),
                        ...(!$sudahAda ? ['created_at' => now()] : []),
                    ]
                );
            }
        });

        return redirect()
            ->route('guru.rapor-mapel.deskripsi', ['jadwalId' => $jadwal->jadwal_id])
            ->with('success', 'Deskripsi capaian berhasil disimpan.');
    }

    public function detail($jadwalId)
{
    $jadwal = $this->jadwalGuru($jadwalId);

    $siswa = DB::table('siswa_kelas as sk')
        ->join('datasiswa as ds', 'ds.id', '=', 'sk.siswa_id')
        ->where('sk.kelas_id', $jadwal->kelas_id)
        ->select('ds.id as siswa_id', 'ds.nis', 'ds.nama')
        ->orderBy('ds.nama')
        ->get();

    $nilai = DB::table('penilaian_mapel as pm')
    ->join('datasiswa as ds', 'ds.id', '=', 'pm.siswa_id')
    ->where('pm.sumber_input', 'rapor_mapel')
    ->where('pm.jadwal_pelajaran_id', $jadwal->jadwal_id)
    ->whereIn('pm.siswa_id', $siswa->pluck('siswa_id'))
    ->select(
        'pm.id',
        'pm.jadwal_pelajaran_id',
        'pm.siswa_id',
        'ds.nis',
        'ds.nama',
        'pm.jenis_nilai',
        'pm.judul_tugas',
        'pm.nilai',
        'pm.tanggal_penilaian',
        'pm.created_at',
        'pm.updated_at'
    )
    ->orderByDesc('pm.tanggal_penilaian')
    ->orderBy('ds.nama')
    ->orderBy('pm.jenis_nilai')
    ->get();

    $rekap = $nilai->groupBy('siswa_id')->map(function ($items) {
        $harian = $items->where('jenis_nilai', 'harian')->pluck('nilai');
        $ujian = $items->where('jenis_nilai', 'ujian')->pluck('nilai');

        return [
            'jumlah' => $items->count(),
            'harian' => $harian->count()
                ? round($harian->avg(), 2)
                : null,
            'ujian' => $ujian->count()
                ? round($ujian->avg(), 2)
                : null,
            'rata_rata' => round($items->avg('nilai'), 2),
        ];
    });

    return view('guru.rapor-mapel.detail', compact(
        'jadwal',
        'siswa',
        'nilai',
        'rekap'
    ));
}

public function permintaanRevisi()
{
    $user = auth()->user();

    abort_unless($user && $user->guru_id, 403);

    $permintaan = DB::table('permintaan_revisi_rapor as pr')
        ->join('datasiswa as ds', 'ds.id', '=', 'pr.siswa_id')
        ->join('kelas as k', 'k.id', '=', 'pr.kelas_id')
        ->join('mata_pelajaran as mp', 'mp.id', '=', 'pr.mata_pelajaran_id')
        ->join('tahun_ajaran as ta', 'ta.id', '=', 'pr.tahun_ajaran_id')
        ->leftJoin('nilai_akhir_rapor_mapel as na', function ($join) {
            $join->on('na.siswa_id', '=', 'pr.siswa_id')
                ->on('na.kelas_id', '=', 'pr.kelas_id')
                ->on('na.tahun_ajaran_id', '=', 'pr.tahun_ajaran_id')
                ->on('na.semester', '=', 'pr.semester')
                ->on('na.mata_pelajaran_id', '=', 'pr.mata_pelajaran_id');
        })
        ->leftJoin('deskripsi_capaian_mapel as dc', function ($join) {
            $join->on('dc.siswa_id', '=', 'pr.siswa_id')
                ->on('dc.kelas_id', '=', 'pr.kelas_id')
                ->on('dc.tahun_ajaran_id', '=', 'pr.tahun_ajaran_id')
                ->on('dc.semester', '=', 'pr.semester')
                ->on('dc.mata_pelajaran_id', '=', 'pr.mata_pelajaran_id');
        })
        ->leftJoin('rapor_detail as rd', function ($join) {
            $join->on('rd.rapor_id', '=', 'pr.rapor_id')
                ->on('rd.mata_pelajaran_id', '=', 'pr.mata_pelajaran_id');
        })
        ->where('pr.guru_id', $user->guru_id)
        ->select(
            'pr.id',
            'pr.rapor_id',
            'pr.siswa_id',
            'pr.kelas_id',
            'pr.tahun_ajaran_id',
            'pr.semester',
            'pr.mata_pelajaran_id',
            'pr.alasan_revisi',
            'pr.status',
            'pr.created_at',
            'ds.nama as nama_siswa',
            'ds.nis',
            'k.tingkat',
            'k.nama_kelas',
            'ta.tahun_ajaran',
            'mp.nama_mapel',
            'na.nilai_akhir as nilai_akhir_tersimpan',
            'dc.deskripsi_capaian as deskripsi_tersimpan',
            'rd.nilai_akhir as nilai_akhir_rapor',
            'rd.deskripsi_capaian as deskripsi_rapor'
        )
        ->orderByRaw("CASE WHEN pr.status = 'menunggu' THEN 0 ELSE 1 END")
        ->orderByDesc('pr.created_at')
        ->get();

    return view('guru.rapor-mapel.permintaan-revisi', compact('permintaan'));
}

public function simpanRevisi(Request $request, $id)
{
    $user = auth()->user();

    abort_unless($user && $user->guru_id, 403);

    $data = $request->validate([
        'nilai_akhir' => 'required|numeric|min:0|max:100',
        'deskripsi_capaian' => 'required|string|max:5000',
    ]);

    $permintaan = DB::table('permintaan_revisi_rapor')
        ->where('id', $id)
        ->where('guru_id', $user->guru_id)
        ->first();

    abort_if(!$permintaan, 404, 'Permintaan revisi tidak ditemukan.');

    if ($permintaan->status === 'selesai') {
        return back()->with(
            'error',
            'Permintaan revisi ini sudah diselesaikan.'
        );
    }

    $rapor = DB::table('rapor_siswa')
        ->where('id', $permintaan->rapor_id)
        ->first();

    abort_if(!$rapor, 404, 'Rapor tidak ditemukan.');

    if ($rapor->status === 'final') {
        return back()->with(
            'error',
            'Rapor sudah final dan tidak dapat diubah.'
        );
    }

    $kunciNilai = [
        'siswa_id' => $permintaan->siswa_id,
        'kelas_id' => $permintaan->kelas_id,
        'tahun_ajaran_id' => $permintaan->tahun_ajaran_id,
        'semester' => $permintaan->semester,
        'mata_pelajaran_id' => $permintaan->mata_pelajaran_id,
    ];

    $kunciDeskripsi = $kunciNilai;

    DB::transaction(function () use (
        $permintaan,
        $data,
        $kunciNilai,
        $kunciDeskripsi
    ) {
        $nilaiAda = DB::table('nilai_akhir_rapor_mapel')
            ->where($kunciNilai)
            ->exists();

        $dataNilai = [
            'nilai_akhir' => round((float) $data['nilai_akhir'], 2),
            'updated_at' => now(),
        ];

        if (!$nilaiAda) {
            $dataNilai['created_at'] = now();
        }

        DB::table('nilai_akhir_rapor_mapel')->updateOrInsert(
            $kunciNilai,
            $dataNilai
        );

        $deskripsiAda = DB::table('deskripsi_capaian_mapel')
            ->where($kunciDeskripsi)
            ->exists();

        $dataDeskripsi = [
            'deskripsi_capaian' => $data['deskripsi_capaian'],
            'updated_at' => now(),
        ];

        if (!$deskripsiAda) {
            $dataDeskripsi['created_at'] = now();
        }

        DB::table('deskripsi_capaian_mapel')->updateOrInsert(
            $kunciDeskripsi,
            $dataDeskripsi
        );

        DB::table('permintaan_revisi_rapor')
            ->where('id', $permintaan->id)
            ->update([
                'status' => 'selesai',
                'updated_at' => now(),
            ]);
    });

    return redirect()
        ->route('guru.rapor-mapel.permintaan-revisi')
        ->with(
            'success',
            'Revisi nilai akhir dan deskripsi capaian berhasil disimpan.'
        );
}

}
