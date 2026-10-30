<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapor {{ $siswa->nama }}</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 15mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            line-height: 1.5;
            color: #222;
            margin: 0;
            background: #f1f5f9;
        }

        .page {
            max-width: 210mm;
            min-height: 297mm;
            margin: 20px auto;
            padding: 15mm;
            background: #fff;
        }

        .toolbar {
            max-width: 210mm;
            margin: 20px auto 0;
            display: flex;
            gap: 8px;
        }

        .toolbar button,
        .toolbar a {
            padding: 10px 16px;
            border: 0;
            border-radius: 5px;
            background: #166534;
            color: white;
            text-decoration: none;
            font-size: 13px;
            cursor: pointer;
        }

        .toolbar a {
            background: #475569;
        }

        .school-header {
            text-align: center;
            padding-bottom: 12px;
            margin-bottom: 18px;
            border-bottom: 3px double #222;
        }

        .school-header h1 {
            font-size: 18px;
            margin: 0 0 5px;
            text-transform: uppercase;
        }

        .school-header p {
            margin: 0;
            font-size: 11px;
        }

        h2 {
            font-size: 15px;
            text-align: center;
            margin: 18px 0;
            text-transform: uppercase;
        }

        .student-info {
            width: 100%;
            margin-bottom: 18px;
            border-collapse: collapse;
        }

        .student-info td {
            padding: 3px 5px;
            vertical-align: top;
        }

        .student-info td:first-child {
            width: 145px;
        }

        .grades {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .grades th,
        .grades td {
            border: 1px solid #555;
            padding: 7px 6px;
            vertical-align: top;
            overflow-wrap: anywhere;
        }

        .grades th {
            background: #e2e8f0;
            text-align: center;
        }

        .grades th:nth-child(1) {
            width: 30px;
        }

        .grades th:nth-child(2) {
            width: 23%;
        }

        .grades th:nth-child(3) {
            width: 65px;
        }

        .grades th:nth-child(4) {
            width: 55px;
        }

        .grades td.center {
            text-align: center;
        }

        .section-title {
            font-size: 12px;
            margin: 22px 0 7px;
        }

        .note {
            min-height: 55px;
            padding: 9px;
            border: 1px solid #555;
            white-space: pre-wrap;
            overflow-wrap: anywhere;
        }

        .signature {
            width: 100%;
            margin-top: 35px;
            border-collapse: collapse;
            page-break-inside: avoid;
        }

        .signature td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 5px;
        }

        .signature-space {
            height: 65px;
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }

        .footer {
            margin-top: 20px;
            font-size: 9px;
            text-align: center;
            color: #555;
        }

        @media print {
            body {
                background: #fff;
                font-size: 10px;
            }

            .page {
                width: auto;
                min-height: 0;
                max-width: none;
                margin: 0;
                padding: 0;
            }

            .toolbar {
                display: none !important;
            }

            .grades tr {
                page-break-inside: avoid;
            }

            .school-header,
            .grades th {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="toolbar">
        <button type="button" onclick="window.print()">
            Cetak / Simpan PDF
        </button>

        <a href="{{ route('wali-kelas.rapor.detail', [
            'kelasId' => $kelas->id,
            'tahunAjaranId' => $kelas->tahun_ajaran_id,
            'siswaId' => $siswa->id
        ]) }}">
            Kembali
        </a>
    </div>

    <main class="page">
        <header class="school-header">
            <h1>Laporan Hasil Belajar Siswa</h1>
            <p>Dokumen Rapor Digital</p>
        </header>

        <h2>Rapor Siswa</h2>

        <table class="student-info">
            <tr>
                <td>Nama Siswa</td>
                <td>: {{ $siswa->nama }}</td>
            </tr>
            <tr>
                <td>NIS</td>
                <td>: {{ $siswa->nis }}</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>: {{ $kelas->tingkat }} {{ $kelas->nama_kelas }}</td>
            </tr>
            <tr>
                <td>Tahun Ajaran</td>
                <td>: {{ $kelas->tahun_ajaran }}</td>
            </tr>
            <tr>
                <td>Semester</td>
                <td>: {{ $kelas->semester }}</td>
            </tr>
            <tr>
                <td>Status Rapor</td>
                <td>: Final</td>
            </tr>
            <tr>
                <td>Tanggal Finalisasi</td>
                <td>: {{ $rapor->finalized_at
                    ? \Carbon\Carbon::parse($rapor->finalized_at)->format('d-m-Y H:i')
                    : '-' }}
                </td>
            </tr>
        </table>

        <table class="grades">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Mata Pelajaran</th>
                    <th>Nilai Akhir</th>
                    <th>Predikat</th>
                    <th>Deskripsi Capaian</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($detail as $item)
                    @php
                        $nilai = $item->nilai_akhir;

                        if ($nilai === null || $nilai === '') {
                            $predikat = '-';
                        } elseif ($nilai >= 90) {
                            $predikat = 'A';
                        } elseif ($nilai >= 80) {
                            $predikat = 'B';
                        } elseif ($nilai >= 70) {
                            $predikat = 'C';
                        } else {
                            $predikat = 'D';
                        }
                    @endphp

                    <tr>
                        <td class="center">{{ $loop->iteration }}</td>
                        <td>
                            {{ $item->nama_mapel }}
                            @if ($item->kode_mapel)
                                <br>
                                <small>{{ $item->kode_mapel }}</small>
                            @endif
                        </td>
                        <td class="center">
                            {{ $nilai !== null ? $nilai : '-' }}
                        </td>
                        <td class="center">{{ $predikat }}</td>
                        <td>
                            {{ filled($item->deskripsi_capaian)
                                ? $item->deskripsi_capaian
                                : '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="center">
                            Belum ada data nilai.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <h3 class="section-title">Catatan Wali Kelas</h3>

        <div class="note">{{ filled($rapor->catatan_wali_kelas)
            ? $rapor->catatan_wali_kelas
            : 'Tidak ada catatan.' }}</div>

        <table class="signature">
            <tr>
                <td>
                    Orang Tua / Wali
                    <div class="signature-space"></div>
                    (........................................)
                </td>
                <td>
                    Wali Kelas
                    <div class="signature-space"></div>
                    <span class="signature-name">
                        {{ $user->name ?? '........................................' }}
                    </span>
                </td>
            </tr>
        </table>

        <div class="footer">
            Dokumen rapor digital dengan status final.
        </div>
    </main>
</body>
</html>
