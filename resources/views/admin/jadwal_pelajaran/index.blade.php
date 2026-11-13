@extends('layouts.app')

@section('title', 'Jadwal Pelajaran')

@push('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #212529;
            background: #f5f6fa;
        }

        .academic-page {
            color: #1f2937;
        }

        .academic-panel {
            background: #fff;
            border: 1px solid #e4eaf2;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(30, 64, 102, 0.05);
            padding: 24px;
        }

        .academic-header {
            align-items: center;
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .academic-header-title h1 {
            color: #1e293b;
            font-size: 24px;
            font-weight: 600;
            margin: 0 0 4px;
        }

        .academic-header-title p {
            color: #64748b;
            font-size: 14px;
            margin: 0;
        }

        .academic-header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .academic-btn {
            border: 1px solid transparent;
            border-radius: 7px;
            cursor: pointer;
            font-size: 13.5px;
            font-weight: 600;
            padding: 9px 15px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }

        .academic-btn-primary {
            background: #2449a4;
            color: #fff;
        }

        .academic-btn-primary:hover {
            background: #1d3f8c;
            color: #fff;
        }

        .academic-btn-outline {
            background: #fff;
            border-color: #cbd5e1;
            color: #334155;
        }

        .academic-btn-outline:hover {
            background: #f8fafc;
            border-color: #94a3b8;
        }

        .academic-btn-excel {
            background: #217346;
            color: #fff;
        }

        .academic-btn-excel:hover {
            background: #1e623c;
            color: #fff;
        }

        .academic-btn-pdf {
            background: #b42318;
            color: #fff;
        }

        .academic-btn-pdf:hover {
            background: #981b12;
            color: #fff;
        }


        .academic-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 16px;
            background: #f8fafc;
            padding: 14px 16px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .academic-filter-group {
            display: flex;
            align-items: flex-end;
            gap: 10px;
            flex-wrap: wrap;
        }

        .academic-filter-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .academic-filter-item label {
            color: #5c6970;
            font-size: 12px;
            font-weight: 600;
        }

        .academic-filter-item select {
            background: #fff;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            color: #1e293b;
            font-size: 13px;
            padding: 8px 12px;
            min-width: 180px;
        }

        .academic-filter-item select:focus {
            border-color: #2449a4;
            outline: none;
        }


        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 1100px;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #e2e8f0;
            padding: 8px;
            vertical-align: top;
        }

        th {
            background-color: #f1f5fb;
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

        .identity strong {
            display: block;
            font-size: 14px;
        }

        .identity span {
            color: #64748b;
            font-size: 12px;
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

        .identity-row strong,
        .identity-row span {
            display: block;
        }

        .day {
            width: var(--day-width, 280px);
            min-width: var(--day-width, 280px);
            min-height: 110px;
        }

        .day-header {
            display: block;
            margin: -8px -8px 8px;
            padding: 4px;
            border-bottom: 1px solid #e2e8f0;
        }

        .jp-numbers,
        .schedule-row {
            display: grid;
            grid-template-columns: repeat(var(--jp-count, 10), minmax(26px, 1fr));
            gap: 0;
            width: 100%;
        }

        .schedule-list {
            display: block;
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
            align-items: start;
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
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .schedule-value:last-child {
            border-right: 0;
        }

        .schedule-value.mapel {
            font-weight: bold;
            font-size: 12px;
        }

        .day-footer {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 6px;
            margin-top: 5px;
        }

        .day-actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: 3px;
        }

        .day-action {
            border: 0;
            border-radius: 2px;
            padding: 2px 4px;
            color: white;
            font-size: 9px;
            text-decoration: none;
        }

        .day-action.edit {
            background-color: #2563eb;
        }

        .schedule-value.empty {
            color: transparent;
        }

        .day-count {
            display: block;
            color: #64748b;
            font-size: 11px;
            font-weight: normal;
            margin-top: 3px;
        }

        @media (max-width: 768px) {
            .academic-panel {
                padding: 16px;
            }

            .academic-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .academic-toolbar {
                flex-direction: column;
                align-items: stretch;
            }

            .academic-filter-group {
                flex-direction: column;
                align-items: stretch;
            }

            .academic-filter-item select {
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')

    <div class="academic-page">
        <div class="academic-panel">
            <div class="academic-header">
                <div class="academic-header-title">
                    <h1>Jadwal Pelajaran</h1>
                    <p>Daftar jadwal pelajaran yang telah ditambahkan.</p>
                </div>

                <div class="academic-header-actions">
                    <a href="{{ route('admin.jadwal_pelajaran.create') }}" class="academic-btn academic-btn-primary">
                        Tambah Jadwal
                    </a>

                    <form action="{{ route('admin.jadwal_pelajaran.publish') }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="academic-btn academic-btn-outline">
                            Publikasikan Semua
                        </button>
                    </form>
                </div>
            </div>


            <div class="academic-toolbar">
                <form action="{{ route('admin.jadwal_pelajaran.index') }}" method="GET" class="academic-filter-group">
                    <div class="academic-filter-item">
                        <label for="jurusan_id">Tampilkan jurusan</label>
                        <select name="jurusan_id" id="jurusan_id">
                            <option value="">Semua Jurusan</option>
                            @foreach ($jurusanList as $jurusan)
                                <option value="{{ $jurusan->id }}" {{ (string) $selectedJurusan === (string) $jurusan->id ? 'selected' : '' }}>
                                    {{ $jurusan->kode_jurusan }} - {{ $jurusan->nama_jurusan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="academic-btn academic-btn-primary">Tampilkan</button>
                </form>

                <div class="academic-filter-group">
                    <a href="{{ route('admin.jadwal_pelajaran.export_excel', ['jurusan_id' => $selectedJurusan]) }}"
                        class="academic-btn academic-btn-excel">
                        Download Excel
                    </a>
                    <a href="{{ route('admin.jadwal_pelajaran.export_pdf', ['jurusan_id' => $selectedJurusan]) }}"
                        class="academic-btn academic-btn-pdf">
                        Download PDF
                    </a>
                </div>
            </div>


            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th class="identity">Kelas</th>
                            <th class="row-labels">Info</th>
                            @foreach ($hari as $namaHari)
                                <th class="day"
                                    style="--jp-count: {{ $jumlahJpPerHari[$namaHari] ?? 10 }}; --day-width: {{ max(280, ($jumlahJpPerHari[$namaHari] ?? 10) * 32) }}px;">
                                    <span class="day-header">
                                        {{ $namaHari }}
                                        <span class="jp-numbers"
                                            style="--jp-count: {{ $jumlahJpPerHari[$namaHari] ?? 10 }}; --day-width: {{ max(280, ($jumlahJpPerHari[$namaHari] ?? 10) * 32) }}px;">
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
                        @forelse ($jadwalPerKelas as $jadwalKelas)
                            @php
                                $kelas = $jadwalKelas->first()->kelas;
                                $labelKelas = trim(($kelas->tingkat ?? '-') . ' ' .
                                    (optional($kelas->jurusan)->kode_jurusan ?? optional($kelas->jurusan)->nama_jurusan ?? '-') . ' ' .
                                    ($kelas->nama_kelas ?? $jadwalKelas->first()->kelas_id));
                            @endphp
                            <tr>
                                <td class="identity">
                                    <div class="identity-row">
                                        <strong>{{ $labelKelas }}</strong>
                                    </div>
                                </td>
                                <td class="row-labels">
                                    <div class="row-label">Mapel</div>
                                    <div class="row-label">Guru</div>
                                    <div class="row-label">Ruang</div>
                                </td>
                                @foreach ($hari as $namaHari)
                                    <td class="day"
                                        style="--jp-count: {{ $jumlahJpPerHari[$namaHari] ?? 10 }}; --day-width: {{ max(280, ($jumlahJpPerHari[$namaHari] ?? 10) * 32) }}px;">
                                        @php
                                            $jadwalHari = $jadwalKelas
                                                ->filter(fn($item) => strtolower($item->hari) === strtolower($namaHari))
                                                ->values();
                                            $jumlahJpHari = $jumlahJpPerHari[$namaHari] ?? 10;
                                            $jpPosisi = 1;
                                        @endphp
                                        <div class="schedule-list">
                                            @foreach (['mapel', 'guru', 'ruang'] as $jenisBaris)
                                                <div class="schedule-row"
                                                    style="--jp-count: {{ $jumlahJpHari }}; --day-width: {{ max(280, $jumlahJpHari * 32) }}px;">
                                                    @forelse ($jadwalHari as $item)
                                                        @php
                                                            $jumlahJp = min(max((int) ($item->jumlah_jp ?? 1), 1), $jumlahJpHari);
                                                            $jumlahJpTampil = min($jumlahJp, $jumlahJpHari + 1 - $jpPosisi);
                                                            $nilaiBaris = match ($jenisBaris) {
                                                                'mapel' => optional($item->mapel)->kode_mapel ?? ($item->mata_pelajaran_id ?? '-'),
                                                                'guru' => optional($item->guru)->kode_guru ?? ($item->guru_id ?? '-'),
                                                                default => optional($item->ruangan)->kode_ruang ?? ($item->ruangan_id ?? '-'),
                                                            };
                                                        @endphp
                                                        <div class="schedule-value {{ $jenisBaris === 'mapel' ? 'mapel' : '' }}"
                                                            style="background-color: {{ $jenisBaris === 'mapel' ? optional($item->mapel)->warna ?? '#d3d3d3' : '#ffffff' }}; grid-column: {{ $jpPosisi }} / span {{ $jumlahJpTampil }};"
                                                            title="{{ optional($item->guru)->kode_guru ?? ($item->guru_id ?? '-') }} | {{ optional($item->ruangan)->kode_ruang ?? ($item->ruangan_id ?? '-') }}">
                                                            {{ $nilaiBaris }}
                                                        </div>
                                                        @php $jpPosisi += $jumlahJpTampil; @endphp
                                                    @empty
                                                        <div class="schedule-value empty" style="grid-column: 1 / -1;">-</div>
                                                    @endforelse
                                                </div>
                                                @php $jpPosisi = 1; @endphp
                                            @endforeach
                                        </div>
                                        @if ($jadwalHari->isNotEmpty())
                                            <div class="day-footer">
                                                <span class="day-count">{{ $jadwalHari->count() }} mapel</span>
                                                <div class="day-actions">
                                                    <a href="{{ route('admin.jadwal_pelajaran.edit_hari', [$jadwalKelas->first()->kelas_id, $namaHari]) }}"
                                                        class="day-action edit">Edit Semua</a>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">Belum ada data jadwal pelajaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection