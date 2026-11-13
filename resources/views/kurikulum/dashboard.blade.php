@extends('layouts.app')

@section('title', 'Dashboard Kurikulum')

@push('styles')
    <style>
        .curriculum-dashboard {
            --curriculum-ink: #172b4d;
            --curriculum-muted: #64748b;
            --curriculum-line: #e2e8f0;
            --curriculum-blue: #2563eb;
            --curriculum-green: #15803d;
            --curriculum-amber: #b45309;
            --curriculum-cyan: #0e7490;
        }

        .curriculum-dashboard .dashboard-heading {
            align-items: flex-start;
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .curriculum-dashboard .eyebrow {
            color: var(--curriculum-blue);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.08em;
            margin-bottom: 7px;
            text-transform: uppercase;
        }

        .curriculum-dashboard h1,
        .curriculum-dashboard h2,
        .curriculum-dashboard p {
            margin-top: 0;
        }

        .curriculum-dashboard h1 {
            color: var(--curriculum-ink);
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .curriculum-dashboard .dashboard-heading p,
        .curriculum-dashboard .section-heading p {
            color: var(--curriculum-muted);
            font-size: 14px;
            margin-bottom: 0;
        }

        .curriculum-dashboard .academic-year {
            align-items: center;
            background: #eaf2ff;
            border: 1px solid #cfe0ff;
            border-radius: 6px;
            color: #1d4ed8;
            display: inline-flex;
            font-size: 13px;
            font-weight: 600;
            gap: 8px;
            padding: 10px 13px;
        }

        .curriculum-dashboard .stats-grid {
            display: grid;
            gap: 14px;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            margin-bottom: 32px;
        }

        .curriculum-dashboard .stat-card {
            --stat-color: var(--curriculum-blue);
            align-items: center;
            background: #fff;
            border: 1px solid var(--curriculum-line);
            border-left: 4px solid var(--stat-color);
            border-radius: 8px;
            box-shadow: 0 3px 12px rgba(15, 23, 42, 0.04);
            display: flex;
            gap: 15px;
            min-height: 112px;
            padding: 20px;
        }

        .curriculum-dashboard .stat-card.green { --stat-color: var(--curriculum-green); }
        .curriculum-dashboard .stat-card.amber { --stat-color: var(--curriculum-amber); }
        .curriculum-dashboard .stat-card.cyan { --stat-color: var(--curriculum-cyan); }

        .curriculum-dashboard .stat-icon {
            align-items: center;
            background: color-mix(in srgb, var(--stat-color) 11%, white);
            border-radius: 8px;
            color: var(--stat-color);
            display: flex;
            flex: 0 0 44px;
            font-size: 20px;
            height: 44px;
            justify-content: center;
            width: 44px;
        }

        .curriculum-dashboard .stat-label {
            color: var(--curriculum-muted);
            display: block;
            font-size: 13px;
            line-height: 1.4;
            margin-bottom: 5px;
        }

        .curriculum-dashboard .stat-value {
            color: var(--curriculum-ink);
            display: block;
            font-size: 27px;
            font-weight: 700;
            line-height: 1.1;
        }

        .curriculum-dashboard .section-heading {
            border-bottom: 1px solid var(--curriculum-line);
            margin-bottom: 16px;
            padding-bottom: 13px;
        }

        .curriculum-dashboard .section-heading h2 {
            color: var(--curriculum-ink);
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .curriculum-dashboard .quick-links {
            display: grid;
            gap: 10px;
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .curriculum-dashboard .quick-link {
            align-items: center;
            background: #fff;
            border: 1px solid var(--curriculum-line);
            border-radius: 7px;
            color: inherit;
            display: flex;
            gap: 12px;
            min-height: 70px;
            padding: 13px 15px;
            text-decoration: none;
            transition: border-color 150ms ease, background-color 150ms ease;
        }

        .curriculum-dashboard .quick-link:hover {
            background: #f8fbff;
            border-color: #93c5fd;
        }

        .curriculum-dashboard .quick-link-icon {
            align-items: center;
            background: #f1f5f9;
            border-radius: 6px;
            color: #334155;
            display: flex;
            flex: 0 0 38px;
            font-size: 17px;
            height: 38px;
            justify-content: center;
            width: 38px;
        }

        .curriculum-dashboard .quick-link-label {
            color: var(--curriculum-ink);
            font-size: 13px;
            font-weight: 600;
        }

        .curriculum-dashboard .quick-link-arrow {
            color: #94a3b8;
            margin-left: auto;
        }

        @media (max-width: 1050px) {
            .curriculum-dashboard .stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .curriculum-dashboard .quick-links { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 600px) {
            .curriculum-dashboard .stats-grid,
            .curriculum-dashboard .quick-links { grid-template-columns: 1fr; }
            .curriculum-dashboard h1 { font-size: 23px; }
        }
    </style>
@endpush

@section('content')
    <div class="curriculum-dashboard">
        <header class="dashboard-heading">
            <div>
                <div class="eyebrow">Panel Akademik</div>
                <h1>Dashboard Kurikulum</h1>
                <p>Pantau data akademik dan akses pengelolaan pembelajaran.</p>
            </div>
            <div class="academic-year">
                <i class="bi bi-calendar3" aria-hidden="true"></i>
                <span>Tahun Ajaran: {{ $tahunAjaranAktif }}</span>
            </div>
        </header>

        <section class="stats-grid" aria-label="Ringkasan akademik">
            <article class="stat-card">
                <span class="stat-icon"><i class="bi bi-person-badge" aria-hidden="true"></i></span>
                <div>
                    <span class="stat-label">Guru Aktif</span>
                    <strong class="stat-value">{{ number_format($jumlahGuru) }}</strong>
                </div>
            </article>
            <article class="stat-card green">
                <span class="stat-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
                <div>
                    <span class="stat-label">Total Siswa</span>
                    <strong class="stat-value">{{ number_format($jumlahSiswa) }}</strong>
                </div>
            </article>
            <article class="stat-card amber">
                <span class="stat-icon"><i class="bi bi-person-plus" aria-hidden="true"></i></span>
                <div>
                    <span class="stat-label">Siswa Baru Siap Dibagi Kelas</span>
                    <strong class="stat-value">{{ number_format($jumlahSiswaBaruBelumPunyaKelas) }}</strong>
                </div>
            </article>
            <article class="stat-card cyan">
                <span class="stat-icon"><i class="bi bi-grid-3x3-gap" aria-hidden="true"></i></span>
                <div>
                    <span class="stat-label">Total Kelas</span>
                    <strong class="stat-value">{{ number_format($jumlahKelas) }}</strong>
                </div>
            </article>
        </section>

        <section aria-labelledby="curriculum-quick-links">
            <div class="section-heading">
                <h2 id="curriculum-quick-links">Akses Cepat</h2>
                <p>Pilih pengelolaan akademik yang ingin dibuka.</p>
            </div>
            <div class="quick-links">
                <a class="quick-link" href="{{ route('guru.index') }}">
                    <span class="quick-link-icon"><i class="bi bi-person-badge" aria-hidden="true"></i></span>
                    <span class="quick-link-label">Data Guru</span>
                    <i class="bi bi-chevron-right quick-link-arrow" aria-hidden="true"></i>
                </a>
                <a class="quick-link" href="{{ route('siswa.index') }}">
                    <span class="quick-link-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
                    <span class="quick-link-label">Data Siswa</span>
                    <i class="bi bi-chevron-right quick-link-arrow" aria-hidden="true"></i>
                </a>
                <a class="quick-link" href="{{ route('pembagian_kelas.index') }}">
                    <span class="quick-link-icon"><i class="bi bi-person-lines-fill" aria-hidden="true"></i></span>
                    <span class="quick-link-label">Plotting Siswa</span>
                    <i class="bi bi-chevron-right quick-link-arrow" aria-hidden="true"></i>
                </a>
                <a class="quick-link" href="{{ route('kelas.index') }}">
                    <span class="quick-link-icon"><i class="bi bi-grid-3x3-gap" aria-hidden="true"></i></span>
                    <span class="quick-link-label">Kelas &amp; Wali Kelas</span>
                    <i class="bi bi-chevron-right quick-link-arrow" aria-hidden="true"></i>
                </a>
                <a class="quick-link" href="{{ route('mata_pelajaran.index') }}">
                    <span class="quick-link-icon"><i class="bi bi-book" aria-hidden="true"></i></span>
                    <span class="quick-link-label">Mata Pelajaran</span>
                    <i class="bi bi-chevron-right quick-link-arrow" aria-hidden="true"></i>
                </a>
                <a class="quick-link" href="{{ route('admin.jadwal_pelajaran.index') }}">
                    <span class="quick-link-icon"><i class="bi bi-calendar-week" aria-hidden="true"></i></span>
                    <span class="quick-link-label">Jadwal KBM</span>
                    <i class="bi bi-chevron-right quick-link-arrow" aria-hidden="true"></i>
                </a>
            </div>
        </section>
    </div>
@endsection