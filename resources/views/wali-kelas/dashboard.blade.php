@extends('layouts.app')

@section('title', 'Dashboard Wali kelas')

@push('styles')

    <style>
        body {
            margin: 0;
            background: #f4f7fb;
            color: #1f2937;
            font-family: 'Poppins', sans-serif;
        }

        .page-wrap {
            width: 100%;
            max-width: 1440px;
            margin: 0 auto;
        }

        .page-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            box-shadow: 0 8px 24px rgba(30, 64, 102, 0.06);
            padding: 24px;
        }

        .welcome-card {
            background: linear-gradient(135deg, #2449a4 0%, #3c73fe 100%);
            border: 0;
            color: #ffffff;
            overflow: hidden;
            position: relative;
        }

        .info-grid {
            display: grid;
            gap: 14px;
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .info-item {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 14px 16px;
        }

        .info-label {
            color: #64748b;
            display: block;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .info-value {
            color: #1e293b;
            font-size: 14px;
            font-weight: 600;
        }

        .schedule-card h2 {
            color: #1e293b;
            font-size: 19px;
            font-weight: 600;
        }

        .schedule-table {
            margin-bottom: 0;
            min-width: 680px;
        }

        .schedule-table thead th {
            background: #eff6ff;
            border-bottom: 2px solid #bfdbfe;
            color: #1e40af;
            font-size: 12px;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .schedule-table tbody td {
            color: #334155;
            font-size: 14px;
            padding-bottom: 14px;
            padding-top: 14px;
        }

        .schedule-table tbody tr:hover {
            background: #f8fafc;
        }

        .empty-schedule {
            color: #64748b;
            padding: 28px !important;
            text-align: center;
        }

        .page-title {
            margin: 0 0 8px;
            font-size: 25px;
            font-weight: 500;
            color: #ffffff;
        }

        .page-subtitle {
            margin: 0 0 22px;
            color: rgba(255, 255, 255, 0.82);
        }

        @media (max-width: 768px) {
            .page-card {
                padding: 18px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    <div class="page-wrap">
        <div class="page-card welcome-card mb-3">
            <h1 class="page-title">Dashboard Wali Kelas</h1>
            <p class="page-subtitle">Selamat datang, {{ $guru->nama ?? 'Guru' }}</p>
        </div>
        <div class="page-card mb-3">
            <div class="info-grid" style="grid-template-columns: repeat(4, minmax(0, 1fr));">
                <div class="info-item">
                    <span class="info-label">NIP</span>
                    <span class="info-value">{{ $guru->nip ?? 'NIP tidak tersedia' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Jenis Kelamin</span>
                    <span class="info-value">{{ $guru->jk ?? 'Jenis kelamin tidak tersedia' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Mata Pelajaran</span>
                    <span class="info-value">{{ $guru->mataPelajaran?->nama_mapel ?? 'Mapel tidak tersedia' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Wali Kelas</span>
                    <span class="info-value">
                        @if($waliKelas->isNotEmpty())
                            @foreach($waliKelas as $wk)
                                {{ $wk->kelas?->tingkat }}
                                {{ $wk->kelas?->jurusan?->kode_jurusan ?? '' }}{{ !$loop->last ? ', ' : '' }}
                                {{ $wk->kelas?->nama_kelas }}
                            @endforeach
                        @else
                            <span style="color: #94a3b8; font-weight: 400;">Bukan Wali Kelas</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <div class="page-card schedule-card">
            <h2 class="mb-3">Jadwal Mengajar</h2>
            <div style="overflow-x: auto;">
                <table class="table table-bordered align-middle schedule-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Hari</th>
                            <th>Kelas</th>
                            <th>Mata Pelajaran</th>
                            <th>Ruangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jadwal as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->hari ?? '-' }}</td>
                                <td>
                                    {{ $item->kelas?->tingkat ?? '' }}
                                    {{ $item->kelas?->jurusan?->kode_jurusan ?? '' }}
                                    {{ $item->kelas?->nama_kelas ?? '-' }}
                                </td>
                                <td>{{ $item->mapel?->nama_mapel ?? '-' }}</td>
                                <td>{{ $item->ruangan?->nama_ruang ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-schedule">Belum ada jadwal mengajar yang dipublikasikan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection