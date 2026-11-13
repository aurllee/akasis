@extends('layouts.app')

@section('title', 'Nilai Siswa')

@push('styles')
    <style>
        .nilai-page {
            --primary: #2449A4;      
            --primary-tint: #eaf0ff;
            --hero-soft: #dbe5ff;
            --ink: #1f2937;
            --muted: #6b7280;
            --line: #e5e7eb;
            --surface: #ffffff;
            --surface-alt: #f8fafc;

            font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', sans-serif;
            color: var(--ink);
            line-height: 1.5;
        }

        .nilai-page *,
        .nilai-page *::before,
        .nilai-page *::after {
            box-sizing: border-box;
        }

        .nilai-page .hero {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            justify-content: space-between;
            gap: 28px 40px;
            margin-bottom: 36px;
            padding: 32px 36px;
            background: var(--primary);
            color: #fff;
            border-radius: 22px;
        }

        .nilai-page .hero h1 {
            margin: 0;
            font-size: 30px;
            font-weight: 600;
            line-height: 1.2;
            letter-spacing: -0.02em;
        }

        .nilai-page .hero p {
            max-width: 46ch;
            margin: 8px 0 0;
            font-size: 15px;
            color: var(--hero-soft);
        }

        .nilai-page .hero-stats {
            display: flex;
        }

        .nilai-page .stat {
            padding: 0 28px;
            border-left: 1px solid rgba(255, 255, 255, 0.22);
        }

        .nilai-page .stat:first-child {
            padding-left: 0;
            border-left: 0;
        }

        .nilai-page .stat:last-child {
            padding-right: 0;
        }

        .nilai-page .stat .label {
            display: block;
            margin-bottom: 4px;
            font-size: 13px;
            color: var(--hero-soft);
        }

        .nilai-page .stat .value {
            display: block;
            font-size: 34px;
            font-weight: 600;
            line-height: 1.1;
            letter-spacing: -0.02em;
            font-variant-numeric: tabular-nums;
        }

        .nilai-page .stat--lead .value {
            font-size: 46px;
        }

        .nilai-page .section-head {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 12px 16px;
            margin-bottom: 16px;
        }

        .nilai-page .section-title {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
            letter-spacing: -0.01em;
        }

        .nilai-page .toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .nilai-page .search-box {
            position: relative;
            display: flex;
            align-items: center;
            margin: 0;
        }

        .nilai-page .search-box svg {
            position: absolute;
            left: 12px;
            width: 16px;
            height: 16px;
            color: var(--muted);
            pointer-events: none;
        }

        .nilai-page .search-box input,
        .nilai-page .mapel-filter {
            height: 40px;
            padding: 0 14px;
            font: inherit;
            font-size: 14px;
            color: var(--ink);
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 10px;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .nilai-page .search-box input {
            width: 260px;
            padding-left: 36px;
        }

        .nilai-page .mapel-filter {
            min-width: 210px;
            max-width: 100%;
        }

        .nilai-page .search-box input:focus,
        .nilai-page .mapel-filter:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(36, 73, 164, 0.15);
        }

        .nilai-page .result-info {
            margin: 0 0 12px;
            font-size: 13px;
            color: var(--muted);
        }

        .nilai-page .table-wrap {
            overflow-x: auto;
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 18px;
        }

        .nilai-page table {
            width: 100%;
            min-width: 760px;
            margin: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .nilai-page th,
        .nilai-page td {
            padding: 14px 18px;
            font-size: 14px;
            text-align: left;
            vertical-align: middle;
            border-bottom: 1px solid var(--line);
        }

        .nilai-page thead th {
            background: var(--surface-alt);
            color: #475569;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
        }

        .nilai-page .mapel-cell {
            width: 200px;
            background: var(--surface-alt);
            border-right: 1px solid var(--line);
            vertical-align: top;
        }

        .nilai-page .mapel-name {
            display: block;
            font-size: 15px;
            font-weight: 600;
            line-height: 1.35;
        }

        .nilai-page .mapel-avg {
            display: block;
            margin-top: 4px;
            font-size: 13px;
            color: var(--muted);
        }

        .nilai-page .mapel-avg strong {
            margin-left: 4px;
            font-weight: 600;
            color: var(--primary);
            font-variant-numeric: tabular-nums;
        }

        .nilai-page tbody tr {
            transition: background-color 0.15s ease;
        }

        .nilai-page tbody tr:hover td:not(.mapel-cell) {
            background: #f8faff;
        }

        .nilai-page tr.is-last td,
        .nilai-page tbody.is-last .mapel-cell {
            border-bottom: 0;
        }

        .nilai-page .col-nilai {
            width: 110px;
            text-align: right;
        }

        .nilai-page td.col-nilai {
            font-weight: 600;
            font-variant-numeric: tabular-nums;
        }

        .nilai-page .chip {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 999px;
            background: var(--surface-alt);
            border: 1px solid var(--line);
            color: var(--ink);
            font-size: 12px;
            font-weight: 500;
            white-space: nowrap;
        }

        .nilai-page .empty-state {
            padding: 32px 24px;
            border: 1px dashed #cbd5e1;
            border-radius: 18px;
            background: var(--surface);
            color: #475569;
            font-size: 14px;
            text-align: center;
        }

        @media (max-width: 640px) {
            .nilai-page .hero {
                gap: 22px;
                margin-bottom: 28px;
                padding: 24px 20px;
                border-radius: 18px;
            }

            .nilai-page .hero h1 {
                font-size: 26px;
            }

            .nilai-page .hero-stats {
                flex-wrap: wrap;
                gap: 18px 32px;
                width: 100%;
            }

            .nilai-page .stat,
            .nilai-page .stat:first-child,
            .nilai-page .stat:last-child {
                padding: 0;
                border-left: 0;
            }

            .nilai-page .stat--lead {
                flex-basis: 100%;
            }

            .nilai-page .stat .value {
                font-size: 28px;
            }

            .nilai-page .stat--lead .value {
                font-size: 40px;
            }

            .nilai-page .toolbar,
            .nilai-page .search-box,
            .nilai-page .search-box input,
            .nilai-page .mapel-filter {
                width: 100%;
            }

            .nilai-page th,
            .nilai-page td {
                padding: 12px 14px;
            }

            .nilai-page thead th:first-child,
            .nilai-page .mapel-cell {
                position: sticky;
                left: 0;
                z-index: 1;
                width: 150px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="nilai-page">
        <header class="hero">
            <div>
                <h1>Nilai Saya</h1>
                <p>Rekap semua nilai yang tersedia untuk {{ $siswa->nama ?? 'Siswa' }}.</p>
            </div>

            <div class="hero-stats">
                <div class="stat stat--lead">
                    <span class="label">Nilai Rata-rata Mapel</span>
                    <span class="value">{{ $rataRataMapel }}</span>
                </div>

                <div class="stat">
                    <span class="label">Jumlah Penilaian Mapel</span>
                    <span class="value">{{ $penilaianMapel->flatten()->count() }}</span>
                </div>
            </div>
        </header>

        <section class="section">
            <div class="section-head">
                <h2 class="section-title">Nilai Mata Pelajaran</h2>

                @unless($penilaianMapel->isEmpty())
                    <div class="toolbar">
                        <label class="search-box">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="11" cy="11" r="7"></circle>
                                <path d="m20 20-3.5-3.5"></path>
                            </svg>
                            <input type="search" id="nilai-search" placeholder="Cari mapel, guru, jenis, nilai..." autocomplete="off" aria-label="Cari nilai">
                        </label>

                        <select id="nilai-mapel" class="mapel-filter" aria-label="Filter mata pelajaran">
                            <option value="">Semua Mata Pelajaran</option>
                            @foreach($mataPelajaran as $mapel)
                                <option value="{{ $mapel->nama_mapel }}">{{ $mapel->nama_mapel }}</option>
                            @endforeach
                        </select>
                    </div>
                @endunless
            </div>

            @if($penilaianMapel->isEmpty())
                <div class="empty-state">Belum ada data nilai mata pelajaran untuk siswa ini.</div>
            @else
                <p class="result-info" id="nilai-info" aria-live="polite"></p>

                <div class="empty-state" id="nilai-empty" hidden>
                    Tidak ada nilai yang cocok dengan pencarian atau filter.
                </div>

                <div class="table-wrap" id="nilai-table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Mata Pelajaran</th>
                                <th>Jenis Nilai</th>
                                <th>Guru</th>
                                <th>Tahun Ajaran</th>
                                <th>Tanggal</th>
                                <th class="col-nilai">Nilai</th>
                            </tr>
                        </thead>

                        @foreach($penilaianMapel as $mapel => $items)
                            @php
                                $rata = $items->isNotEmpty() ? $items->avg('nilai') : null;
                            @endphp

                            <tbody data-mapel="{{ $mapel }}">
                                @forelse($items as $nilai)
                                    <tr>
                                        @if($loop->first)
                                            <td class="mapel-cell" rowspan="{{ $items->count() }}">
                                                <span class="mapel-name">{{ $mapel }}</span>
                                                <span class="mapel-avg">
                                                    Rata-rata
                                                    <strong>{{ $rata !== null ? round($rata, 1) : '-' }}</strong>
                                                </span>
                                            </td>
                                        @endif

                                        <td><span class="chip">{{ ucfirst($nilai->jenis_nilai ?? '-') }}</span></td>
                                        <td>{{ $nilai->jadwal?->guru?->nama ?? '-' }}</td>
                                        <td>
                                            {{ $nilai->jadwal?->kelas?->tahunAjaran?->tahun_ajaran ?? '-' }}
                                            @if($nilai->jadwal?->kelas?->tahunAjaran?->semester)
                                                ({{ $nilai->jadwal->kelas->tahunAjaran->semester }})
                                            @endif
                                        </td>
                                        <td>{{ $nilai->created_at ? $nilai->created_at->format('d-m-Y') : '-' }}</td>
                                        <td class="col-nilai">{{ $nilai->nilai ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="mapel-cell">
                                            <span class="mapel-name">{{ $mapel }}</span>
                                            <span class="mapel-avg">Belum ada nilai</span>
                                        </td>
                                        <td colspan="5">Belum ada penilaian yang tersimpan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        @endforeach
                    </table>
                </div>
            @endif
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var input = document.getElementById('nilai-search');
            var select = document.getElementById('nilai-mapel');
            var info = document.getElementById('nilai-info');
            var empty = document.getElementById('nilai-empty');
            var wrap = document.getElementById('nilai-table-wrap');
            var bodies = document.querySelectorAll('.nilai-page tbody[data-mapel]');

            if (!input || !select || !wrap || !bodies.length) return;

            function norm(text) {
                return (text || '').toString().toLowerCase().replace(/\s+/g, ' ').trim();
            }

            var groups = Array.prototype.map.call(bodies, function (tb) {
                var mapel = tb.getAttribute('data-mapel');
                var rows = Array.prototype.map.call(tb.rows, function (row) {
                    var text = Array.prototype.filter.call(row.cells, function (c) {
                        return !c.classList.contains('mapel-cell');
                    }).map(function (c) { return c.textContent; }).join(' ');

                    return { el: row, text: norm(mapel + ' ' + text) };
                });

                return { tb: tb, cell: tb.querySelector('.mapel-cell'), mapel: mapel, rows: rows };
            });

            var total = groups.reduce(function (sum, g) { return sum + g.rows.length; }, 0);

            function apply() {
                var terms = norm(input.value).split(' ').filter(Boolean);
                var chosen = select.value;
                var shown = 0;
                var lastRow = null;
                var lastBody = null;

                document.querySelectorAll('.nilai-page .is-last').forEach(function (el) {
                    el.classList.remove('is-last');
                });

                groups.forEach(function (g) {
                    var groupOk = !chosen || g.mapel === chosen;
                    var visible = [];

                    g.rows.forEach(function (r) {
                        var ok = groupOk && terms.every(function (t) { return r.text.indexOf(t) !== -1; });
                        r.el.hidden = !ok;
                        if (ok) visible.push(r.el);
                    });

                    g.tb.hidden = visible.length === 0;

                    if (visible.length) {
                        g.cell.rowSpan = visible.length;
                        if (g.cell.parentNode !== visible[0]) {
                            visible[0].insertBefore(g.cell, visible[0].firstChild);
                        }
                        shown += visible.length;
                        lastRow = visible[visible.length - 1];
                        lastBody = g.tb;
                    }
                });

                if (lastRow) lastRow.classList.add('is-last');
                if (lastBody) lastBody.classList.add('is-last');

                wrap.hidden = shown === 0;
                empty.hidden = shown !== 0;
                info.textContent = 'Menampilkan ' + shown + ' dari ' + total + ' nilai';
            }

            input.addEventListener('input', apply);
            select.addEventListener('change', apply);
            apply();
        });
    </script>
@endsection