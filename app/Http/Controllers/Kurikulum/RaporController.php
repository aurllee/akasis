<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RaporController extends Controller
{
    /**
     * Menampilkan monitoring rapor seluruh kelas.
     */
    public function index(Request $request)
    {
        $tahunAjaran = TahunAjaran::where('status', 1)
            ->orderByDesc('id')
            ->first();

        // Kelas pada tahun ajaran aktif yang sudah memiliki wali kelas.
        $querySemua = Kelas::with([
            'jurusan',
            'waliKelas',
            'tahunAjaran',
        ])
            ->withCount('siswaKelas')
            ->whereHas('waliKelas')
            ->when(
                $tahunAjaran,
                fn($query) => $query->where(
                    'tahun_ajaran_id',
                    $tahunAjaran->id
                ),
                fn($query) => $query->whereRaw('1 = 0')
            )
            ->orderBy('tingkat')
            ->orderBy('nama_kelas');

        // Ambil seluruh kelas untuk statistik sekolah.
        $semuaKelas = (clone $querySemua)->get();

        $this->hitungProgressKelas($semuaKelas);

        $totalKelas = $semuaKelas->count();

        $jumlahBelumFinal = $semuaKelas
            ->filter(fn($item) => !$item->rapor_difinalisasi)
            ->count();

        $jumlahSiapRilis = $semuaKelas
            ->filter(
                fn($item) =>
                $item->nilai_lengkap
                    && $item->rapor_difinalisasi
                    && $item->nilai_dikunci
                    && !$item->rapor_diterbitkan
            )
            ->count();

        $jumlahSudahTerbit = $semuaKelas
            ->filter(fn($item) => $item->rapor_diterbitkan)
            ->count();

        $progressSekolah = $totalKelas > 0
            ? (int) round($semuaKelas->avg('cakupan_nilai'))
            : 0;

        // Daftar jurusan untuk filter.
        $jurusan = $semuaKelas
            ->pluck('jurusan')
            ->filter()
            ->unique('id')
            ->sortBy('nama_jurusan')
            ->values();

        // Filter jenjang X, XI, dan XII.
        $jenjang = $request->query('jenjang', 'semua');

        $tingkatMap = [
            '10' => [10, '10', 'X', 'x'],
            '11' => [11, '11', 'XI', 'xi'],
            '12' => [12, '12', 'XII', 'xii'],
        ];

        $query = clone $querySemua;

        if (isset($tingkatMap[$jenjang])) {
            $query->whereIn('tingkat', $tingkatMap[$jenjang]);
        }

        // Pencarian nama kelas, jurusan, atau wali kelas.
        $cari = trim((string) $request->query('cari', ''));

        if ($cari !== '') {
            $query->where(function ($subQuery) use ($cari) {
                $subQuery
                    ->where('nama_kelas', 'like', "%{$cari}%")
                    ->orWhereHas('jurusan', function ($jurusanQuery) use ($cari) {
                        $jurusanQuery->where(
                            'nama_jurusan',
                            'like',
                            "%{$cari}%"
                        );
                    })
                    ->orWhereHas('waliKelas', function ($waliQuery) use ($cari) {
                        $waliQuery->where(
                            'nama',
                            'like',
                            "%{$cari}%"
                        );
                    });
            });
        }

        // Filter jurusan.
        $filterJurusan = $request->query('jurusan', '');

        if ($filterJurusan !== '') {
            $query->where('jurusan_id', $filterJurusan);
        }

        // Filter status rapor.
        $status = $request->query('status', 'semua');

        if ($status === 'belum_final') {
            $query->where(function ($q) {
                $q->where('rapor_difinalisasi', false)
                    ->orWhereNull('rapor_difinalisasi');
            });
        } elseif ($status === 'diterbitkan') {
            $query->where('rapor_diterbitkan', true);
        } elseif ($status === 'belum_terbit') {
            $query->where(function ($q) {
                $q->where('rapor_diterbitkan', false)
                    ->orWhereNull('rapor_diterbitkan');
            });
        } elseif ($status === 'siap_rilis') {
            $idSiapRilis = $semuaKelas
                ->filter(
                    fn($item) =>
                    $item->nilai_lengkap
                        && $item->rapor_difinalisasi
                        && $item->nilai_dikunci
                        && !$item->rapor_diterbitkan
                )
                ->pluck('id')
                ->all();

            $query->whereIn('id', $idSiapRilis);
        }

        // Pagination tabel monitoring.
        $kelas = $query
            ->paginate(10)
            ->withQueryString();

        // Hitung progress untuk kelas pada halaman aktif.
        $kelasHalaman = $kelas->getCollection();

        $this->hitungProgressKelas($kelasHalaman);

        $kelas->setCollection($kelasHalaman);

        return view('kurikulum.rapor.index', compact(
            'tahunAjaran',
            'kelas',
            'semuaKelas',
            'jurusan',
            'jenjang',
            'cari',
            'filterJurusan',
            'status',
            'totalKelas',
            'jumlahBelumFinal',
            'jumlahSiapRilis',
            'jumlahSudahTerbit',
            'progressSekolah'
        ));
    }

    /**
     * Menampilkan progres nilai per mata pelajaran dalam satu kelas.
     */
    public function detail(Kelas $kelas)
    {
        $tahunAjaran = TahunAjaran::where('status', 1)
            ->orderByDesc('id')
            ->firstOrFail();

        $kelas = Kelas::with([
            'jurusan',
            'tahunAjaran',
        ])
            ->where('tahun_ajaran_id', $tahunAjaran->id)
            ->whereHas('waliKelas')
            ->findOrFail($kelas->id);

        $siswaIds = $kelas->siswaKelas()
            ->distinct()
            ->pluck('siswa_id')
            ->all();
        $jumlahSiswa = count($siswaIds);

        $mataPelajaran = MataPelajaran::whereHas('jadwal', function ($query) use ($kelas) {
            $query->where('kelas_id', $kelas->id);
        })
            ->orderBy('nama_mapel')
            ->get();

        $dataPenilaian = collect();

        if ($mataPelajaran->isNotEmpty()) {
            $dataPenilaian = DB::table('penilaian_mapel')
                ->join(
                    'jadwal_pelajaran',
                    'jadwal_pelajaran.id',
                    '=',
                    'penilaian_mapel.jadwal_pelajaran_id'
                )
                ->where('jadwal_pelajaran.kelas_id', $kelas->id)
                ->whereIn(
                    'jadwal_pelajaran.mata_pelajaran_id',
                    $mataPelajaran->modelKeys()
                )
                ->select([
                    'jadwal_pelajaran.mata_pelajaran_id',
                    'penilaian_mapel.jadwal_pelajaran_id',
                    'penilaian_mapel.siswa_id',
                    'penilaian_mapel.jenis_nilai',
                    'penilaian_mapel.tanggal_penilaian',
                    'penilaian_mapel.judul_tugas',
                    'penilaian_mapel.nilai',
                ])
                ->get();
        }

        $slotKey = function ($record) {
            return json_encode([
                (int) $record->jadwal_pelajaran_id,
                (string) ($record->jenis_nilai ?? ''),
                $record->tanggal_penilaian ?? '',
                (string) ($record->judul_tugas ?? ''),
            ], JSON_THROW_ON_ERROR);
        };

        $komponenPerMapel = [];
        $nilaiSiswaPerMapel = [];
        $siswaIdsKelas = array_fill_keys(
            array_map('intval', $siswaIds),
            true
        );

        foreach ($dataPenilaian as $record) {
            $mapelId = (int) $record->mata_pelajaran_id;
            $key = $slotKey($record);

            $komponenPerMapel[$mapelId][$key] = true;

            $siswaId = (int) $record->siswa_id;

            if ($record->nilai !== null && isset($siswaIdsKelas[$siswaId])) {
                $nilaiSiswaPerMapel[$mapelId][$siswaId][$key] = true;
            }
        }

        $mataPelajaran->each(function ($mapel) use (
            $siswaIds,
            $jumlahSiswa,
            $komponenPerMapel,
            $nilaiSiswaPerMapel
        ) {
            $jumlahKomponen = count(
                $komponenPerMapel[$mapel->id] ?? []
            );
            $jumlahKomponenTerisi = 0;
            $jumlahSiswaLengkap = 0;
            $jumlahSiswaSebagian = 0;
            $jumlahSiswaTanpaNilai = 0;

            foreach ($siswaIds as $siswaId) {
                $jumlahTerisiSiswa = count(
                    $nilaiSiswaPerMapel[$mapel->id][$siswaId] ?? []
                );
                $jumlahKomponenTerisi += $jumlahTerisiSiswa;

                if ($jumlahKomponen > 0 && $jumlahTerisiSiswa >= $jumlahKomponen) {
                    $jumlahSiswaLengkap++;
                } elseif ($jumlahTerisiSiswa > 0) {
                    $jumlahSiswaSebagian++;
                } else {
                    $jumlahSiswaTanpaNilai++;
                }
            }

            $targetKomponen = $jumlahSiswa * $jumlahKomponen;

            $mapel->jumlah_komponen = $jumlahKomponen;
            $mapel->jumlah_komponen_terisi = $jumlahKomponenTerisi;
            $mapel->jumlah_komponen_target = $targetKomponen;
            $mapel->jumlah_siswa_lengkap = $jumlahSiswaLengkap;
            $mapel->jumlah_siswa_sebagian = $jumlahSiswaSebagian;
            $mapel->jumlah_siswa_tanpa_nilai = $jumlahSiswaTanpaNilai;
            $mapel->progress_persen = $targetKomponen > 0
                ? (int) round(
                    $jumlahKomponenTerisi / $targetKomponen * 100
                )
                : 0;
        });

        $siswa = $kelas->siswaKelas()
            ->with('siswa')
            ->get()
            ->pluck('siswa')
            ->filter()
            ->unique('id')
            ->sortBy('nama')
            ->values();

        $jumlahKomponenKelas = collect($komponenPerMapel)
            ->sum(fn($komponen) => count($komponen));
        $siswa->each(function ($item) use (
            $komponenPerMapel,
            $nilaiSiswaPerMapel,
            $jumlahKomponenKelas
        ) {
            $jumlahKomponenTerisi = 0;

            foreach ($komponenPerMapel as $mapelId => $komponen) {
                $jumlahKomponenTerisi += count(
                    $nilaiSiswaPerMapel[$mapelId][$item->id] ?? []
                );
            }

            $item->status_rapor = $jumlahKomponenKelas === 0
                ? 'Belum ada komponen penilaian'
                : ($jumlahKomponenTerisi >= $jumlahKomponenKelas
                    ? 'Lengkap'
                    : ($jumlahKomponenTerisi > 0 ? 'Sebagian' : 'Belum ada nilai'));
        });

        return view('kurikulum.rapor.detail', compact(
            'kelas',
            'tahunAjaran',
            'jumlahSiswa',
            'mataPelajaran',
            'siswa'
        ));
    }

    /**
     * Menampilkan rapor digital siswa pada kelas dan tahun ajaran tertentu.
     */
    public function siswaRapor(Kelas $kelas, Siswa $siswa)
    {
        $tahunAjaran = TahunAjaran::where('status', 1)
            ->orderByDesc('id')
            ->firstOrFail();

        $kelas = Kelas::with(['jurusan', 'tahunAjaran', 'waliKelas'])
            ->where('tahun_ajaran_id', $tahunAjaran->id)
            ->findOrFail($kelas->id);

        abort_unless(
            $kelas->siswaKelas()->where('siswa_id', $siswa->id)->exists(),
            404
        );

        $mataPelajaran = MataPelajaran::whereHas('jadwal', function ($query) use ($kelas) {
            $query->where('kelas_id', $kelas->id);
        })
            ->with(['jadwal' => fn($query) => $query->where('kelas_id', $kelas->id)])
            ->orderBy('nama_mapel')
            ->get();

        $nilaiPerMapel = DB::table('penilaian_mapel')
            ->join(
                'jadwal_pelajaran',
                'jadwal_pelajaran.id',
                '=',
                'penilaian_mapel.jadwal_pelajaran_id'
            )
            ->where('jadwal_pelajaran.kelas_id', $kelas->id)
            ->where('penilaian_mapel.siswa_id', $siswa->id)
            ->whereNotNull('penilaian_mapel.nilai')
            ->select('jadwal_pelajaran.mata_pelajaran_id')
            ->selectRaw('AVG(penilaian_mapel.nilai) as nilai_akhir')
            ->groupBy('jadwal_pelajaran.mata_pelajaran_id')
            ->get()
            ->keyBy('mata_pelajaran_id');

        $rekapAbsensi = DB::table('absensi')
            ->join(
                'sesi_absensi',
                'sesi_absensi.id',
                '=',
                'absensi.sesi_absensi_id'
            )
            ->join(
                'jadwal_pelajaran',
                'jadwal_pelajaran.id',
                '=',
                'sesi_absensi.jadwal_pelajaran_id'
            )
            ->where('jadwal_pelajaran.kelas_id', $kelas->id)
            ->where('absensi.siswa_id', $siswa->id)
            ->selectRaw('LOWER(absensi.status) as status, COUNT(*) as jumlah')
            ->groupByRaw('LOWER(absensi.status)')
            ->pluck('jumlah', 'status');

        return view('kurikulum.rapor.siswa', [
            'kelas' => $kelas,
            'tahunAjaran' => $tahunAjaran,
            'siswa' => $siswa,
            'mataPelajaran' => $mataPelajaran,
            'nilaiPerMapel' => $nilaiPerMapel,
            'rekapAbsensi' => $rekapAbsensi,
            'namaSekolah' => config('app.school_name'),
        ]);
    }

    /**
     * Menghitung progress nilai berdasarkan pasangan siswa dan mapel.
     */
    private function hitungProgressKelas($kelas)
    {
        if ($kelas->isEmpty()) {
            return;
        }

        $idsKelas = $kelas->modelKeys();

        // Jumlah mata pelajaran unik yang dijadwalkan pada setiap kelas.
        $mapelPerKelas = DB::table('jadwal_pelajaran')
            ->whereIn('kelas_id', $idsKelas)
            ->select('kelas_id')
            ->selectRaw(
                'COUNT(DISTINCT mata_pelajaran_id) as jumlah_mapel'
            )
            ->groupBy('kelas_id')
            ->get()
            ->keyBy('kelas_id');

        // Jumlah pasangan siswa-mapel yang sudah mempunyai nilai.
        $nilaiPerKelas = DB::table('penilaian_mapel')
            ->join(
                'jadwal_pelajaran',
                'jadwal_pelajaran.id',
                '=',
                'penilaian_mapel.jadwal_pelajaran_id'
            )
            ->join('siswa_kelas', function ($join) {
                $join->on(
                    'siswa_kelas.siswa_id',
                    '=',
                    'penilaian_mapel.siswa_id'
                )->on(
                    'siswa_kelas.kelas_id',
                    '=',
                    'jadwal_pelajaran.kelas_id'
                );
            })
            ->whereIn('jadwal_pelajaran.kelas_id', $idsKelas)
            ->whereNotNull('penilaian_mapel.nilai')
            ->select('jadwal_pelajaran.kelas_id')
            ->selectRaw(
                'COUNT(DISTINCT CONCAT(
                    penilaian_mapel.siswa_id, ":",
                    jadwal_pelajaran.mata_pelajaran_id
                )) as jumlah_pasangan'
            )
            ->selectRaw('COUNT(*) as jumlah_nilai')
            ->groupBy('jadwal_pelajaran.kelas_id')
            ->get()
            ->keyBy('kelas_id');

        $kelas->each(function ($item) use (
            $mapelPerKelas,
            $nilaiPerKelas
        ) {
            $statNilai = $nilaiPerKelas->get($item->id);
            $statMapel = $mapelPerKelas->get($item->id);

            $item->jumlah_mapel = (int) (
                $statMapel->jumlah_mapel ?? 0
            );

            $item->jumlah_nilai = (int) (
                $statNilai->jumlah_nilai ?? 0
            );

            $item->jumlah_pasangan = (int) (
                $statNilai->jumlah_pasangan ?? 0
            );

            $item->target_pasangan =
                (int) $item->siswa_kelas_count
                * $item->jumlah_mapel;

            $item->nilai_lengkap = $item->target_pasangan > 0
                && $item->jumlah_pasangan >= $item->target_pasangan;

            $item->cakupan_nilai = $item->target_pasangan > 0
                ? min(
                    100,
                    (int) round(
                        (
                            $item->jumlah_pasangan
                            / $item->target_pasangan
                        ) * 100
                    )
                )
                : 0;
        });
    }

    /**
     * Mengekspor leger nilai dalam format CSV.
     */
    public function exportLeger()
    {
        $tahunAjaran = TahunAjaran::where('status', 1)
            ->orderByDesc('id')
            ->first();

        abort_unless($tahunAjaran, 404);

        return response()->streamDownload(
            function () use ($tahunAjaran) {
                $output = fopen('php://output', 'w');

                // BOM agar karakter CSV terbaca dengan baik di Excel.
                fwrite($output, "\xEF\xBB\xBF");

                fputcsv($output, [
                    'Tingkat',
                    'Jurusan',
                    'Kelas',
                    'NIS',
                    'NISN',
                    'Nama Siswa',
                    'Kode Mapel',
                    'Mata Pelajaran',
                    'Jenis Nilai',
                    'Judul Penilaian',
                    'Nilai',
                ]);

                DB::table('siswa_kelas')
                    ->join(
                        'datasiswa as siswa',
                        'siswa.id',
                        '=',
                        'siswa_kelas.siswa_id'
                    )
                    ->join(
                        'kelas',
                        'kelas.id',
                        '=',
                        'siswa_kelas.kelas_id'
                    )
                    ->join(
                        'jurusan',
                        'jurusan.id',
                        '=',
                        'kelas.jurusan_id'
                    )
                    ->leftJoin(
                        'jadwal_pelajaran as jadwal',
                        'jadwal.kelas_id',
                        '=',
                        'kelas.id'
                    )
                    ->leftJoin(
                        'mata_pelajaran as mapel',
                        'mapel.id',
                        '=',
                        'jadwal.mata_pelajaran_id'
                    )
                    ->leftJoin('penilaian_mapel as nilai', function ($join) {
                        $join->on(
                            'nilai.siswa_id',
                            '=',
                            'siswa.id'
                        )->on(
                            'nilai.jadwal_pelajaran_id',
                            '=',
                            'jadwal.id'
                        );
                    })
                    ->where(
                        'kelas.tahun_ajaran_id',
                        $tahunAjaran->id
                    )
                    ->select([
                        'kelas.tingkat',
                        'jurusan.nama_jurusan',
                        'kelas.nama_kelas',
                        'siswa.nis',
                        'siswa.nisn',
                        'siswa.nama',
                        'mapel.kode_mapel',
                        'mapel.nama_mapel',
                        'nilai.jenis_nilai',
                        'nilai.judul_tugas',
                        'nilai.nilai',
                    ])
                    ->orderBy('kelas.tingkat')
                    ->orderBy('jurusan.nama_jurusan')
                    ->orderBy('kelas.nama_kelas')
                    ->orderBy('siswa.nama')
                    ->orderBy('mapel.nama_mapel')
                    ->orderBy('nilai.jenis_nilai')
                    ->chunk(500, function ($rows) use ($output) {
                        foreach ($rows as $row) {
                            fputcsv($output, (array) $row);
                        }
                    });

                fclose($output);
            },
            'leger-nilai-' . $tahunAjaran->tahun_ajaran
                . '-' . $tahunAjaran->semester . '.csv',
            [
                'Content-Type' => 'text/csv; charset=UTF-8',
            ]
        );
    }

    /**
     * Mengatur penguncian dan penerbitan rapor per kelas.
     */
    public function updateStatus(Request $request, Kelas $kelas)
    {
        $tahunAjaranId = TahunAjaran::where('status', 1)
            ->orderByDesc('id')
            ->value('id');

        abort_unless(
            $tahunAjaranId
                && (int) $kelas->tahun_ajaran_id === (int) $tahunAjaranId,
            404
        );

        $validated = $request->validate([
            'action' => 'required|in:lock,unlock,publish,unpublish',
        ]);

        if (
            $validated['action'] === 'unlock'
            && $kelas->rapor_diterbitkan
        ) {
            return back()->withErrors([
                'action' => 'Tarik publikasi rapor sebelum membuka kunci nilai.',
            ]);
        }

        if ($validated['action'] === 'publish') {
            if (
                !$kelas->nilai_dikunci
                || !$kelas->rapor_difinalisasi
                || !$this->nilaiLengkap($kelas)
            ) {
                return back()->withErrors([
                    'action' => 'Rapor hanya dapat diterbitkan setelah semua nilai lengkap, wali kelas melakukan finalisasi, dan nilai dikunci.',
                ]);
            }

            $kelas->update([
                'nilai_dikunci' => true,
                'rapor_diterbitkan' => true,
            ]);

            return back()->with(
                'success',
                'Rapor berhasil diterbitkan untuk kelas '
                    . $kelas->nama_kelas . '.'
            );
        }

        if ($validated['action'] === 'unpublish') {
            $kelas->update([
                'nilai_dikunci' => true,
                'rapor_diterbitkan' => false,
            ]);

            return back()->with(
                'success',
                'Publikasi rapor kelas '
                    . $kelas->nama_kelas . ' berhasil ditarik.'
            );
        }

        if ($validated['action'] === 'lock') {
            if (
                !$kelas->rapor_difinalisasi
                || !$this->nilaiLengkap($kelas)
            ) {
                return back()->withErrors([
                    'action' => 'Wali kelas harus memfinalisasi rapor dan setiap siswa harus memiliki nilai pada setiap mapel sebelum dikunci.',
                ]);
            }

            $kelas->update([
                'nilai_dikunci' => true,
            ]);

            return back()->with(
                'success',
                'Nilai kelas ' . $kelas->nama_kelas
                    . ' berhasil dikunci.'
            );
        }

        // Membuka kunci juga membatalkan finalisasi dan publikasi.
        $kelas->update([
            'nilai_dikunci' => false,
            'rapor_difinalisasi' => false,
            'rapor_diterbitkan' => false,
        ]);

        return back()->with(
            'success',
            'Kunci nilai dibuka untuk kelas '
                . $kelas->nama_kelas
                . '. Wali kelas perlu melakukan finalisasi ulang.'
        );
    }

    /**
     * Menerbitkan semua rapor yang memenuhi syarat.
     */
    public function publishAll()
    {
        $tahunAjaranId = TahunAjaran::where('status', 1)
            ->orderByDesc('id')
            ->value('id');

        if (!$tahunAjaranId) {
            return back()->withErrors([
                'action' => 'Tahun ajaran aktif belum ditentukan.',
            ]);
        }

        $kelasSiap = Kelas::where(
            'tahun_ajaran_id',
            $tahunAjaranId
        )
            ->where('nilai_dikunci', true)
            ->where('rapor_difinalisasi', true)
            ->where('rapor_diterbitkan', false)
            ->get();

        $jumlahTerbit = 0;

        foreach ($kelasSiap as $kelas) {
            if ($this->nilaiLengkap($kelas)) {
                $kelas->update([
                    'rapor_diterbitkan' => true,
                ]);

                $jumlahTerbit++;
            }
        }

        $jumlahBelumSiap = Kelas::where(
            'tahun_ajaran_id',
            $tahunAjaranId
        )
            ->where(function ($query) {
                $query->where('rapor_diterbitkan', false)
                    ->orWhereNull('rapor_diterbitkan');
            })
            ->count();

        return back()->with(
            'success',
            "{$jumlahTerbit} kelas berhasil diterbitkan. "
                . "{$jumlahBelumSiap} kelas belum memenuhi syarat "
                . "atau masih belum siap."
        );
    }

    /**
     * Memeriksa kelengkapan nilai setiap pasangan siswa dan mapel.
     */
    private function nilaiLengkap(Kelas $kelas): bool
    {
        $jumlahSiswa = $kelas->siswaKelas()->count();

        $jumlahMapel = DB::table('jadwal_pelajaran')
            ->where('kelas_id', $kelas->id)
            ->distinct()
            ->count('mata_pelajaran_id');

        if ($jumlahSiswa === 0 || $jumlahMapel === 0) {
            return false;
        }

        $jumlahPasangan = DB::table('penilaian_mapel')
            ->join(
                'jadwal_pelajaran',
                'jadwal_pelajaran.id',
                '=',
                'penilaian_mapel.jadwal_pelajaran_id'
            )
            ->join('siswa_kelas', function ($join) use ($kelas) {
                $join->on(
                    'siswa_kelas.siswa_id',
                    '=',
                    'penilaian_mapel.siswa_id'
                )
                    ->where('siswa_kelas.kelas_id', '=', $kelas->id)
                    ->on(
                        'siswa_kelas.kelas_id',
                        '=',
                        'jadwal_pelajaran.kelas_id'
                    );
            })
            ->where('jadwal_pelajaran.kelas_id', $kelas->id)
            ->whereNotNull('penilaian_mapel.nilai')
            ->distinct()
            ->count(
                DB::raw(
                    'CONCAT(
                        penilaian_mapel.siswa_id, ":",
                        jadwal_pelajaran.mata_pelajaran_id
                    )'
                )
            );

        return $jumlahPasangan >= ($jumlahSiswa * $jumlahMapel);
    }
}
