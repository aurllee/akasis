<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 12px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 8px;
        }

        h2 {
            text-align: center;
            margin: 0 0 8px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #64748b;
            padding: 2px;
            text-align: center;
            vertical-align: middle;
            height: 18px;
            overflow-wrap: anywhere;
        }

        th {
            background: #dce6f1;
            font-weight: bold;
        }

        .kelas {
            width: 72px;
            background: #f1f5fb;
            font-weight: bold;
        }

        .info {
            width: 48px;
            background: #f1f5fb;
            font-weight: bold;
        }

        .day {
            width: 145px;
        }

        .jp {
            font-weight: normal;
            background: #eef5ed;
            width: 20px;
        }

        .label {
            font-weight: bold;
            background: #f8fafc;
        }

        .guru,
        .ruang {
            background: #ffffff;
            font-size: 7px;
        }

        .mapel {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2>JADWAL PELAJARAN</h2>
    <table>
        <thead>
            <tr>
                <th class="kelas" rowspan="2">Kelas</th>
                <th class="info" rowspan="2">Info</th>
                @foreach ($hari as $namaHari)
                    <th class="day" colspan="{{ $jumlahJpPerHari[$namaHari] ?? 10 }}">{{ strtoupper($namaHari) }}</th>
                @endforeach
            </tr>
            <tr>
                @foreach ($hari as $namaHari)
                    @for ($jp = 1; $jp <= ($jumlahJpPerHari[$namaHari] ?? 10); $jp++)
                        <th class="jp">{{ $jp }}</th>
                    @endfor
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse ($jadwalPerKelas as $jadwalKelas)
                @php
                    $kelas = $jadwalKelas->first()->kelas;
                    $labelKelas = trim(($kelas->tingkat ?? '-') . ' ' .
                        (optional($kelas->jurusan)->kode_jurusan ?? optional($kelas->jurusan)->nama_jurusan ?? '-') . ' ' .
                        ($kelas->nama_kelas ?? $jadwalKelas->first()->kelas_id));
                @endphp
                @foreach (['mapel', 'guru', 'ruang'] as $baris => $jenisBaris)
                    <tr>
                        @if ($baris === 0)
                            <td class="kelas" rowspan="3">
                                <strong>{{ $labelKelas }}</strong>
                            </td>
                        @endif
                        <td class="info label">{{ $jenisBaris === 'ruang' ? 'Ruangan' : ucfirst($jenisBaris) }}</td>
                        @foreach ($hari as $namaHari)
                            @php
                                $jadwalHari = $jadwalKelas->filter(fn($item) => strtolower($item->hari) === strtolower($namaHari))->values();
                                $jumlahJpHari = $jumlahJpPerHari[$namaHari] ?? 10;
                                $jpPosisi = 0;
                            @endphp
                            @foreach ($jadwalHari as $item)
                                @php
                                    $jumlahJp = min(max((int) ($item->jumlah_jp ?? 1), 1), $jumlahJpHari - $jpPosisi);
                                    $nilai = match ($jenisBaris) {
                                        'mapel' => optional($item->mapel)->kode_mapel ?? ($item->mata_pelajaran_id ?? '-'),
                                        'guru' => optional($item->guru)->kode_guru ?? $item->guru_id,
                                        default => trim((optional($item->ruangan)->kode_ruang ?? ($item->ruangan_id ?? '-')) . ' - ' . (optional($item->ruangan)->nama_ruang ?? '')),
                                    };
                                @endphp
                                <td colspan="{{ $jumlahJp }}" class="{{ $jenisBaris }}" @if ($jenisBaris === 'mapel')
                                style="background-color: {{ optional($item->mapel)->warna ?? '#d3d3d3' }}" @endif>{{ $nilai }}</td>
                                @php $jpPosisi += $jumlahJp; @endphp
                            @endforeach
                            @if ($jpPosisi < $jumlahJpHari)
                                <td colspan="{{ $jumlahJpHari - $jpPosisi }}"></td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="57">Belum ada data jadwal pelajaran.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>