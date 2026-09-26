<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\SiswaKelas;
use App\Models\WaliKelas;
use App\Models\Jadwal_pelajaran;
use App\Models\PenilaianMapel;
use Illuminate\Http\Request;

class WaliKelasController extends Controller
{
    public function dashboard()
    {
        $guruId = auth()->user()->guru_id;

        $guru = auth()->user()->guru;

        $jadwal = Jadwal_pelajaran::with([
            'kelas.jurusan',
            'mapel',
            'ruangan',
        ])
            ->where('guru_id', $guruId)
            ->where('is_published', true)
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        $waliKelas = WaliKelas::with([
            'kelas.jurusan',
            'kelas.tahunAjaran'
        ])
            ->where('guru_id', $guruId)
            ->get();

        $kelasWali = $waliKelas->first()?->kelas;

        $jadwalMengajar = Jadwal_pelajaran::with([
            'kelas.jurusan',
            'mataPelajaran'
        ])
            ->where('guru_id', $guruId)
            ->get();

        return view('wali-kelas.dashboard', compact(
            'guru',
            'jadwal',
            'waliKelas',
            'jadwalMengajar'
        ));
    }

    public function index()
    {
        $guruId = auth()->user()->guru_id;


        $waliKelas = WaliKelas::with([
            'kelas.jurusan',
            'kelas.tahunAjaran'
        ])
            ->where('guru_id', $guruId)
            ->get();


        $jadwalMengajar = Jadwal_pelajaran::with([
            'kelas',
            'mataPelajaran'
        ])
            ->where('guru_id', $guruId)
            ->get();

        $isMengajar = $jadwalMengajar->isNotEmpty();

        return view('wali-kelas.index', compact(
            'waliKelas',
            'jadwalMengajar',
            'isMengajar'
        ));
    }

    public function siswa(Kelas $kelas)
    {
        $guruId = auth()->user()->guru_id;


        $waliKelas = WaliKelas::where('guru_id', $guruId)
            ->where('kelas_id', $kelas->id)
            ->firstOrFail();

        $kelas->load([
            'waliKelas',
            'jurusan',
            'tahunAjaran'
        ]);

        $siswa = SiswaKelas::with('siswa')
            ->where('kelas_id', $kelas->id)
            ->get();

        return view('wali-kelas.siswa', compact(
            'kelas',
            'siswa'
        ));
    }

    public function nilai(Siswa $siswa)
    {
        $nilaiList = PenilaianMapel::with(['jadwalPelajaran.mataPelajaran'])
            ->where('siswa_id', $siswa->id)
            ->get();

        return view('wali-kelas.nilai', compact('siswa', 'nilaiList'));
    }

    public function rapor(Siswa $siswa)
    {
        return view('wali-kelas.rapor', compact('siswa'));
    }

    public function kelasMengajar()
    {
        $guruId = auth()->user()->guru_id;

        $jadwalMengajar = Jadwal_pelajaran::with([
            'kelas.jurusan',
            'mataPelajaran'
        ])
            ->where('guru_id', $guruId)
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();


        $jpBerjalan = [];

        foreach ($jadwalMengajar as $jadwal) {

            $key = $jadwal->kelas_id . '-' . $jadwal->hari;

            if (!isset($jpBerjalan[$key])) {
                $jpBerjalan[$key] = 1;
            }

            $mulai = $jpBerjalan[$key];

            $selesai = $mulai + (int) $jadwal->jumlah_jp - 1;

            $jadwal->jp_mulai = $mulai;
            $jadwal->jp_selesai = $selesai;

            $jpBerjalan[$key] = $selesai + 1;
        }

        return view('wali-kelas.kelas-mengajar', compact(
            'jadwalMengajar'
        ));
    }

    public function inputNilai(Jadwal_pelajaran $jadwal)
    {
        $guruId = auth()->user()->guru_id;


        if ($jadwal->guru_id != $guruId) {
            abort(403);
        }

        $jadwal->load([
            'kelas.jurusan',
            'mataPelajaran'
        ]);



        $jadwalSebelumnya = Jadwal_pelajaran::where('guru_id', $guruId)
            ->where('kelas_id', $jadwal->kelas_id)
            ->where('hari', $jadwal->hari)
            ->where('id', '!=', $jadwal->id)
            ->orderBy('jam_mulai')
            ->get();

        $jpBerjalan = 1;

        foreach ($jadwalSebelumnya as $jadwalLain) {
            $jpBerjalan += (int) $jadwalLain->jumlah_jp;
        }

        $jadwal->jp_mulai = $jpBerjalan;

        $jadwal->jp_selesai =
            $jpBerjalan + (int) $jadwal->jumlah_jp - 1;

        $siswa = SiswaKelas::with('siswa')
            ->where('kelas_id', $jadwal->kelas_id)
            ->get();

        $nilai = PenilaianMapel::where(
            'jadwal_pelajaran_id',
            $jadwal->id
        )
            ->latest('id')
            ->get()
            ->keyBy('siswa_id');

        return view('wali-kelas.nilai.create', compact(
            'jadwal',
            'siswa',
            'nilai'
        ));
    }

    public function simpanNilai(
        Request $request,
        Jadwal_pelajaran $jadwal
    ) {
        $guruId = auth()->user()->guru_id;

        if ($jadwal->guru_id != $guruId) {
            abort(403);
        }

        $request->validate([
            'jenis_nilai' => ['required', 'in:harian,ujian'],
            'judul_tugas' => ['required', 'string', 'max:255'],
            'tanggal_penilaian' => ['required', 'date'],
            'nilai' => ['required', 'array'],
            'nilai.*' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100'
            ],
        ]);



        foreach ($request->nilai as $siswaId => $nilaiSiswa) {


            if ($nilaiSiswa === null || $nilaiSiswa === '') {
                continue;
            }


            $siswaValid = SiswaKelas::where('kelas_id', $jadwal->kelas_id)
                ->where('siswa_id', $siswaId)
                ->exists();

            if (!$siswaValid) {
                continue;
            }



            PenilaianMapel::updateOrCreate(
                [
                    'jadwal_pelajaran_id' => $jadwal->id,
                    'siswa_id' => $siswaId,
                    'jenis_nilai' => $request->jenis_nilai,
                    'judul_tugas' => $request->judul_tugas,
                    'tanggal_penilaian' => $request->tanggal_penilaian,
                ],
                [
                    'nilai' => $nilaiSiswa,
                ]
            );
        }

        return redirect()
            ->route('wali-kelas.detail-nilai', $jadwal->id)
            ->with(
                'success',
                'Nilai berhasil disimpan.'
            );
    }

    public function detailNilai(Request $request, Jadwal_pelajaran $jadwal)
    {
        $guruId = auth()->user()->guru_id;

        abort_unless($jadwal->guru_id == $guruId, 403);

        $request->validate([
            'jenis_nilai' => ['nullable', 'in:harian,ujian'],
        ]);

        $jadwal->load([
            'kelas.jurusan',
            'kelas.tahunAjaran',
            'mataPelajaran',
        ]);

        $penilaianQuery = PenilaianMapel::with('siswa')
            ->where('jadwal_pelajaran_id', $jadwal->id)
            ->orderBy('tanggal_penilaian')
            ->orderBy('judul_tugas');

        if ($request->filled('jenis_nilai')) {
            $penilaianQuery->where('jenis_nilai', $request->jenis_nilai);
        }

        $penilaian = $penilaianQuery->get();
        $siswa = SiswaKelas::with('siswa')
            ->where('kelas_id', $jadwal->kelas_id)
            ->get()
            ->pluck('siswa')
            ->filter()
            ->values();

        $counterJenis = [];
        $jenisPenilaian = $penilaian
            ->unique(fn($item) => $item->jenis_nilai . '|' . $item->tanggal_penilaian . '|' . $item->judul_tugas)
            ->map(function ($item) use (&$counterJenis) {
                $counterJenis[$item->jenis_nilai] = ($counterJenis[$item->jenis_nilai] ?? 0) + 1;

                return (object) [
                    'jenis_nilai' => $item->jenis_nilai,
                    'tanggal_penilaian' => $item->tanggal_penilaian,
                    'judul_tugas' => $item->judul_tugas,
                    'penilaian_ke' => $counterJenis[$item->jenis_nilai],
                ];
            })
            ->values();

        return view('wali-kelas.nilai.detail', [
            'jadwal' => $jadwal,
            'penilaian' => $penilaian,
            'siswa' => $siswa,
            'jenisPenilaian' => $jenisPenilaian,
            'nilaiSiswa' => $penilaian,
            'jenisNilai' => $request->jenis_nilai,
        ]);
    }

    private function kelasYangDiajar()
    {
        return Jadwal_pelajaran::where('guru_id', auth()->user()->guru_id)
            ->pluck('kelas_id')->unique()->values();
    }
}
