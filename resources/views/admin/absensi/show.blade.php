@extends('layouts.app')

@section('title', 'Detail Absensi')

@push('styles')

    <style>
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
            transition: all 0.2s ease;
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
            padding: 8px 22px 18px;
        }

        .detail-table {
            width: 100%;
            margin: 0;
            border-collapse: collapse;
        }

        .detail-table tr {
            border-bottom: 1px solid #f1f5f9;
        }

        .detail-table tr:last-child {
            border-bottom: none;
        }

        .detail-table th {
            width: 35%;
            padding: 15px 10px 15px 0;
            color: #64748b;
            font-size: 13px;
            font-weight: 600;
            vertical-align: middle;
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

        @php
            $statusClass = match ($absensi->status) {
                'Hadir' => 'status-hadir',
                'Izin' => 'status-izin',
                'Sakit' => 'status-sakit',
                'Alpha' => 'status-alpha',
                'Terlambat' => 'status-terlambat',
                default => 'status-default'
            };
        @endphp

        <div class="row g-4">

            <div class="col-md-6">

                <div class="detail-card">

                    <div class="detail-card-header">

                        <div class="detail-card-icon">
                            <i class="bi bi-person"></i>
                        </div>

                        <h5 class="detail-card-title">
                            Data Siswa
                        </h5>

                    </div>

                    <div class="detail-card-body">

                        <table class="detail-table">

                            <tr>
                                <th>Nama</th>
                                <td class="student-name">
                                    {{ $absensi->siswa->nama ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <th>NIS</th>
                                <td>
                                    {{ $absensi->siswa->nis ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <th>NISN</th>
                                <td>
                                    {{ $absensi->siswa->nisn ?? '-' }}
                                </td>
                            </tr>

                        </table>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="detail-card">

                    <div class="detail-card-header">

                        <div class="detail-card-icon">
                            <i class="bi bi-calendar-check"></i>
                        </div>

                        <h5 class="detail-card-title">
                            Data Kehadiran
                        </h5>

                    </div>

                    <div class="detail-card-body">

                        <table class="detail-table">

                            <tr>
                                <th>Tanggal</th>
                                <td>
                                    {{ $absensi->tanggal?->format('d-m-Y') ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <th>Waktu</th>
                                <td>
                                    {{ $absensi->jam_masuk ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="status-badge {{ $statusClass }}">
                                        {{ $absensi->status ?? '-' }}
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <th>Keterangan</th>
                                <td>
                                    @if($absensi->keterangan)
                                        {{ $absensi->keterangan }}
                                    @else
                                        <span class="empty-value">-</span>
                                    @endif
                                </td>
                            </tr>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection