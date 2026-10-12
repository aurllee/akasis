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
            'judul_tugas' => 'nullable|string|max:255',
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
        abort_unless($jadwal->kelas->siswaKelas->contains('siswa_id', $siswa->id), 404);

        $jadwalIds = Jadwal_pelajaran::where('guru_id', $guru->id)
            ->where('kelas_id', $jadwal->kelas_id)
            ->where('mata_pelajaran_id', $jadwal->mata_pelajaran_id)
            ->pluck('id');

        $nilai = Penilaian::whereIn('jadwal_pelajaran_id', $jadwalIds)
            ->where('jenis_nilai', '!=', '')
            ->orderBy('tanggal_penilaian')
            ->orderBy('id')
            ->get();

        $penilaian = $nilai
            ->groupBy(fn($item) => $item->jenis_nilai . '|' . ($item->tanggal_penilaian ? \Carbon\Carbon::parse($item->tanggal_penilaian)->format('Y-m-d') : 'tanpa-tanggal-' . $item->id) . '|' . ($item->judul_tugas ?? ''))
            ->sortKeys()
            ->values()
            ->map(function ($records, $index) {
                $first = $records->first();

                return (object) [
                    'id' => $first->id,
                    'jenis_nilai' => $first->jenis_nilai,
                    'tanggal_penilaian' => $first->tanggal_penilaian,
                    'judul_tugas' => $first->judul_tugas,
                    'penilaian_ke' => $index + 1,
                    'records' => $records,
                ];
            });

        return view('guru.penilaian.edit', compact(
            'jadwal',
            'siswa',
            'nilai',
            'penilaian',
            'jadwalIds'
        ));
    }

    public function updateSiswa(Request $request, $jadwalId, $siswaId)
    {
        $guru = $this->guruOrFail();

        $jadwal = Jadwal_pelajaran::where('id', $jadwalId)
            ->where('guru_id', $guru->id)
            ->firstOrFail();

        $siswa = Siswa::findOrFail($siswaId);
        abort_unless($jadwal->kelas->siswaKelas()->where('siswa_id', $siswa->id)->exists(), 404);

        $jadwalIds = Jadwal_pelajaran::where('guru_id', $guru->id)
            ->where('kelas_id', $jadwal->kelas_id)
            ->where('mata_pelajaran_id', $jadwal->mata_pelajaran_id)
            ->pluck('id');

        $request->validate([
            'nilai' => 'required|array',
            'nilai.*' => 'nullable|numeric|min:0|max:100',
        ]);

        $nilaiInputs = $request->input('nilai', []);
        $referensi = Penilaian::whereIn('jadwal_pelajaran_id', $jadwalIds)
            ->whereIn('id', array_keys($nilaiInputs))
            ->get()
            ->keyBy('id');

        abort_unless($referensi->count() === count($nilaiInputs), 404);

        foreach ($referensi as $reference) {
            $value = $nilaiInputs[$reference->id] ?? null;

            $existingQuery = Penilaian::whereIn('jadwal_pelajaran_id', $jadwalIds)
                ->where('siswa_id', $siswa->id)
                ->where('jenis_nilai', $reference->jenis_nilai)
                ->where('judul_tugas', $reference->judul_tugas);

            if ($reference->tanggal_penilaian) {
                $existingQuery->whereDate('tanggal_penilaian', $reference->tanggal_penilaian);
            } else {
                $existingQuery->whereNull('tanggal_penilaian');
            }

            $existing = $existingQuery->first();

            if ($existing) {
                $existing->update([
                    'nilai' => $value === '' ? null : $value,
                ]);
            } elseif ($value !== null && $value !== '') {
                Penilaian::create([
                    'jadwal_pelajaran_id' => $reference->jadwal_pelajaran_id,
                    'siswa_id' => $siswa->id,
                    'jenis_nilai' => $reference->jenis_nilai,
                    'judul_tugas' => $reference->judul_tugas,
                    'tanggal_penilaian' => $reference->tanggal_penilaian,
                    'nilai' => $value,
                ]);
            }
        }

        return redirect()
            ->route('guru.penilaian.detail', $jadwal->id)
            ->with('success', 'Nilai siswa berhasil diperbarui.');
    }
}
