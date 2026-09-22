<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal_pelajaran;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Models\Ruangan;
use App\Models\Jurusan;
use Barryvdh\DomPDF\Facade\Pdf;

class JadwalPelajaranController extends Controller
{
    public function index(Request $request)
    {
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $jurusanList = Jurusan::orderBy('nama_jurusan')->get();
        $selectedJurusan = $request->input('jurusan_id');
        $jumlahJpPerHari = $this->jumlahJpPerHari();

        $jadwalQuery = Jadwal_pelajaran::with(['kelas.jurusan', 'guru', 'mataPelajaran', 'ruangan']);

        if ($selectedJurusan) {
            $jadwalQuery->whereHas('kelas', function ($query) use ($selectedJurusan) {
                $query->where('jurusan_id', $selectedJurusan);
            });
        }

        $jadwal = $jadwalQuery
            ->orderBy('id')
            ->get();

        $jadwalPerKelas = $jadwal
            ->groupBy('kelas_id')
            ->sortBy(function ($items) {
                $kelas = $items->first()->kelas;

                return sprintf(
                    '%s-%s-%s',
                    $kelas->tingkat ?? '',
                    optional($kelas->jurusan)->nama_jurusan ?? '',
                    $kelas->nama_kelas ?? ''
                );
            });

        $mapelLegenda = $jadwal
            ->filter(fn($item) => $item->mataPelajaran)
            ->pluck('mataPelajaran')
            ->unique('id')
            ->sortBy('kode_mapel')
            ->values();

        return view('admin.jadwal_pelajaran.index', compact(
            'hari',
            'jadwalPerKelas',
            'jurusanList',
            'mapelLegenda',
            'selectedJurusan',
            'jumlahJpPerHari'
        ));
    }

    public function exportExcel(Request $request)
    {
        $selectedJurusan = $request->input('jurusan_id');
        $jadwalQuery = Jadwal_pelajaran::with(['kelas.jurusan', 'guru', 'mataPelajaran', 'ruangan'])
            ->orderBy('kelas_id')
            ->orderBy('hari')
            ->orderBy('id');

        if (auth()->user()?->role_id == 3) {
            $kelasId = auth()->user()->siswa?->siswaKelas?->first()?->kelas_id;
            $jadwalQuery->where('kelas_id', $kelasId ?? 0)->where('is_published', 1);
        }

        if ($selectedJurusan) {
            $jadwalQuery->whereHas('kelas', function ($query) use ($selectedJurusan) {
                $query->where('jurusan_id', $selectedJurusan);
            });
        }

        $jadwal = $jadwalQuery->get();

        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $jumlahJpPerHari = $this->jumlahJpPerHari();
        $jadwalPerKelas = $jadwal->groupBy('kelas_id');

        return response()->streamDownload(function () use ($hari, $jadwalPerKelas, $jumlahJpPerHari) {
            $escape = static fn($value) => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
            $warnaMapel = static fn($item) => $escape(optional($item->mataPelajaran)->warna ?? '#d3d3d3');

            echo '<html><head><meta charset="UTF-8"><style>';
            echo 'table{border-collapse:collapse;font-family:Arial,sans-serif;font-size:11px;}';
            echo 'th,td{border:1px solid #777;text-align:center;vertical-align:middle;height:24px;padding:2px;}';
            echo '.kelas{width:90px;background:#f2f2f2;font-weight:bold;}';
            echo '.info{width:55px;background:#f2f2f2;font-weight:bold;}';
            echo '.hari{background:#dce6f1;font-weight:bold;}';
            echo '.jp{background:#eef5ed;font-weight:normal;width:25px;}';
            echo '.guru,.ruang{background:#fff;}';
            echo '</style></head><body><table>';
            echo '<tr><th class="kelas" rowspan="2">Kelas</th><th class="info" rowspan="2">Info</th>';
            foreach ($hari as $namaHari) {
                echo '<th class="hari" colspan="' . $jumlahJpPerHari[$namaHari] . '">' . $escape(strtoupper($namaHari)) . '</th>';
            }
            echo '</tr><tr>';
            foreach ($hari as $namaHari) {
                for ($jp = 1; $jp <= $jumlahJpPerHari[$namaHari]; $jp++) {
                    echo '<th class="jp">' . $jp . '</th>';
                }
            }
            echo '</tr>';

            foreach ($jadwalPerKelas as $jadwalKelas) {
                $kelas = $jadwalKelas->first()->kelas;
                $kelasLabel = ($kelas->nama_kelas ?? $jadwalKelas->first()->kelas_id) . '<br><small>Tingkat ' .
                    $escape($kelas->tingkat ?? '-') . ' - ' .
                    $escape(optional($kelas->jurusan)->kode_jurusan ?? '-') . '</small>';

                foreach (['mapel', 'guru', 'ruang'] as $baris => $jenisBaris) {
                    echo '<tr>';
                    if ($baris === 0) {
                        echo '<td class="kelas" rowspan="3">' . $kelasLabel . '</td>';
                    }
                    echo '<td class="info">' . ucfirst($jenisBaris) . '</td>';

                    foreach ($hari as $namaHari) {
                        $jadwalHari = $jadwalKelas
                            ->filter(fn($item) => strtolower($item->hari) === strtolower($namaHari))
                            ->values();
                        $jpPosisi = 0;

                        foreach ($jadwalHari as $item) {
                            $jumlahJp = min(max((int) ($item->jumlah_jp ?? 1), 1), $jumlahJpPerHari[$namaHari] - $jpPosisi);
                            $nilai = match ($jenisBaris) {
                                'mapel' => optional($item->mataPelajaran)->kode_mapel ?? ($item->mata_pelajaran_id ?? '-'),
                                'guru' => optional($item->guru)->kode_guru ?? $item->guru_id,
                                default => optional($item->ruangan)->kode_ruang ?? ($item->ruangan_id ?? '-'),
                            };
                            $class = $jenisBaris === 'mapel' ? '' : ($jenisBaris === 'guru' ? ' guru' : ' ruang');
                            $style = $jenisBaris === 'mapel' ? ' style="background-color:' . $warnaMapel($item) . ';"' : '';
                            echo '<td colspan="' . $jumlahJp . '" class="' . trim($class) . '"' . $style . '>' . $escape($nilai) . '</td>';
                            $jpPosisi += $jumlahJp;
                        }

                        if ($jpPosisi < $jumlahJpPerHari[$namaHari]) {
                            echo '<td colspan="' . ($jumlahJpPerHari[$namaHari] - $jpPosisi) . '"></td>';
                        }
                    }
                    echo '</tr>';
                }
            }

            echo '</table></body></html>';
        }, 'jadwal-pelajaran.xls', [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
        ]);
    }

