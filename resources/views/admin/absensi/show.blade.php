
@extends('layouts.app')

@section('title', 'Detail Absensi')

@push('styles')
<style>
    .academic-container {
        padding: 24px 16px;
    }

    .page-header,
    .detail-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .05);
    }

    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 24px;
        padding: 20px 22px;
    }

    .page-header h3 {
        margin: 0 0 4px;
        color: #0f172a;
        font-size: 22px;
        font-weight: 700;
    }

    .page-header p {
        margin: 0;
        color: #64748b;
        font-size: 13px;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 8px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 7px;
        background: #fff;
        color: #475569;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: background-color .2s ease, border-color .2s ease;
    }

    .btn-back:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
        color: #1e293b;
    }

    .detail-card {
        height: 100%;
        overflow: hidden;
    }

    .detail-card-header {
        padding: 17px 22px;
        border-bottom: 1px solid #e2e8f0;
    }

    .detail-card-header h5 {
        margin: 0;
        color: #0f172a;
        font-size: 15px;
        font-weight: 700;
    }

    .detail-card-header p {
        margin: 4px 0 0;
        color: #94a3b8;
        font-size: 11px;
    }

    .detail-card-body {
        padding: 6px 22px 12px;
    }

    .detail-row {
        display: grid;
        grid-template-columns: 140px minmax(0, 1fr);
        align-items: center;
        gap: 12px;
        min-height: 54px;
        border-bottom: 1px solid #f1f5f9;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        color: #64748b;
        font-size: 12px;
        font-weight: 600;
    }

    .detail-value {
        min-width: 0;
        overflow-wrap: anywhere;
        color: #334155;
        font-size: 13px;
        font-weight: 500;
    }

    .student-name {
        color: #0f172a;
        font-weight: 700;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 72px;
        padding: 6px 11px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        text-transform: capitalize;
    }

    .status-hadir {
        background: #dcfce7;
        color: #166534;
    }

    .status-izin {
        background: #fef3c7;
        color: #92400e;
    }

    .status-sakit {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .status-alpha {
        background: #fee2e2;
        color: #b91c1c;
    }

    .status-terlambat {
        background: #e2e8f0;
        color: #475569;
    }

    .status-default {
        background: #f1f5f9;
        color: #64748b;
    }

    .description-box {
        padding: 15px 16px;
        background: #f8fafc;
        border: 1px solid #eef2f7;
        border-radius: 8px;
        color: #475569;
        font-size: 12px;
        line-height: 1.7;
        overflow-wrap: anywhere;
        white-space: pre-line;
    }

    .empty-value {
        color: #94a3b8;
    }

    @media (max-width: 768px) {
        .academic-container {
            padding: 24px 16px;
        }

        .page-header {
            margin-bottom: 24px;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            margin-bottom: 14px;
            padding: 8px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            background: #ffffff;
            color: #475569;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-back:hover {
            background: #f1f5f9;
            border-color: #94a3b8;
            color: #1e293b;
        }

        .page-header {
            margin-bottom: 18px;
            padding: 18px;
        }

        .page-header h3 {
            margin: 0 0 4px;
            color: #0f172a;
            font-size: 22px;
            font-weight: 700;
        }

        .page-header p {
            margin: 0;
            color: #64748b;
            font-size: 13px;
        }

        .detail-card {
            height: 100%;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        .detail-card-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 18px 22px;
            border-bottom: 1px solid #e2e8f0;
        }

        .detail-card-icon {
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: #eff6ff;
            color: #2563eb;
            font-size: 16px;
        }

        .detail-card-title {
            margin: 0;
            color: #0f172a;
            font-size: 15px;
            font-weight: 700;
        }

        .detail-card-body {
            padding: 4px 16px 10px;
        }

        .detail-row {
            grid-template-columns: 115px minmax(0, 1fr);
        }
    }

    @media (max-width: 576px) {
        .page-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .btn-back {
            align-self: flex-start;
        }

        .detail-row {
            display: block;
            padding: 11px 0;
        }

        .detail-label {
            margin-bottom: 5px;
        }

        .detail-value {
            font-size: 13px;
        }

        .detail-table td {
            padding: 15px 0 15px 10px;
            color: #334155;
            font-size: 13px;
            font-weight: 500;
            vertical-align: middle;
        }

        .student-name {
            color: #0f172a;
            font-weight: 700;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 78px;
            padding: 6px 11px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
        }

        .status-hadir {
            background: #dcfce7;
            color: #166534;
        }

        .status-izin {
            background: #fef3c7;
            color: #92400e;
        }

        .status-sakit {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .status-alpha {
            background: #fee2e2;
            color: #b91c1c;
        }

        .status-terlambat {
            background: #e2e8f0;
            color: #475569;
        }

        .status-default {
            background: #f1f5f9;
            color: #64748b;
        }

        .empty-value {
            color: #94a3b8;
        }

        @media (max-width: 768px) {
            .academic-container {
                padding: 18px 10px;
            }

            .page-header h3 {
                font-size: 20px;
            }

            .detail-card-header {
                padding: 16px;
            }

            .detail-card-body {
                padding: 6px 16px 16px;
            }

            .detail-table th {
                width: 40%;
            }
        }

        @media (max-width: 576px) {

            .detail-table th,
            .detail-table td {
                display: block;
                width: 100%;
                padding: 8px 0;
            }

            .detail-table th {
                padding-bottom: 2px;
                border-bottom: none;
            }

            .detail-table td {
                padding-top: 2px;
                padding-bottom: 12px;
            }
        }
    </style>

@endpush

@section('content')

@php
    $status = strtolower(trim((string) ($absensi->status ?? '')));

    $statusClass = match ($status) {
        'hadir' => 'status-hadir',
        'izin' => 'status-izin',
        'sakit' => 'status-sakit',
        'alpha' => 'status-alpha',
        'terlambat' => 'status-terlambat',
        default => 'status-default',
    };

    $tanggal = $absensi->tanggal ?? null;

    if ($tanggal && !($tanggal instanceof \Illuminate\Support\Carbon)) {
        try {
            $tanggal = \Illuminate\Support\Carbon::parse($tanggal);
        } catch (\Throwable $e) {
            $tanggal = null;
        }
    }
@endphp

<div class="academic-container">

    {{-- HEADER --}}
    <div class="page-header">
        <div>
            <h3>Detail Absensi</h3>
            <p>Informasi lengkap data kehadiran siswa.</p>
        </div>

        <a href="{{ route('admin.absensi.index') }}" class="btn-back">
            <i class="bi bi-arrow-left" aria-hidden="true"></i>
            Kembali
        </a>
    </div>

    {{-- DETAIL --}}
    <div class="row g-4">

        {{-- DATA SISWA --}}
        <div class="col-12 col-md-6">
            <div class="detail-card">

                <div class="detail-card-header">
                    <h5>Data Siswa</h5>
                    <p>Informasi identitas siswa</p>
                </div>

                <div class="detail-card-body">

                    <div class="detail-row">
                        <div class="detail-label">Nama</div>
                        <div class="detail-value student-name">
                            {{ $absensi->siswa->nama ?? '-' }}
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">NIS</div>
                        <div class="detail-value">
                            {{ $absensi->siswa->nis ?? '-' }}
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">NISN</div>
                        <div class="detail-value">
                            {{ $absensi->siswa->nisn ?? '-' }}
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- DATA KEHADIRAN --}}
        <div class="col-12 col-md-6">
            <div class="detail-card">

                <div class="detail-card-header">
                    <h5>Data Kehadiran</h5>
                    <p>Informasi waktu dan status absensi</p>
                </div>

                <div class="detail-card-body">

                    <div class="detail-row">
                        <div class="detail-label">Tanggal</div>
                        <div class="detail-value">
                            {{ $tanggal ? $tanggal->format('d-m-Y') : '-' }}
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Waktu</div>
                        <div class="detail-value">
                            {{ $absensi->jam_masuk ?: '-' }}
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Status</div>
                        <div class="detail-value">
                            <span class="status-badge {{ $statusClass }}">
                                {{ $absensi->status ?: '-' }}
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- KETERANGAN --}}
        <div class="col-12">
            <div class="detail-card">

                <div class="detail-card-header">
                    <h5>Keterangan</h5>
                    <p>Catatan tambahan terkait absensi</p>
                </div>

                <div class="detail-card-body">
                    <div class="description-box">
                        @if (filled($absensi->keterangan))
                            {{ $absensi->keterangan }}
                        @else
                            <span class="empty-value">
                                Tidak ada keterangan.
                            </span>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection
