<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Jadwal_pelajaran;
use App\Models\Penilaian;
use App\Models\Siswa;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    private function guruOrFail()
    {
        $guru = auth()->user()?->guru;

        if (!$guru) {
            abort(403, 'Akun Anda belum terhubung dengan data guru.');
        }

        return $guru;
    }

    public function index()
    {
        $guru = $this->guruOrFail();

        $jadwal = Jadwal_pelajaran::with([
            'mapel',
            'kelas.jurusan',
            'kelas.siswaKelas.siswa'
        ])
            ->where('guru_id', $guru->id)
            ->get()
            ->unique(function ($item) {
                return $item->kelas_id . '-' . $item->mata_pelajaran_id;
            })
            ->values();

        return view('guru.penilaian.index', compact('jadwal'));
    }

    public function create($jadwalId)
    {
        $guru = $this->guruOrFail();

        $jadwal = Jadwal_pelajaran::with([
            'mapel',
            'kelas.jurusan',
            'kelas.siswaKelas.siswa'
        ])
            ->where('id', $jadwalId)
            ->where('guru_id', $guru->id)
            ->firstOrFail();

        $siswa = $jadwal->kelas?->siswaKelas
            ->pluck('siswa')
            ->filter()
            ->values() ?? collect();

        return view('guru.penilaian.create', compact(
            'jadwal',
            'siswa'
        ));
    }

    public function store(Request $request, $jadwalId)
    {
        $guru = $this->guruOrFail();

        $jadwal = Jadwal_pelajaran::where('id', $jadwalId)
            ->where('guru_id', $guru->id)
            ->firstOrFail();

        $request->validate([
            'jenis_nilai' => 'required|in:harian,ujian',
            'judul_tugas' => 'required|string|max:255',
            'nilai' => 'required|array',
            'nilai.*' => 'nullable|numeric|min:0|max:100',
            'tanggal_penilaian' => 'required|date',
        ]);

        foreach ($request->nilai as $siswaId => $nilai) {

            if ($nilai === null || $nilai === '') {
                continue;
            }

            Penilaian::create([
                'jadwal_pelajaran_id' => $jadwal->id,
                'siswa_id' => $siswaId,
                'jenis_nilai' => $request->jenis_nilai,
                'judul_tugas' => $request->judul_tugas,
                'tanggal_penilaian' => $request->tanggal_penilaian,
                'nilai' => $nilai,
            ]);
        }

        return redirect()
            ->route('guru.penilaian.create', $jadwal->id)
            ->with('success', 'Nilai berhasil disimpan.');
    }

    public function detail(Request $request, $jadwalId)
    {
        $guru = $this->guruOrFail();
        $jenisNilai = $request->input('jenis_nilai');

        abort_if($jenisNilai !== null && !in_array($jenisNilai, ['harian', 'ujian'], true), 422);

        $jadwal = Jadwal_pelajaran::with([
            'mapel',
            'kelas.jurusan',
            'kelas.siswaKelas.siswa'
        ])
            ->where('id', $jadwalId)
            ->where('guru_id', $guru->id)
            ->firstOrFail();

        
        $jadwalIds = Jadwal_pelajaran::where('guru_id', $guru->id)
            ->where('kelas_id', $jadwal->kelas_id)
            ->where('mata_pelajaran_id', $jadwal->mata_pelajaran_id)
            ->pluck('id');

        $penilaianQuery = Penilaian::with('siswa')
            ->whereIn('jadwal_pelajaran_id', $jadwalIds)
            ->orderBy('tanggal_penilaian');

        if ($jenisNilai) {
            $penilaianQuery->where('jenis_nilai', $jenisNilai);
        }

        $penilaian = $penilaianQuery->get();

        $siswa = $jadwal->kelas?->siswaKelas()
            ->with('siswa')
            ->paginate(10)
            ->appends(request()->query());

        if ($siswa) {
            $siswa->setCollection(
                $siswa->getCollection()
                    ->pluck('siswa')
                    ->filter()
                    ->values()
            );
        }

        $counterJenis = [];

        $jenisPenilaian = $penilaian
            ->sortBy([
                ['jenis_nilai', 'asc'],
                ['tanggal_penilaian', 'asc'],
                ['judul_tugas', 'asc'],
            ])
            ->unique(fn($item) => $item->jenis_nilai . '|' . $item->tanggal_penilaian . '|' . ($item->judul_tugas ?? ''))
            ->map(function ($item) use (&$counterJenis) {
                $counterJenis[$item->jenis_nilai] = ($counterJenis[$item->jenis_nilai] ?? 0) + 1;

                return (object) [
                    'id' => $item->id,
                    'jenis_nilai' => $item->jenis_nilai,
                    'tanggal_penilaian' => $item->tanggal_penilaian,
                    'judul_tugas' => $item->judul_tugas,
                    'penilaian_ke' => $counterJenis[$item->jenis_nilai],
                    'nama_penilaian' => ucfirst($item->jenis_nilai) . ' ' . $counterJenis[$item->jenis_nilai],
                ];
            })
            ->values();

        $nilaiSiswa = $penilaian;
        $semester = $jadwal->kelas->tahunAjaran;

        return view('guru.penilaian.detail', compact(
            'jadwal',
            'penilaian',
            'siswa',
            'jenisPenilaian',
            'nilaiSiswa',
            'semester',
            'jenisNilai'
        ));
    }

    public function editSiswa($jadwalId, $siswaId)
    {
        $guru = $this->guruOrFail();

        $jadwal = Jadwal_pelajaran::with([
            'mapel',
            'kelas.jurusan',
            'kelas.siswaKelas.siswa'
        ])
            ->where('id', $jadwalId)
            ->where('guru_id', $guru->id)
            ->firstOrFail();

        $siswa = Siswa::findOrFail($siswaId);

        $nilai = Penilaian::where('jadwal_pelajaran_id', $jadwal->id)
            ->where('siswa_id', $siswa->id)
            ->orderBy('tanggal_penilaian')
            ->orderBy('jenis_nilai')
            ->get();

        return view('guru.penilaian.edit', compact(
            'jadwal',
            'siswa',
            'nilai'
        ));
    }

    public function updateSiswa(Request $request, $jadwalId, $siswaId)
    {
        $guru = $this->guruOrFail();

        $jadwal = Jadwal_pelajaran::where('id', $jadwalId)
            ->where('guru_id', $guru->id)
            ->firstOrFail();

        $siswa = Siswa::findOrFail($siswaId);

        $request->validate([
            'nilai' => 'required|array',
            'nilai.*' => 'nullable|numeric|min:0|max:100',
        ]);

        foreach ($request->input('nilai', []) as $penilaianId => $nilai) {
            $penilaian = Penilaian::where('id', $penilaianId)
                ->where('jadwal_pelajaran_id', $jadwal->id)
                ->where('siswa_id', $siswa->id)
                ->first();

            if (!$penilaian) {
                continue;
            }

            $penilaian->update([
                'nilai' => $nilai === '' || $nilai === null ? null : $nilai,
            ]);
        }

        return redirect()
            ->route('guru.penilaian.detail', $jadwal->id)
            ->with('success', 'Nilai siswa berhasil diperbarui.');
    }
}