    public function exportPdf(Request $request)
    {
        $selectedJurusan = $request->input('jurusan_id');
        $jadwalQuery = Jadwal_pelajaran::with(['kelas.jurusan', 'guru', 'mataPelajaran', 'ruangan'])
            ->orderBy('kelas_id')
            ->orderBy('id');

        if (auth()->user()?->role_id == 3) {
            $kelasId = auth()->user()->siswa?->siswaKelas?->first()?->kelas_id;
            $jadwalQuery->where('kelas_id', $kelasId ?? 0)->where('is_published', 1);
        }

        if ($selectedJurusan) {
            $jadwalQuery->whereHas('kelas', function ($query) use ($selectedJurusan) {
                $query->where('jurusan_id', $selectedJurusan);
            });
        }

        $jadwalPerKelas = $jadwalQuery->get()->groupBy('kelas_id');

        return Pdf::loadView('admin.jadwal_pelajaran.pdf', [
            'hari' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'],
            'jadwalPerKelas' => $jadwalPerKelas,
            'jumlahJpPerHari' => $this->jumlahJpPerHari(),
        ])->setPaper('a3', 'landscape')->download('jadwal-pelajaran.pdf');
    }

    public function create()
    {
        $kelas = Kelas::with('jurusan')->get();
        $guru = Guru::all();
        $mapel = MataPelajaran::all();
        $ruangan = Ruangan::all();
        $jumlahJpPerHari = $this->jumlahJpPerHari();

        return view(
            'admin.jadwal_pelajaran.create',
            compact('kelas', 'guru', 'mapel', 'ruangan', 'jumlahJpPerHari')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required',
            'hari' => 'required',
            'mapel_id' => 'required|array|min:1',
            'mapel_id.*' => 'required|distinct|exists:mata_pelajaran,id',
            'guru_id' => 'required|array',
            'guru_id.*' => 'required|exists:dataguru,id',
            'ruang_id' => 'required|array',
            'ruang_id.*' => 'required|exists:ruangan,id',
            'jumlah_jp' => 'required|array',
            'jumlah_jp.*' => 'required|integer|min:1|max:12',
        ]);

        foreach ($request->mapel_id as $index => $mapelId) {
            Jadwal_pelajaran::create([
                'kelas_id' => $request->kelas_id,
                'guru_id' => $request->guru_id[$index],
                'mata_pelajaran_id' => $mapelId,
                'ruangan_id' => $request->ruang_id[$index],
                'hari' => $request->hari,
                'jumlah_jp' => $request->jumlah_jp[$index],
                'jam_mulai' => null,
                'jam_selesai' => null,
            ]);
        }

