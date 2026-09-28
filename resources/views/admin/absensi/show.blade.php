@extends('layouts.app')

@section('title', 'Detail Absensi')

@push('styles') <style>
body {
background-color: #f8fafc;
font-family: 'Poppins', sans-serif;
}

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
        transition: all .2s ease;
    }

    .btn-back:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
        color: #1e293b;
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
        box-shadow: 0 1px 3px rgba(0, 0, 0, .06);
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
        grid-template-columns: 150px 1fr;
        align-items: center;
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
        color: #334155;
        font-size: 13px;
        font-weight: 500;
    }

    .student-name {
        color: #0f172a;
        font-weight: 700;
    }

    .attendance-summary {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-bottom: 18px;
    }

    .summary-item {
        padding: 15px 16px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
    }

    .summary-label {
        margin-bottom: 7px;
        color: #94a3b8;
        font-size: 11px;
        font-weight: 600;
    }

    .summary-value {
        color: #0f172a;
        font-size: 13px;
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
        background: #fee2e2;
        color: #b91c1c;
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
            padding: 4px 16px 10px;
        }

        .detail-row {
            grid-template-columns: 120px 1fr;
        }

        .attendance-summary {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .detail-row {
            display: block;
            padding: 11px 0;
        }

        .detail-label {
            margin-bottom: 4px;
        }

        .detail-value {
            font-size: 13px;
        }
    }
</style>

@endpush

@section('content')

@php
    $statusClass = match (strtolower(trim((string) $absensi->status))) {
        'hadir' => 'status-hadir',
        'izin' => 'status-izin',
        'sakit' => 'status-sakit',
        'alpha' => 'status-alpha',
        'terlambat' => 'status-terlambat',
        default => 'status-default'
    };
@endphp

<div class="academic-container">

    <div class="page-header">

        <a href="{{ route('admin.absensi.index') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i>
            Kembali
        </a>

        <h3>Detail Absensi</h3>

        <p>
            Informasi lengkap data kehadiran siswa.
        </p>

    </div>

    <div class="row g-4">

        <div class="col-md-6">

            <div class="detail-card">

                <div class="detail-card-header">

                    <h5>Data Siswa</h5>

                    <p>
                        Informasi identitas siswa
                    </p>

                </div>

                <div class="detail-card-body">

                    <div class="detail-row">

                        <div class="detail-label">
                            Nama
                        </div>

                        <div class="detail-value student-name">
                            {{ $absensi->siswa->nama ?? '-' }}
                        </div>

                    </div>

                    <div class="detail-row">

                        <div class="detail-label">
                            NIS
                        </div>

                        <div class="detail-value">
                            {{ $absensi->siswa->nis ?? '-' }}
                        </div>

                    </div>

                    <div class="detail-row">

                        <div class="detail-label">
                            NISN
                        </div>

                        <div class="detail-value">
                            {{ $absensi->siswa->nisn ?? '-' }}
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-6">

            <div class="detail-card">

                <div class="detail-card-header">

                    <h5>Data Kehadiran</h5>

                    <p>
                        Informasi waktu dan status absensi
                    </p>

                </div>

                <div class="detail-card-body">

                    <div class="detail-row">

                        <div class="detail-label">
                            Tanggal
                        </div>

                        <div class="detail-value">
                            {{ $absensi->tanggal?->format('d-m-Y') ?? '-' }}
                        </div>

                    </div>

                    <div class="detail-row">

                        <div class="detail-label">
                            Waktu
                        </div>

                        <div class="detail-value">
                            {{ $absensi->jam_masuk ?? '-' }}
                        </div>

                    </div>

                    <div class="detail-row">

                        <div class="detail-label">
                            Status
                        </div>

                        <div class="detail-value">

                            <span class="status-badge {{ $statusClass }}">
                                {{ $absensi->status ?? '-' }}
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-12">

            <div class="detail-card">

                <div class="detail-card-header">

                    <h5>Keterangan</h5>

                    <p>
                        Catatan tambahan terkait absensi
                    </p>

                </div>

                <div class="detail-card-body">

                    <div class="description-box">

                        @if($absensi->keterangan)
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
