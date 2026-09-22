<?php

namespace App\Http\Controllers\Walikelas;

use App\Http\Controllers\Controller;
use App\Models\Dispen;
use App\Models\IzinKeluar;
use App\Models\IzinPulang;
use App\Models\Sakit;
use App\Models\Siswa;
use App\Models\SiswaKelas;
use App\Models\WaliKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AbsenController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal', now()->format('Y-m-d'));
        $guruId = auth()->user()?->guru_id;

        $waliKelas = WaliKelas::with('kelas')
            ->where('guru_id', $guruId)
            ->first();

        $kelasIds = WaliKelas::where('guru_id', $guruId)
            ->pluck('kelas_id');

        $siswaIds = SiswaKelas::whereIn('kelas_id', $kelasIds)
            ->pluck('siswa_id')
            ->filter()
            ->unique();
        $izinPerSiswa = collect();
        $siswaById = Siswa::whereIn('id', $siswaIds)->get()->keyBy('id');
        $columns = function (string $table, array $optional = []): array {
            return array_merge(
                ['siswa_id', 'alasan'],
                array_values(array_filter(
                    $optional,
                    fn (string $column) => Schema::hasColumn($table, $column)
                ))
            );
        };

        Sakit::whereDate('tanggal', $tanggal)
            ->whereIn('siswa_id', $siswaIds)
            ->get($columns('sakit', ['dokumen']))
            ->each(fn ($izin) => $izinPerSiswa->push([
                'siswa_id' => $izin->siswa_id,
                'tanggal' => $tanggal,
                'keterangan' => 'Sakit',
                'alasan' => $izin->alasan,
                'dokumen' => $izin->dokumen ?? null,
            ]));

        IzinPulang::whereDate('tanggal', $tanggal)
            ->whereIn('siswa_id', $siswaIds)
            ->get($columns('izin_pulang', ['dokumen']))
            ->each(fn ($izin) => $izinPerSiswa->push([
                'siswa_id' => $izin->siswa_id,
                'tanggal' => $tanggal,
                'keterangan' => 'Izin Pulang',
                'alasan' => $izin->alasan,
                'dokumen' => $izin->dokumen ?? null,
            ]));

        IzinKeluar::whereDate('tanggal', $tanggal)
            ->whereIn('siswa_id', $siswaIds)
            ->get($columns('izin_keluar', ['dokumen']))
            ->each(fn ($izin) => $izinPerSiswa->push([
                'siswa_id' => $izin->siswa_id,
                'tanggal' => $tanggal,
                'keterangan' => 'Izin Keluar',
                'alasan' => $izin->alasan,
                'dokumen' => $izin->dokumen ?? null,
            ]));

        Dispen::whereDate('tanggal_mulai', '<=', $tanggal)
            ->whereDate('tanggal_selesai', '>=', $tanggal)
            ->whereIn('siswa_id', $siswaIds)
            ->get(array_merge(
                ['siswa_id', 'kegiatan', 'alasan'],
                Schema::hasColumn('dispen', 'surat') ? ['surat'] : []
            ))
            ->each(fn ($izin) => $izinPerSiswa->push([
                'siswa_id' => $izin->siswa_id,
                'tanggal' => $tanggal,
                'keterangan' => 'Dispen',
                'alasan' => $izin->alasan ?: $izin->kegiatan,
                'dokumen' => $izin->surat ?? null,
            ]));

        $absensi = $izinPerSiswa
            ->map(function (array $izin) use ($siswaById) {
                $izin['nama'] = $siswaById->get($izin['siswa_id'])?->nama ?? '-';
                return (object) $izin;
            })
            ->sortBy('nama')
            ->values();

        $kelas = $waliKelas?->kelas
            ? trim(($waliKelas->kelas->tingkat ?? '') . ' ' . ($waliKelas->kelas->nama_kelas ?? ''))
            : null;

        return view('wali-kelas.absensi', compact('tanggal', 'absensi', 'kelas'));
    }
}