        return redirect()->route('admin.jadwal_pelajaran.index')
            ->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $jadwal = Jadwal_pelajaran::findOrFail($id);

        $kelas = Kelas::with('jurusan')->get();
        $guru = Guru::all();
        $mapel = MataPelajaran::all();
        $ruangan = Ruangan::all();

        return view(
            'admin.jadwal_pelajaran.edit',
            compact('jadwal', 'kelas', 'guru', 'mapel', 'ruangan')
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kelas_id' => 'required',
            'guru_id' => 'required',
            'mapel_id' => 'required',
            'ruang_id' => 'required',
            'hari' => 'required',
            'jumlah_jp' => 'required|integer|min:1|max:12',
        ]);

        $jadwal = Jadwal_pelajaran::findOrFail($id);

        $jadwal->update([
            'kelas_id' => $request->kelas_id,
            'guru_id' => $request->guru_id,
            'mata_pelajaran_id' => $request->mapel_id,
            'ruangan_id' => $request->ruang_id,
            'hari' => $request->hari,
            'jam_mulai' => null,
            'jam_selesai' => null,
            'jumlah_jp' => $request->jumlah_jp,
        ]);

        return redirect()
            ->route('admin.jadwal_pelajaran.index')
            ->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $jadwal = Jadwal_pelajaran::findOrFail($id);

        $jadwal->delete();

        return redirect()
            ->route('admin.jadwal_pelajaran.index')
            ->with('success', 'Jadwal berhasil dihapus!');
    }

    public function editHari($kelasId, $hari)
    {
        $jadwal = Jadwal_pelajaran::where('kelas_id', $kelasId)
            ->where('hari', $hari)
            ->with(['kelas.jurusan', 'guru', 'mataPelajaran', 'ruangan'])
            ->orderBy('id')
            ->get();

        abort_if($jadwal->isEmpty(), 404);

        return view('admin.jadwal_pelajaran.edit_hari', [
            'jadwal' => $jadwal,
            'kelas' => Kelas::with('jurusan')->get(),
            'guru' => Guru::all(),
            'mapel' => MataPelajaran::all(),
            'ruangan' => Ruangan::all(),
            'jumlahJpPerHari' => $this->jumlahJpPerHari(),
            'kelasTerpilih' => $jadwal->first()->kelas,
            'hariTerpilih' => $hari,
        ]);
    }

    public function updateHari(Request $request, $kelasId, $hari)
    {
        $request->validate([
            'jadwal_id' => 'required|array|min:1',
            'jadwal_id.*' => 'required|exists:jadwal_pelajaran,id',
            'mapel_id' => 'required|array',
            'mapel_id.*' => 'required|distinct|exists:mata_pelajaran,id',
            'guru_id.*' => 'required|exists:dataguru,id',
            'ruang_id.*' => 'required|exists:ruangan,id',
            'jumlah_jp.*' => 'required|integer|min:1|max:12',
        ]);

        $jadwalKelasHari = Jadwal_pelajaran::where('kelas_id', $kelasId)
            ->where('hari', $hari)
            ->get()
            ->keyBy('id');

        foreach ($request->jadwal_id as $index => $jadwalId) {
            $item = $jadwalKelasHari->get($jadwalId);
            abort_if(!$item, 403);

            $item->update([
                'mata_pelajaran_id' => $request->mapel_id[$index],
                'guru_id' => $request->guru_id[$index],
                'ruangan_id' => $request->ruang_id[$index],
                'jumlah_jp' => $request->jumlah_jp[$index],
                'jam_mulai' => null,
                'jam_selesai' => null,
            ]);
        }

        return redirect()->route('admin.jadwal_pelajaran.index')
            ->with('success', 'Semua jadwal pada hari tersebut berhasil diperbarui!');
    }

    public function destroyHari($kelasId, $hari)
    {
        Jadwal_pelajaran::where('kelas_id', $kelasId)
            ->where('hari', $hari)
            ->delete();

        return redirect()->route('admin.jadwal_pelajaran.index')
            ->with('success', 'Semua jadwal pada hari tersebut berhasil dihapus!');
    }

    public function publish()
    {
        Jadwal_pelajaran::query()->update([
            'is_published' => true
        ]);

        return back()->with('success', 'Semua jadwal berhasil dipublikasikan.');
    }

    private function jumlahJpPerHari(): array
    {
        return [
            'Senin' => 10,
            'Selasa' => 12,
            'Rabu' => 10,
            'Kamis' => 12,
            'Jumat' => 6,
        ];
    }
}
