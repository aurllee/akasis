<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RaporController extends Controller
{
    public function mapel()
    {
        $user = auth()->user();

        abort_unless($user && $user->guru_id, 403);

        $jadwal = DB::table('jadwal_pelajaran')
            ->join('kelas', 'kelas.id', '=', 'jadwal_pelajaran.kelas_id')
            ->join('tahun_ajaran', 'tahun_ajaran.id', '=', 'kelas.tahun_ajaran_id')
            ->leftJoin('mata_pelajaran', 'mata_pelajaran.id', '=', 'jadwal_pelajaran.mata_pelajaran_id')
            ->where('jadwal_pelajaran.guru_id', $user->guru_id)
            ->select(
                'jadwal_pelajaran.id',
                'kelas.id as kelas_id',
                'kelas.tingkat',
                'kelas.nama_kelas',
                'tahun_ajaran.tahun_ajaran',
                'tahun_ajaran.semester',
                'mata_pelajaran.nama_mapel'
            )
            ->orderByDesc('tahun_ajaran.tahun_ajaran')
            ->orderBy('kelas.tingkat')
            ->orderBy('kelas.nama_kelas')
            ->orderBy('mata_pelajaran.nama_mapel')
            ->get();

        return view('guru.rapor-mapel.index', compact('jadwal'));
    }

    public function index()
    {
        $user = auth()->user();

        abort_unless($user && $user->guru_id, 403);

        $kelas = DB::table('wali_kelas')
            ->join('kelas', 'kelas.id', '=', 'wali_kelas.kelas_id')
            ->join('tahun_ajaran', 'tahun_ajaran.id', '=', 'wali_kelas.tahun_ajaran_id')
            ->where('wali_kelas.guru_id', $user->guru_id)
            ->select(
                'kelas.id as kelas_id',
                'kelas.tingkat',
                'kelas.nama_kelas',
                'tahun_ajaran.id as tahun_ajaran_id',
                'tahun_ajaran.tahun_ajaran',
                'tahun_ajaran.semester'
            )
            ->orderByDesc('tahun_ajaran.tahun_ajaran')
            ->orderBy('kelas.tingkat')
            ->orderBy('kelas.nama_kelas')
            ->get();

        abort_if(
            $kelas->isEmpty(),
            404,
            'Belum ada kelas yang ditugaskan kepada Anda sebagai wali kelas.'
        );

        $kelasAktif = $kelas->first();

        return redirect()->route('wali-kelas.rapor.siswa', [
            'kelasId' => $kelasAktif->kelas_id,
            'tahunAjaranId' => $kelasAktif->tahun_ajaran_id,
        ]);
    }

    public function daftarSiswa($kelasId, $tahunAjaranId)
    {
        $user = auth()->user();

        abort_unless($user && $user->guru_id, 403);

        $this->pastikanWaliKelas(
            $user->guru_id,
            $kelasId,
            $tahunAjaranId
        );

        $kelas = DB::table('kelas')
            ->join('tahun_ajaran', 'tahun_ajaran.id', '=', 'kelas.tahun_ajaran_id')
            ->where('kelas.id', $kelasId)
            ->where('tahun_ajaran.id', $tahunAjaranId)
            ->select(
                'kelas.id',
                'kelas.tingkat',
                'kelas.nama_kelas',
                'tahun_ajaran.id as tahun_ajaran_id',
                'tahun_ajaran.tahun_ajaran',
                'tahun_ajaran.semester'
            )
            ->first();

        abort_unless($kelas !== null, 404);

        $siswa = DB::table('siswa_kelas')
            ->join('datasiswa', 'datasiswa.id', '=', 'siswa_kelas.siswa_id')
            ->where('siswa_kelas.kelas_id', $kelasId)
            ->select(
                'datasiswa.id',
                'datasiswa.nis',
                'datasiswa.nama'
            )
            ->orderBy('datasiswa.nama')
            ->get();

        $rapor = DB::table('rapor_siswa')
            ->where('kelas_id', $kelasId)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->where('semester', $kelas->semester)
            ->get()
            ->keyBy('siswa_id');

        return view(
            'wali-kelas.rapor.siswa',
            compact('kelas', 'siswa', 'rapor')
        );
    }

    public function generate($kelasId, $tahunAjaranId, $siswaId)
    {
        $user = auth()->user();

        abort_unless($user && $user->guru_id, 403);

        $this->pastikanWaliKelas(
            $user->guru_id,
            $kelasId,
            $tahunAjaranId
        );

        $tahunAjaran = DB::table('tahun_ajaran')
            ->where('id', $tahunAjaranId)
            ->first();

        abort_unless($tahunAjaran !== null, 404);

        if (
            empty($tahunAjaran->tanggal_mulai) ||
            empty($tahunAjaran->tanggal_selesai)
        ) {
            return back()->with(
                'error',
                'Tanggal mulai dan tanggal selesai tahun ajaran harus diisi terlebih dahulu.'
            );
        }

        $anggotaKelas = DB::table('siswa_kelas')
            ->where('kelas_id', $kelasId)
            ->where('siswa_id', $siswaId)
            ->exists();

        abort_unless($anggotaKelas, 404);

        $raporLama = DB::table('rapor_siswa')
            ->where('siswa_id', $siswaId)
            ->where('kelas_id', $kelasId)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->where('semester', $tahunAjaran->semester)
            ->first();

        if ($raporLama && $raporLama->status === 'final') {
            return back()->with(
                'error',
                'Rapor sudah difinalisasi dan tidak dapat dibuat ulang.'
            );
        }

        $nilaiMapel = DB::table('penilaian_mapel')
            ->join(
                'jadwal_pelajaran',
                'jadwal_pelajaran.id',
                '=',
                'penilaian_mapel.jadwal_pelajaran_id'
            )
            ->join(
                'mata_pelajaran',
                'mata_pelajaran.id',
                '=',
                'jadwal_pelajaran.mata_pelajaran_id'
            )
            ->where('jadwal_pelajaran.kelas_id', $kelasId)
            ->where('penilaian_mapel.siswa_id', $siswaId)
            ->whereBetween('penilaian_mapel.tanggal_penilaian', [
                $tahunAjaran->tanggal_mulai,
                $tahunAjaran->tanggal_selesai,
            ])
            ->select(
                'mata_pelajaran.id as mata_pelajaran_id',
                'mata_pelajaran.nama_mapel',
                'mata_pelajaran.kelompok_mapel',
                DB::raw('AVG(penilaian_mapel.nilai) as rata_rata_mapel'),
                DB::raw('COUNT(penilaian_mapel.id) as jumlah_penilaian')
            )
            ->groupBy(
                'mata_pelajaran.id',
                'mata_pelajaran.nama_mapel',
                'mata_pelajaran.kelompok_mapel'
            )
            ->get();

        if ($nilaiMapel->isEmpty()) {
            return back()->with(
                'error',
                'Belum ada nilai harian atau ujian pada periode tahun ajaran ini.'
            );
        }

        $deskripsiMapel = DB::table('deskripsi_capaian_mapel')
            ->where('siswa_id', $siswaId)
            ->where('kelas_id', $kelasId)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->where('semester', $tahunAjaran->semester)
            ->pluck('deskripsi_capaian', 'mata_pelajaran_id');

        $nilaiAkhirGuru = DB::table('nilai_akhir_rapor_mapel')
            ->where('siswa_id', $siswaId)
            ->where('kelas_id', $kelasId)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->where('semester', $tahunAjaran->semester)
            ->pluck('nilai_akhir', 'mata_pelajaran_id');

        $rataPjbl = DB::table('penilaian_pjbl')
            ->join('pjbl', 'pjbl.id', '=', 'penilaian_pjbl.pjbl_id')
            ->where('pjbl.kelas_id', $kelasId)
            ->where('pjbl.tahun_ajaran_id', $tahunAjaranId)
            ->where('penilaian_pjbl.siswa_id', $siswaId)
            ->whereBetween('pjbl.tanggal', [
                $tahunAjaran->tanggal_mulai,
                $tahunAjaran->tanggal_selesai,
            ])
            ->avg('penilaian_pjbl.nilai');

        DB::transaction(function () use (
            $kelasId,
            $tahunAjaranId,
            $siswaId,
            $tahunAjaran,
            $nilaiMapel,
            $rataPjbl,
            $deskripsiMapel,
            $nilaiAkhirGuru
        ) {
            $raporId = DB::table('rapor_siswa')
                ->where('siswa_id', $siswaId)
                ->where('kelas_id', $kelasId)
                ->where('tahun_ajaran_id', $tahunAjaranId)
                ->where('semester', $tahunAjaran->semester)
                ->value('id');

            if (!$raporId) {
                $raporId = DB::table('rapor_siswa')->insertGetId([
                    'siswa_id' => $siswaId,
                    'kelas_id' => $kelasId,
                    'tahun_ajaran_id' => $tahunAjaranId,
                    'semester' => $tahunAjaran->semester,
                    'status' => 'draft',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $adaRevisi = false;

            foreach ($nilaiMapel as $mapel) {
                $nilaiRata = round((float) $mapel->rata_rata_mapel, 2);
                $kelompok = strtoupper(trim($mapel->kelompok_mapel ?? ''));

                $mapelKKDDK = in_array($kelompok, [
                    'KK/DDK',
                    'DASAR-DASAR KEJURUAN/KONSENTRASI',
                ], true);

                $nilaiPjblMapel = $mapelKKDDK && $rataPjbl !== null
                    ? round((float) $rataPjbl, 2)
                    : null;

                $nilaiAkhirOtomatis = $mapelKKDDK
                    ? (
                        $nilaiPjblMapel !== null
                            ? round(($nilaiRata + $nilaiPjblMapel) / 2, 2)
                            : null
                    )
                    : $nilaiRata;

                $nilaiAkhirGuruMapel = $nilaiAkhirGuru->get(
                    $mapel->mata_pelajaran_id
                );

                $nilaiAkhir = $nilaiAkhirGuruMapel !== null
                    ? round((float) $nilaiAkhirGuruMapel, 2)
                    : $nilaiAkhirOtomatis;

                $statusDetail = $nilaiAkhir !== null && $nilaiAkhir >= 80
                    ? 'aman'
                    : 'perlu_revisi';

                if ($statusDetail === 'perlu_revisi') {
                    $adaRevisi = true;
                }

                $dataDetail = [
                    'nilai_mapel' => $nilaiRata,
                    'nilai_pjbl' => $nilaiPjblMapel,
                    'nilai_akhir' => $nilaiAkhir,
                    'status' => $statusDetail,
                    'deskripsi_capaian' => $deskripsiMapel->get(
                        $mapel->mata_pelajaran_id
                    ),
                    'updated_at' => now(),
                ];

                $detailAda = DB::table('rapor_detail')
                    ->where('rapor_id', $raporId)
                    ->where('mata_pelajaran_id', $mapel->mata_pelajaran_id)
                    ->exists();

                if ($detailAda) {
                    DB::table('rapor_detail')
                        ->where('rapor_id', $raporId)
                        ->where('mata_pelajaran_id', $mapel->mata_pelajaran_id)
                        ->update($dataDetail);
                } else {
                    $dataDetail['rapor_id'] = $raporId;
                    $dataDetail['mata_pelajaran_id'] = $mapel->mata_pelajaran_id;
                    $dataDetail['created_at'] = now();

                    DB::table('rapor_detail')->insert($dataDetail);
                }
            }

            $adaPermintaanMenunggu = DB::table('permintaan_revisi_rapor')
                ->where('rapor_id', $raporId)
                ->where('status', 'menunggu')
                ->exists();

            DB::table('rapor_siswa')
                ->where('id', $raporId)
                ->update([
                    'status' => ($adaRevisi || $adaPermintaanMenunggu)
                        ? 'perlu_revisi'
                        : 'draft',
                    'updated_at' => now(),
                ]);
        });

        return back()->with(
            'success',
            'Nilai rapor berhasil dihitung. Silakan periksa nilai dan deskripsi capaian.'
        );
    }

    public function detail($kelasId, $tahunAjaranId, $siswaId)
    {
        $user = auth()->user();

        abort_unless($user && $user->guru_id, 403);

        $this->pastikanWaliKelas(
            $user->guru_id,
            $kelasId,
            $tahunAjaranId
        );

        $kelas = DB::table('kelas as k')
            ->join('tahun_ajaran as ta', 'ta.id', '=', 'k.tahun_ajaran_id')
            ->where('k.id', $kelasId)
            ->where('ta.id', $tahunAjaranId)
            ->select(
                'k.id',
                'k.tingkat',
                'k.nama_kelas',
                'k.tahun_ajaran_id',
                'ta.tahun_ajaran',
                'ta.semester'
            )
            ->first();

        abort_unless($kelas !== null, 404);

        $siswa = DB::table('datasiswa')
            ->where('id', $siswaId)
            ->first();

        abort_unless($siswa !== null, 404);

        $rapor = DB::table('rapor_siswa')
            ->where('siswa_id', $siswaId)
            ->where('kelas_id', $kelasId)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->where('semester', $kelas->semester)
            ->first();

        abort_unless($rapor !== null, 404);

        $detail = DB::table('rapor_detail as rd')
            ->join(
                'mata_pelajaran as mp',
                'mp.id',
                '=',
                'rd.mata_pelajaran_id'
            )
            ->leftJoin('deskripsi_capaian_mapel as dcm', function ($join) use (
                $siswaId,
                $kelasId,
                $tahunAjaranId,
                $kelas
            ) {
                $join->on(
                    'dcm.mata_pelajaran_id',
                    '=',
                    'rd.mata_pelajaran_id'
                )
                    ->where('dcm.siswa_id', '=', $siswaId)
                    ->where('dcm.kelas_id', '=', $kelasId)
                    ->where('dcm.tahun_ajaran_id', '=', $tahunAjaranId)
                    ->where('dcm.semester', '=', $kelas->semester);
            })
            ->where('rd.rapor_id', $rapor->id)
            ->select(
                'rd.id',
                'rd.mata_pelajaran_id',
                'mp.nama_mapel',
                'mp.kode_mapel',
                'rd.nilai_mapel',
                'rd.nilai_pjbl',
                'rd.nilai_akhir',
                'rd.status',
                DB::raw(
                    'COALESCE(NULLIF(dcm.deskripsi_capaian, ""), rd.deskripsi_capaian) as deskripsi_capaian'
                )
            )
            ->orderBy('mp.nama_mapel')
            ->get();

        return view(
            'wali-kelas.rapor.detail',
            compact('kelas', 'siswa', 'rapor', 'detail')
        );
    }

    
public function cetak($kelasId, $tahunAjaranId, $siswaId)
{
    $user = auth()->user();

    abort_unless($user && $user->guru_id, 403);

    $this->pastikanWaliKelas(
        $user->guru_id,
        $kelasId,
        $tahunAjaranId
    );

    $kelas = DB::table('kelas as k')
        ->join('tahun_ajaran as ta', 'ta.id', '=', 'k.tahun_ajaran_id')
        ->where('k.id', $kelasId)
        ->where('ta.id', $tahunAjaranId)
        ->select(
            'k.id',
            'k.tingkat',
            'k.nama_kelas',
            'k.tahun_ajaran_id',
            'ta.tahun_ajaran',
            'ta.semester'
        )
        ->first();

    abort_unless($kelas !== null, 404);

    $siswa = DB::table('datasiswa')
        ->where('id', $siswaId)
        ->first();

    abort_unless($siswa !== null, 404);

    $anggotaKelas = DB::table('siswa_kelas')
        ->where('kelas_id', $kelasId)
        ->where('siswa_id', $siswaId)
        ->exists();

    abort_unless($anggotaKelas, 404);

    $rapor = DB::table('rapor_siswa')
        ->where('siswa_id', $siswaId)
        ->where('kelas_id', $kelasId)
        ->where('tahun_ajaran_id', $tahunAjaranId)
        ->where('semester', $kelas->semester)
        ->first();

    abort_unless($rapor !== null, 404);
    abort_unless($rapor->status === 'final', 403, 'Rapor belum final dan tidak dapat dicetak.');

    $detail = DB::table('rapor_detail as rd')
        ->join(
            'mata_pelajaran as mp',
            'mp.id',
            '=',
            'rd.mata_pelajaran_id'
        )
        ->leftJoin('deskripsi_capaian_mapel as dcm', function ($join) use (
            $siswaId,
            $kelasId,
            $tahunAjaranId,
            $kelas
        ) {
            $join->on(
                'dcm.mata_pelajaran_id',
                '=',
                'rd.mata_pelajaran_id'
            )
                ->where('dcm.siswa_id', '=', $siswaId)
                ->where('dcm.kelas_id', '=', $kelasId)
                ->where('dcm.tahun_ajaran_id', '=', $tahunAjaranId)
                ->where('dcm.semester', '=', $kelas->semester);
        })
        ->where('rd.rapor_id', $rapor->id)
        ->select(
            'rd.id',
            'rd.mata_pelajaran_id',
            'mp.nama_mapel',
            'mp.kode_mapel',
            'rd.nilai_mapel',
            'rd.nilai_pjbl',
            'rd.nilai_akhir',
            'rd.status',
            DB::raw(
                'COALESCE(NULLIF(dcm.deskripsi_capaian, ""), rd.deskripsi_capaian) as deskripsi_capaian'
            )
        )
        ->orderBy('mp.nama_mapel')
        ->get();

    return view(
        'wali-kelas.rapor.cetak',
        compact('kelas', 'siswa', 'rapor', 'detail')
    );
}

    public function updateDetail(
        Request $request,
        $kelasId,
        $tahunAjaranId,
        $siswaId
    ) {
        $user = auth()->user();

        abort_unless($user && $user->guru_id, 403);

        $this->pastikanWaliKelas(
            $user->guru_id,
            $kelasId,
            $tahunAjaranId
        );

        $data = $request->validate([
            'catatan_wali_kelas' => 'nullable|string|max:5000',
        ]);

        $tahunAjaran = DB::table('tahun_ajaran')
            ->where('id', $tahunAjaranId)
            ->first();

        abort_unless($tahunAjaran !== null, 404);

        $rapor = DB::table('rapor_siswa')
            ->where('siswa_id', $siswaId)
            ->where('kelas_id', $kelasId)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->where('semester', $tahunAjaran->semester)
            ->first();

        abort_unless($rapor !== null, 404);

        if ($rapor->status === 'final') {
            return back()->with(
                'error',
                'Rapor final tidak dapat diubah.'
            );
        }

        DB::table('rapor_siswa')
            ->where('id', $rapor->id)
            ->update([
                'catatan_wali_kelas' => $data['catatan_wali_kelas'] ?? null,
                'updated_at' => now(),
            ]);

        return back()->with(
            'success',
            'Catatan wali kelas berhasil disimpan.'
        );
    }

    public function mintaRevisi(
        Request $request,
        $kelasId,
        $tahunAjaranId,
        $siswaId
    ) {
        $user = auth()->user();

        abort_unless($user && $user->guru_id, 403);

        $this->pastikanWaliKelas(
            $user->guru_id,
            $kelasId,
            $tahunAjaranId
        );

        $data = $request->validate([
            'mata_pelajaran_id' => 'required|integer',
            'alasan_revisi' => 'required|string|max:5000',
        ]);

        $kelas = DB::table('kelas as k')
            ->join('tahun_ajaran as ta', 'ta.id', '=', 'k.tahun_ajaran_id')
            ->where('k.id', $kelasId)
            ->where('ta.id', $tahunAjaranId)
            ->select(
                'k.id',
                'k.tahun_ajaran_id',
                'ta.semester'
            )
            ->first();

        abort_unless($kelas !== null, 404);

        $rapor = DB::table('rapor_siswa')
            ->where('siswa_id', $siswaId)
            ->where('kelas_id', $kelasId)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->where('semester', $kelas->semester)
            ->first();

        abort_unless($rapor !== null, 404);

        if ($rapor->status === 'final') {
            return back()->with(
                'error',
                'Rapor yang sudah final tidak dapat diminta revisi.'
            );
        }

        $detailAda = DB::table('rapor_detail')
            ->where('rapor_id', $rapor->id)
            ->where('mata_pelajaran_id', $data['mata_pelajaran_id'])
            ->exists();

        if (!$detailAda) {
            return back()->with(
                'error',
                'Mata pelajaran tidak ditemukan dalam rapor siswa ini.'
            );
        }

        $guruIds = DB::table('jadwal_pelajaran as jp')
            ->join('users as u', 'u.guru_id', '=', 'jp.guru_id')
            ->where('jp.kelas_id', $kelasId)
            ->where('jp.mata_pelajaran_id', $data['mata_pelajaran_id'])
            ->whereNotNull('u.guru_id')
            ->distinct()
            ->pluck('jp.guru_id');

        if ($guruIds->isEmpty()) {
            return back()->with(
                'error',
                'Tidak ditemukan akun guru untuk mata pelajaran tersebut.'
            );
        }

        $adaPermintaanBaru = false;

        DB::transaction(function () use (
            $guruIds,
            $rapor,
            $siswaId,
            $kelasId,
            $tahunAjaranId,
            $kelas,
            $data,
            &$adaPermintaanBaru
        ) {
            foreach ($guruIds as $guruId) {
                $sudahAda = DB::table('permintaan_revisi_rapor')
                    ->where('rapor_id', $rapor->id)
                    ->where('mata_pelajaran_id', $data['mata_pelajaran_id'])
                    ->where('guru_id', $guruId)
                    ->where('status', 'menunggu')
                    ->exists();

                if ($sudahAda) {
                    continue;
                }

                DB::table('permintaan_revisi_rapor')->insert([
                    'rapor_id' => $rapor->id,
                    'siswa_id' => $siswaId,
                    'kelas_id' => $kelasId,
                    'tahun_ajaran_id' => $tahunAjaranId,
                    'semester' => $kelas->semester,
                    'mata_pelajaran_id' => $data['mata_pelajaran_id'],
                    'guru_id' => $guruId,
                    'alasan_revisi' => $data['alasan_revisi'],
                    'status' => 'menunggu',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $adaPermintaanBaru = true;
            }

            DB::table('rapor_siswa')
                ->where('id', $rapor->id)
                ->update([
                    'status' => 'perlu_revisi',
                    'updated_at' => now(),
                ]);
        });

        return back()->with(
            $adaPermintaanBaru ? 'success' : 'error',
            $adaPermintaanBaru
                ? 'Permintaan revisi berhasil dikirim kepada guru mata pelajaran.'
                : 'Permintaan revisi untuk mata pelajaran ini sudah menunggu tindak lanjut guru.'
        );
    }

    public function finalisasi($kelasId, $tahunAjaranId, $siswaId)
    {
        $user = auth()->user();

        abort_unless($user && $user->guru_id, 403);

        $this->pastikanWaliKelas(
            $user->guru_id,
            $kelasId,
            $tahunAjaranId
        );

        $tahunAjaran = DB::table('tahun_ajaran')
            ->where('id', $tahunAjaranId)
            ->first();

        abort_unless($tahunAjaran !== null, 404);

        $rapor = DB::table('rapor_siswa')
            ->where('siswa_id', $siswaId)
            ->where('kelas_id', $kelasId)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->where('semester', $tahunAjaran->semester)
            ->first();

        abort_unless($rapor !== null, 404);

        if ($rapor->status === 'final') {
            return back()->with(
                'error',
                'Rapor ini sudah final.'
            );
        }

        $jumlahDetail = DB::table('rapor_detail')
            ->where('rapor_id', $rapor->id)
            ->count();

        if ($jumlahDetail === 0) {
            return back()->with(
                'error',
                'Rapor belum memiliki nilai mata pelajaran.'
            );
        }

        $adaPermintaanMenunggu = DB::table('permintaan_revisi_rapor')
            ->where('rapor_id', $rapor->id)
            ->where('status', 'menunggu')
            ->exists();

        if ($adaPermintaanMenunggu) {
            return back()->with(
                'error',
                'Masih ada permintaan revisi yang belum diselesaikan oleh guru mata pelajaran.'
            );
        }

        $adaRevisi = DB::table('rapor_detail')
            ->where('rapor_id', $rapor->id)
            ->where('status', 'perlu_revisi')
            ->exists();

        if ($adaRevisi) {
            return back()->with(
                'error',
                'Rapor masih memiliki nilai yang perlu direvisi. Periksa kembali sebelum finalisasi.'
            );
        }

        $deskripsiKosong = DB::table('rapor_detail')
            ->where('rapor_id', $rapor->id)
            ->where(function ($query) {
                $query->whereNull('deskripsi_capaian')
                    ->orWhere('deskripsi_capaian', '');
            })
            ->exists();

        if ($deskripsiKosong) {
            return back()->with(
                'error',
                'Masih ada deskripsi capaian mata pelajaran yang belum diisi oleh guru mapel.'
            );
        }

        DB::table('rapor_siswa')
            ->where('id', $rapor->id)
            ->update([
                'status' => 'final',
                'finalized_at' => now(),
                'updated_at' => now(),
            ]);

        return back()->with(
            'success',
            'Rapor berhasil difinalisasi.'
        );
    }

    public function publikasikan($kelasId, $tahunAjaranId, $siswaId)
{
    $user = auth()->user();

    abort_unless($user && $user->guru_id, 403);

    $this->pastikanWaliKelas(
        $user->guru_id,
        $kelasId,
        $tahunAjaranId
    );

    $rapor = DB::table('rapor_siswa')
        ->where('siswa_id', $siswaId)
        ->where('kelas_id', $kelasId)
        ->where('tahun_ajaran_id', $tahunAjaranId)
        ->first();

    abort_unless($rapor, 404);

    if ($rapor->status !== 'final') {
        return back()->with(
            'error',
            'Rapor harus difinalisasi sebelum dipublikasikan.'
        );
    }

    if ($rapor->dipublikasikan_at !== null) {
        return back()->with(
            'error',
            'Rapor ini sudah dipublikasikan.'
        );
    }

    DB::table('rapor_siswa')
        ->where('id', $rapor->id)
        ->update([
            'dipublikasikan_at' => now(),
            'updated_at' => now(),
        ]);

    return back()->with(
        'success',
        'Rapor berhasil dipublikasikan dan dapat dilihat siswa.'
    );
}

    private function pastikanWaliKelas(
        $guruId,
        $kelasId,
        $tahunAjaranId
    ) {
        $penugasan = DB::table('wali_kelas')
            ->where('guru_id', $guruId)
            ->where('kelas_id', $kelasId)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->exists();

        abort_unless($penugasan, 403);
    }
}
