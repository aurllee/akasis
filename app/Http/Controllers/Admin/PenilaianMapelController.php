<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal_Pelajaran;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\PenilaianMapel;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PenilaianMapelController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with([
            'jurusan',
            'tahunAjaran',
        ])
            ->orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->paginate(10);

        return view(
            'admin.penilaian.mapel.index',
            compact('kelas')
        );
    }

    public function kelas($kelasId)
    {
        $kelas = Kelas::with([
            'jurusan',
            'tahunAjaran',
        ])->findOrFail($kelasId);

        $mataPelajaran = MataPelajaran::whereHas('jadwal', function ($query) use ($kelasId) {
            $query->where('kelas_id', $kelasId);
        })
            ->orderBy('nama_mapel')
            ->get();

        return view(
            'admin.penilaian.mapel.kelas',
            compact('kelas', 'mataPelajaran')
        );
    }

    public function mapel($kelasId, $mapelId)
    {
        $kelas = Kelas::with('jurusan')
            ->findOrFail($kelasId);

        $mataPelajaran = MataPelajaran::findOrFail($mapelId);

        return view(
            'admin.penilaian.mapel.mapel',
            compact('kelas', 'mataPelajaran')
        );
    }

    public function harian(Request $request, $kelasId, $mapelId)
    {
        return $this->showScoresForType(
            $request,
            $kelasId,
            $mapelId,
            'harian'
        );
    }

    public function ujian(Request $request, $kelasId, $mapelId)
    {
        return $this->showScoresForType(
            $request,
            $kelasId,
            $mapelId,
            'ujian'
        );
    }

    private function showScoresForType(
        Request $request,
        $kelasId,
        $mapelId,
        string $jenis
    ) {
        $kelas = Kelas::with([
            'jurusan',
            'siswaKelas.siswa',
        ])->findOrFail($kelasId);

        $mataPelajaran = MataPelajaran::findOrFail($mapelId);

        $siswa = $kelas->siswaKelas
            ->pluck('siswa')
            ->filter()
            ->unique('id')
            ->sortBy('nama')
            ->values();

        $query = PenilaianMapel::with('siswa')
            ->whereHas('jadwal', function ($query) use ($kelasId, $mapelId) {
                $query->where('kelas_id', $kelasId)
                    ->where('mata_pelajaran_id', $mapelId);
            })
            ->where('jenis_nilai', $jenis);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('siswa', function ($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('nis', 'like', '%' . $search . '%')
                    ->orWhere('nisn', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate(
                'tanggal_penilaian',
                $request->tanggal
            );
        }

        $penilaian = $query
            ->orderBy('tanggal_penilaian')
            ->orderBy('id')
            ->get();

        $jenisPenilaian = $penilaian
            ->groupBy(function ($item) {
                return
                    ($item->tanggal_penilaian?->format('Y-m-d')
                        ?? 'tanpa-tanggal-' . $item->id)
                    . '|'
                    . ($item->judul_tugas ?? '')
                    . '|'
                    . ($item->jadwal_pelajaran_id ?? '');
            })
            ->sortKeys()
            ->values()
            ->map(function ($records, $index) use ($jenis) {
                $first = $records->first();

                return (object) [
                    'jenis_nilai' => $jenis,
                    'tanggal_penilaian' => $first->tanggal_penilaian,
                    'judul_tugas' => $first->judul_tugas,
                    'jadwal_pelajaran_id' => $first->jadwal_pelajaran_id,
                    'penilaian_ke' => $index + 1,
                    'records' => $records,
                ];
            });

        return view(
            'admin.penilaian.mapel.' . $jenis,
            compact(
                'kelas',
                'mataPelajaran',
                'siswa',
                'penilaian',
                'jenisPenilaian'
            )
        );
    }

    public function nilai(Request $request, $kelasId, $mapelId)
    {
        $kelas = Kelas::with([
            'jurusan',
            'tahunAjaran',
        ])->findOrFail($kelasId);

        $mataPelajaran = MataPelajaran::findOrFail($mapelId);

        $query = PenilaianMapel::with([
            'siswa',
            'jadwal.mataPelajaran',
            'jadwal.kelas',
            'jadwal.guru',
        ])
            ->whereHas('jadwal', function ($q) use (
                $kelasId,
                $mapelId
            ) {
                $q->where('kelas_id', $kelasId)
                    ->where('mata_pelajaran_id', $mapelId);
            });

        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('nis', 'like', '%' . $search . '%')
                    ->orWhere('nisn', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('jenis_nilai')) {
            $query->where(
                'jenis_nilai',
                $request->jenis_nilai
            );
        }

        $penilaian = $query
            ->latest()
            ->get();

        return view(
            'admin.penilaian.mapel.nilai',
            compact(
                'kelas',
                'mataPelajaran',
                'penilaian'
            )
        );
    }

    public function create($kelasId, $mapelId)
    {
        $kelas = Kelas::with([
            'jurusan',
            'tahunAjaran',
            'siswaKelas.siswa',
        ])->findOrFail($kelasId);

        $mataPelajaran = MataPelajaran::findOrFail($mapelId);

        $siswa = $kelas->siswaKelas
            ->pluck('siswa')
            ->filter()
            ->sortBy('nama')
            ->values();

        $jadwal = Jadwal_Pelajaran::with([
            'kelas',
            'mataPelajaran',
            'guru',
        ])
            ->where('kelas_id', $kelasId)
            ->where(
                'mata_pelajaran_id',
                $mapelId
            )
            ->get();

        return view(
            'admin.penilaian.mapel.create',
            compact(
                'kelas',
                'mataPelajaran',
                'jadwal',
                'siswa'
            )
        );
    }

    public function searchSiswa(Request $request, $kelasId)
    {
        $search = trim(
            $request->get('search', '')
        );

        if (strlen($search) < 2) {
            return response()->json([]);
        }

        $siswa = Siswa::whereHas(
            'siswaKelas',
            function ($query) use ($kelasId) {
                $query->where(
                    'kelas_id',
                    $kelasId
                );
            }
        )
            ->where(function ($query) use ($search) {
                $query->where(
                    'nama',
                    'like',
                    '%' . $search . '%'
                )
                    ->orWhere(
                        'nis',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'nisn',
                        'like',
                        '%' . $search . '%'
                    );
            })
            ->orderBy('nama')
            ->limit(20)
            ->get([
                'id',
                'nis',
                'nisn',
                'nama',
            ]);

        return response()->json($siswa);
    }

    public function store(
        Request $request,
        $kelasId,
        $mapelId
    ) {
        $request->validate([
            'jadwal_pelajaran_id' =>
                'required|exists:jadwal_pelajaran,id',

            'siswa_id' =>
                'required|exists:datasiswa,id',

            'jenis_nilai' =>
                'required|in:harian,ujian',

            'judul_tugas' =>
                'required|string|max:255',

            'tanggal_penilaian' =>
                'required|date',

            'nilai' =>
                'required|numeric|min:0|max:100',
        ]);

        /*
         * Pastikan jadwal memang milik kelas + mapel
         */
        $jadwal = Jadwal_Pelajaran::where('id', $request->jadwal_pelajaran_id)
            ->where('kelas_id', $kelasId)
            ->where('mata_pelajaran_id', $mapelId)
            ->firstOrFail();

        /*
         * Pastikan siswa memang berada di kelas tersebut
         */
        $siswaValid = Siswa::where('id', $request->siswa_id)
            ->whereHas('siswaKelas', function ($query) use ($kelasId) {
                $query->where('kelas_id', $kelasId);
            })
            ->exists();

        abort_unless($siswaValid, 404);

        PenilaianMapel::create([
            'jadwal_pelajaran_id' =>
                $jadwal->id,

            'siswa_id' =>
                $request->siswa_id,

            'jenis_nilai' =>
                $request->jenis_nilai,

            'judul_tugas' =>
                $request->judul_tugas,

            'tanggal_penilaian' =>
                $request->tanggal_penilaian,

            'nilai' =>
                $request->nilai,
        ]);

        return $this->redirectAfterSave(
            $request,
            $kelasId,
            $mapelId,
            'Penilaian berhasil ditambahkan.'
        );
    }

    /**
     * Ambil semua "kolom penilaian" yang tersedia
     * pada kelas + mapel + jenis nilai.
     *
     * Jadi meskipun siswa tertentu belum punya record,
     * kolom penilaiannya tetap muncul.
     */
    private function getAssessmentSlots(
        $kelasId,
        $mapelId,
        string $jenisNilai
    ): Collection {
        return PenilaianMapel::query()
            ->where('jenis_nilai', $jenisNilai)
            ->whereHas('jadwal', function ($query) use (
                $kelasId,
                $mapelId
            ) {
                $query->where('kelas_id', $kelasId)
                    ->where(
                        'mata_pelajaran_id',
                        $mapelId
                    );
            })
            ->orderBy('tanggal_penilaian')
            ->orderBy('id')
            ->get()
            ->groupBy(function ($item) {
                return implode('|', [
                    $item->jadwal_pelajaran_id,
                    $item->tanggal_penilaian?->format('Y-m-d') ?? '',
                    $item->judul_tugas ?? '',
                ]);
            })
            ->values()
            ->map(function ($records, $index) {
                $first = $records->first();

                return (object) [
                    'key' =>
                        (string) $index,

                    'jadwal_pelajaran_id' =>
                        $first->jadwal_pelajaran_id,

                    'judul_tugas' =>
                        $first->judul_tugas,

                    'tanggal_penilaian' =>
                        $first->tanggal_penilaian,

                    'records' =>
                        $records,
                ];
            });
    }

    public function edit(
        Request $request,
        $kelasId,
        $mapelId,
        $id
    ) {
        $kelas = Kelas::with([
            'jurusan',
            'tahunAjaran',
            'siswaKelas.siswa',
        ])->findOrFail($kelasId);

        $mataPelajaran =
            MataPelajaran::findOrFail($mapelId);

        $siswa = $kelas->siswaKelas
            ->pluck('siswa')
            ->filter()
            ->sortBy('nama')
            ->values();

        $bulkEdit = $request->boolean('bulk');

        $jenisNilai = $request->query('jenis_nilai');

        if ($bulkEdit) {
            abort_unless(
                in_array(
                    $jenisNilai,
                    ['harian', 'ujian'],
                    true
                ),
                404
            );

            /*
             * ID di mode bulk adalah ID SISWA,
             * bukan ID penilaian.
             */
            $targetSiswa = Siswa::findOrFail($id);

            /*
             * Pastikan siswa berada di kelas yang sedang dibuka.
             */
            $siswaDiKelas = $targetSiswa
                ->siswaKelas()
                ->where('kelas_id', $kelasId)
                ->exists();

            abort_unless($siswaDiKelas, 404);

            /*
             * Ambil SEMUA slot penilaian pada kelas + mapel.
             */
            $assessmentSlots = $this->getAssessmentSlots(
                $kelasId,
                $mapelId,
                $jenisNilai
            );

            /*
             * Ambil nilai milik siswa tersebut.
             */
            $existingRecords = PenilaianMapel::with([
                'jadwal.guru',
                'jadwal.mataPelajaran',
                'jadwal.kelas',
            ])
                ->where(
                    'siswa_id',
                    $targetSiswa->id
                )
                ->where(
                    'jenis_nilai',
                    $jenisNilai
                )
                ->whereHas('jadwal', function ($query) use (
                    $kelasId,
                    $mapelId
                ) {
                    $query->where(
                        'kelas_id',
                        $kelasId
                    )
                        ->where(
                            'mata_pelajaran_id',
                            $mapelId
                        );
                })
                ->orderBy('tanggal_penilaian')
                ->orderBy('id')
                ->get();

            /*
             * Cocokkan record siswa dengan slot penilaian.
             */
            $penilaian = $assessmentSlots->map(
                function ($slot) use ($existingRecords) {
                    $record = $existingRecords->first(
                        function ($item) use ($slot) {
                            return
                                (int) $item->jadwal_pelajaran_id ===
                                (int) $slot->jadwal_pelajaran_id
                                &&
                                (
                                    $item->tanggal_penilaian?->format('Y-m-d')
                                    ===
                                    $slot->tanggal_penilaian?->format('Y-m-d')
                                )
                                &&
                                (
                                    ($item->judul_tugas ?? '')
                                    ===
                                    ($slot->judul_tugas ?? '')
                                );
                        }
                    );

                    return (object) [
                        'key' =>
                            $slot->key,

                        'id' =>
                            $record?->id,

                        'jadwal_pelajaran_id' =>
                            $slot->jadwal_pelajaran_id,

                        'judul_tugas' =>
                            $slot->judul_tugas,

                        'tanggal_penilaian' =>
                            $slot->tanggal_penilaian,

                        'nilai' =>
                            $record?->nilai,
                    ];
                }
            );
        } else {
            $targetSiswa = null;
            $assessmentSlots = collect();

            $penilaian = PenilaianMapel::with([
                'siswa',
                'jadwal.guru',
                'jadwal.mataPelajaran',
                'jadwal.kelas',
            ])->findOrFail($id);

            /*
             * Pastikan penilaian memang milik kelas + mapel
             * yang sedang dibuka.
             */
            $validPenilaian = $penilaian
                ->jadwal()
                ->where('kelas_id', $kelasId)
                ->where(
                    'mata_pelajaran_id',
                    $mapelId
                )
                ->exists();

            abort_unless($validPenilaian, 404);
        }

        $jadwal = Jadwal_Pelajaran::with([
            'kelas',
            'mataPelajaran',
            'guru',
        ])
            ->where('kelas_id', $kelasId)
            ->where(
                'mata_pelajaran_id',
                $mapelId
            )
            ->get();

        return view(
            'admin.penilaian.mapel.edit',
            compact(
                'kelas',
                'mataPelajaran',
                'penilaian',
                'jadwal',
                'siswa',
                'bulkEdit',
                'jenisNilai',
                'targetSiswa',
                'assessmentSlots'
            )
        );
    }

    public function update(
        Request $request,
        $kelasId,
        $mapelId,
        $id
    ) {
        if ($request->boolean('bulk')) {
            return $this->updateStudentScores(
                $request,
                $kelasId,
                $mapelId,
                $id
            );
        }

        $penilaian =
            PenilaianMapel::findOrFail($id);

        /*
         * Pastikan record berada pada kelas + mapel
         * yang sedang diedit.
         */
        $validPenilaian = $penilaian
            ->jadwal()
            ->where('kelas_id', $kelasId)
            ->where(
                'mata_pelajaran_id',
                $mapelId
            )
            ->exists();

        abort_unless($validPenilaian, 404);

        $request->validate([
            'jadwal_pelajaran_id' =>
                'required|exists:jadwal_pelajaran,id',

            'siswa_id' =>
                'required|exists:datasiswa,id',

            'jenis_nilai' =>
                'required|in:harian,ujian',

            'judul_tugas' =>
                'nullable|string|max:255',

            'tanggal_penilaian' =>
                'required|date',

            'nilai' =>
                'required|numeric|min:0|max:100',
        ]);

        /*
         * Pastikan jadwal sesuai kelas + mapel.
         */
        $jadwal = Jadwal_Pelajaran::where(
            'id',
            $request->jadwal_pelajaran_id
        )
            ->where(
                'kelas_id',
                $kelasId
            )
            ->where(
                'mata_pelajaran_id',
                $mapelId
            )
            ->firstOrFail();

        $penilaian->update([
            'jadwal_pelajaran_id' =>
                $jadwal->id,

            'siswa_id' =>
                $request->siswa_id,

            'jenis_nilai' =>
                $request->jenis_nilai,

            'judul_tugas' =>
                $request->judul_tugas,

            'tanggal_penilaian' =>
                $request->tanggal_penilaian,

            'nilai' =>
                $request->nilai,
        ]);

        return $this->redirectAfterSave(
            $request,
            $kelasId,
            $mapelId,
            'Penilaian berhasil diperbarui.'
        );
    }

    /**
     * Update + create nilai siswa dari halaman
     * "Edit Semua Nilai".
     */
    private function updateStudentScores(
        Request $request,
        $kelasId,
        $mapelId,
        $siswaId
    ) {
        $validated = $request->validate([
            'jenis_nilai' =>
                'required|in:harian,ujian',

            'scores' =>
                'nullable|array',

            'scores.*' =>
                'nullable|numeric|min:0|max:100',

            'new_scores' =>
                'nullable|array',

            'new_scores.*' =>
                'nullable|numeric|min:0|max:100',
        ]);

        $targetSiswa = Siswa::findOrFail($siswaId);

        /*
         * Pastikan siswa ada di kelas.
         */
        $siswaDiKelas = $targetSiswa
            ->siswaKelas()
            ->where('kelas_id', $kelasId)
            ->exists();

        abort_unless($siswaDiKelas, 404);

        /*
         * Ambil semua slot penilaian.
         */
        $assessmentSlots = $this->getAssessmentSlots(
            $kelasId,
            $mapelId,
            $validated['jenis_nilai']
        );

        /*
         * Ambil semua record milik siswa.
         */
        $existingRecords = PenilaianMapel::where(
            'siswa_id',
            $siswaId
        )
            ->where(
                'jenis_nilai',
                $validated['jenis_nilai']
            )
            ->whereHas('jadwal', function ($query) use (
                $kelasId,
                $mapelId
            ) {
                $query->where(
                    'kelas_id',
                    $kelasId
                )
                    ->where(
                        'mata_pelajaran_id',
                        $mapelId
                    );
            })
            ->get();

        $recordsBySlot = [];

        foreach ($assessmentSlots as $slot) {
            $record = $existingRecords->first(
                function ($item) use ($slot) {
                    return
                        (int) $item->jadwal_pelajaran_id ===
                        (int) $slot->jadwal_pelajaran_id
                        &&
                        (
                            $item->tanggal_penilaian?->format('Y-m-d')
                            ===
                            $slot->tanggal_penilaian?->format('Y-m-d')
                        )
                        &&
                        (
                            ($item->judul_tugas ?? '')
                            ===
                            ($slot->judul_tugas ?? '')
                        );
                }
            );

            if ($record) {
                $recordsBySlot[$slot->key] = $record;
            }
        }

        $scores = $validated['scores'] ?? [];
        $newScores = $validated['new_scores'] ?? [];

        DB::transaction(function () use (
            $assessmentSlots,
            $recordsBySlot,
            $scores,
            $newScores,
            $siswaId,
            $validated
        ) {
            foreach ($assessmentSlots as $slot) {
                /*
                 * ==========================================
                 * RECORD SUDAH ADA
                 * ==========================================
                 */
                if (isset($recordsBySlot[$slot->key])) {
                    $record =
                        $recordsBySlot[$slot->key];

                    /*
                     * Kalau field tidak dikirim, jangan ubah.
                     */
                    if (
                        array_key_exists(
                            $record->id,
                            $scores
                        )
                        &&
                        $scores[$record->id] !== null
                        &&
                        $scores[$record->id] !== ''
                    ) {
                        $record->update([
                            'nilai' =>
                                $scores[$record->id],
                        ]);
                    }

                    continue;
                }

                /*
                 * ==========================================
                 * RECORD BELUM ADA
                 * ==========================================
                 *
                 * Hanya dibuat kalau admin mengisi nilainya.
                 */
                if (
                    !array_key_exists(
                        $slot->key,
                        $newScores
                    )
                ) {
                    continue;
                }

                $nilai =
                    $newScores[$slot->key];

                if (
                    $nilai === null ||
                    $nilai === ''
                ) {
                    continue;
                }

                PenilaianMapel::create([
                    'jadwal_pelajaran_id' =>
                        $slot->jadwal_pelajaran_id,

                    'siswa_id' =>
                        $siswaId,

                    'jenis_nilai' =>
                        $validated['jenis_nilai'],

                    'judul_tugas' =>
                        $slot->judul_tugas,

                    'tanggal_penilaian' =>
                        $slot->tanggal_penilaian,

                    'nilai' =>
                        $nilai,
                ]);
            }
        });

        return $this->redirectAfterSave(
            $request,
            $kelasId,
            $mapelId,
            'Semua nilai siswa berhasil diperbarui.'
        );
    }

    private function redirectAfterSave(
        Request $request,
        $kelasId,
        $mapelId,
        string $message
    ) {
        $returnTo =
            $request->input('return_to');

        if (
            is_string($returnTo)
            && str_starts_with($returnTo, '/')
            && !str_starts_with($returnTo, '//')
            && !str_contains($returnTo, '\\')
            && !str_contains($returnTo, "\r")
            && !str_contains($returnTo, "\n")
        ) {
            return redirect()
                ->to($returnTo)
                ->with(
                    'success',
                    $message
                );
        }

        return redirect()
            ->route(
                'admin.penilaian.mapel.mapel',
                [
                    'kelasId' => $kelasId,
                    'mapelId' => $mapelId,
                ]
            )
            ->with(
                'success',
                $message
            );
    }

    public function destroy(
        Request $request,
        $kelasId,
        $mapelId,
        $id
    ) {
        if ($request->boolean('bulk')) {
            $validated = $request->validate([
                'jenis_nilai' =>
                    'required|in:harian,ujian',
            ]);

            $records = PenilaianMapel::where(
                'siswa_id',
                $id
            )
                ->where(
                    'jenis_nilai',
                    $validated['jenis_nilai']
                )
                ->whereHas('jadwal', function ($query) use (
                    $kelasId,
                    $mapelId
                ) {
                    $query->where(
                        'kelas_id',
                        $kelasId
                    )
                        ->where(
                            'mata_pelajaran_id',
                            $mapelId
                        );
                })
                ->get();

            abort_if(
                $records->isEmpty(),
                404
            );

            DB::transaction(
                function () use ($records) {
                    foreach ($records as $record) {
                        $record->delete();
                    }
                }
            );

            return $this->redirectAfterSave(
                $request,
                $kelasId,
                $mapelId,
                'Semua nilai siswa berhasil dihapus.'
            );
        }

        $penilaian =
            PenilaianMapel::findOrFail($id);

        $validPenilaian = $penilaian
            ->jadwal()
            ->where(
                'kelas_id',
                $kelasId
            )
            ->where(
                'mata_pelajaran_id',
                $mapelId
            )
            ->exists();

        abort_unless($validPenilaian, 404);

        $penilaian->delete();

        return $this->redirectAfterSave(
            $request,
            $kelasId,
            $mapelId,
            'Penilaian berhasil dihapus.'
        );
    }
}