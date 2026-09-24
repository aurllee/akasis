@extends('layouts.app')

@section('title', 'Jadwal Pelajaran')

@push('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f7fb;
            color: #1f2937;
        }

        .schedule-page {
            width: 100%;
        }

        .schedule-page>.card {
            background: #ffffff;
            border: 1px solid #e5e7eb !important;
            border-radius: 14px;
            box-shadow: 0 6px 18px rgba(30, 64, 102, 0.06) !important;
        }

        .schedule-table-wrap {
            background-color: white;
            padding: 24px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow-x: auto;
            margin-top: 25px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
        }

        .schedule-page h1 {
            margin: 0 0 5px;
            color: #172554;
            font-weight: 500;
            font-size: 25px;
        }

        .schedule-page .header p {
            color: #64748b;
            margin: 0;
        }

        .toolbar {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 16px;
        }

        .download-button {
            display: inline-block;
            margin-left: 6px;
            border-radius: 7px;
            padding: 8px 12px;
            background: #2449a4;
            color: white;
            font-size: 13px;
            text-decoration: none;
            transition: background-color 0.2s ease;
        }

        .download-button:hover {
            background: #1e3a8a;
            color: #ffffff;
        }

        .download-pdf {
            background: #dc2626;
        }

        .download-pdf:hover {
            background: #b91c1c;
        }

        table {
            width: max-content;
            min-width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #e2e8f0;
            padding: 8px;
            vertical-align: top;
            box-sizing: border-box;
        }

        th {
            background-color: #eff6ff;
            text-align: center;
        }

        .identity {
            width: 95px;
            background-color: #f8fafc;
            padding: 0;
            text-align: center;
            vertical-align: middle;
        }

        .row-labels {
            width: 55px;
            background-color: #f8fafc;
            padding: 0;
            text-align: center;
            vertical-align: middle;
        }

        .identity-row {
            display: block;
            min-height: 24px;
            padding: 4px 6px;
            box-sizing: border-box;
            border-top: 1px solid #e2e8f0;
            text-align: center;
        }

        .identity-row:first-child {
            border-top: 0;
        }

        .row-label {
            display: flex;
            min-height: 30px;
            align-items: center;
            justify-content: center;
            border-top: 1px solid #e2e8f0;
            font-size: 11px;
        }

        .row-label:first-child {
            border-top: 0;
        }

        .day {
            width: 260px;
            min-width: 260px;
            min-height: 110px;
        }

        .day-header {
            display: block;
            margin: -8px -8px 8px;
            padding: 4px;
            border-bottom: 1px solid #cbd5e1;
            box-sizing: border-box;
            width: calc(100% + 16px);
        }

        .jp-numbers,
        .schedule-list,
        .schedule-row {
            display: grid;
            grid-template-columns: repeat(10, minmax(24px, 1fr));
            gap: 0;
            width: 100%;
        }

        .jp-numbers {
            margin-top: 8px;
            padding-top: 4px;
            border-top: 1px solid #e2e8f0;
        }

        .jp-number {
            border-right: 1px solid #e2e8f0;
            color: #64748b;
            font-size: 10px;
            font-weight: normal;
            text-align: center;
        }

        .jp-number:last-child {
            border-right: 0;
        }

        .schedule-list {
            display: block;
        }

        .schedule-row {
            min-height: 24px;
            align-items: stretch;
        }

        .schedule-row+.schedule-row {
            border-top: 1px solid #e2e8f0;
        }

        .schedule-value {
            min-width: 0;
            overflow: hidden;
            padding: 4px 2px;
            border-right: 1px solid #e2e8f0;
            text-align: center;
            white-space: nowrap;
            text-overflow: ellipsis;
            font-size: 12px;
            box-sizing: border-box;
            min-height: 26px;
        }

        .schedule-value:last-child {
            border-right: 0;
        }

        .schedule-value.mapel {
            font-weight: bold;
            font-size: 12px;
        }

        .schedule-value.empty {
            color: transparent;
        }

        @media (max-width: 600px) {
            .schedule-table-wrap {
                padding: 15px;
            }

            .header {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
@endpush

@section('content')
    <div class="schedule-page">
        <div class="card shadow-sm border-0 p-4">
            <div class="header">
                <div>
                    <h1>Jadwal Pelajaran</h1>
                    <p>Daftar jadwal pelajaran yang berlaku.</p>
                </div>
            </div>

            <div class="toolbar">
                <div>
                    <a href="{{ route('siswa.jadwal.export_excel') }}" class="download-button">
                        <i class="bi bi-file-earmark-spreadsheet me-1"></i>Download Excel
                    </a>
                    <a href="{{ route('siswa.jadwal.export_pdf') }}" class="download-button download-pdf">
                        <i class="bi bi-file-earmark-pdf me-1"></i>Download PDF
                    </a>
                </div>
            </div>

            <div class="schedule-table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th class="identity">Kelas</th>
                            <th class="row-labels">Info</th>
                            @foreach ($hari as $namaHari)
                                <th class="day">
                                    <span class="day-header">
                                        {{ $namaHari }}
                                        <span class="jp-numbers"
                                            style="grid-template-columns: repeat({{ $jumlahJpPerHari[$namaHari] ?? 10 }}, minmax(22px, 1fr));">
                                            @for ($jp = 1; $jp <= ($jumlahJpPerHari[$namaHari] ?? 10); $jp++)
                                                <span class="jp-number">{{ $jp }}</span>
                                            @endfor
                                        </span>
                                    </span>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="identity">
                                <div class="identity-row">
                                    <strong>
                                        {{ $kelas->tingkat ?? '-' }}
                                        {{ optional($kelas->jurusan)->kode_jurusan ?? '' }}
                                        {{ $kelas->nama_kelas ?? '' }}
                                    </strong>
                                </div>
                            </td>

                            <td class="row-labels">
                                <div class="row-label">Mapel</div>
                                <div class="row-label">Guru</div>
                                <div class="row-label">Ruang</div>
                            </td>

                            @foreach ($hari as $namaHari)
                                <td class="day">

                                    @php
                                        $jadwalHari = $jadwal
                                            ->filter(
                                                fn($item) =>
                                                    strtolower($item->hari) === strtolower($namaHari)
                                            )
                                            ->values();
                                        $jumlahJpHari = $jumlahJpPerHari[$namaHari] ?? 10;


                                        $posisiJadwal = [];
                                        $jpPosisi = 1;

                                        foreach ($jadwalHari as $item) {
                                            $jumlahJp = min(max((int) ($item->jumlah_jp ?? 1), 1), $jumlahJpHari);

                                            $jumlahJpTampil = min(
                                                $jumlahJp,
                                                $jumlahJpHari + 1 - $jpPosisi
                                            );

                                            if ($jumlahJpTampil > 0) {
                                                $posisiJadwal[] = [
                                                    'item' => $item,
                                                    'mulai' => $jpPosisi,
                                                    'jumlah' => $jumlahJpTampil,
                                                ];

                                                $jpPosisi += $jumlahJpTampil;
                                            }

                                            if ($jpPosisi > $jumlahJpHari) {
                                                break;
                                            }
                                        }
                                    @endphp

                                    <div class="schedule-list">


                                        <div class="schedule-row"
                                            style="grid-template-columns: repeat({{ $jumlahJpHari }}, minmax(22px, 1fr));">
                                            @forelse ($posisiJadwal as $data)
                                                @php
                                                    $item = $data['item'];
                                                @endphp

                                                <div class="schedule-value mapel" style="
                                                                                            background-color: {{ optional($item->mapel)->warna ?? '#d3d3d3' }};
                                                                                            grid-column: {{ $data['mulai'] }} / span {{ $data['jumlah'] }};
                                                                                        "
                                                    title="{{ optional($item->mapel)->nama_mapel ?? '-' }}">
                                                    {{ optional($item->mapel)->kode_mapel ?? '-' }}
                                                </div>
                                            @empty
                                                <div class="schedule-value empty" style="grid-column: 1 / -1;">
                                                    -
                                                </div>
                                            @endforelse
                                        </div>


                                        <div class="schedule-row"
                                            style="grid-template-columns: repeat({{ $jumlahJpHari }}, minmax(22px, 1fr));">
                                            @forelse ($posisiJadwal as $data)
                                                @php
                                                    $item = $data['item'];
                                                @endphp

                                                <div class="schedule-value" style="
                                                                                            grid-column: {{ $data['mulai'] }} / span {{ $data['jumlah'] }};
                                                                                        "
                                                    title="{{ optional($item->guru)->nama ?? '-' }}">
                                                    {{ optional($item->guru)->kode_guru ?? '-' }}
                                                </div>
                                            @empty
                                                <div class="schedule-value empty" style="grid-column: 1 / -1;">
                                                    -
                                                </div>
                                            @endforelse
                                        </div>


                                        <div class="schedule-row"
                                            style="grid-template-columns: repeat({{ $jumlahJpHari }}, minmax(22px, 1fr));">
                                            @forelse ($posisiJadwal as $data)
                                                @php
                                                    $item = $data['item'];
                                                @endphp

                                                <div class="schedule-value" style="
                                                                                            grid-column: {{ $data['mulai'] }} / span {{ $data['jumlah'] }};
                                                                                        "
                                                    title="{{ optional($item->ruangan)->nama_ruang ?? '-' }}">
                                                    {{ optional($item->ruangan)->kode_ruang ?? '-' }}
                                                </div>
                                            @empty
                                                <div class="schedule-value empty" style="grid-column: 1 / -1;">
                                                    -
                                                </div>
                                            @endforelse
                                        </div>

                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection