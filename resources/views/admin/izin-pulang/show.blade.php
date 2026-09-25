@extends('layouts.app')

@section('title', 'Detail Dispensasi Siswa')

@section('content')

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .detail-izin-page {
            padding: 24px 0;
        }

        .page-header {
            align-items: center;
            display: flex;
            gap: 16px;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .page-header-content {
            min-width: 0;
        }

        .page-title {
            margin: 0;
            font-size: 26px;
            font-weight: 700;
            color: #1e293b;
        }

        .page-subtitle {
            margin: 6px 0 0;
            color: #64748b;
            font-size: 14px;
        }

        .data-card {
            background: #ffffff;
            border: 1px solid #e8edf5;
            border-radius: 12px;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05);
            overflow: hidden;
            margin-bottom: 24px;
        }

        .data-card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 20px 24px;
            border-bottom: 1px solid #e8edf5;
        }

        .data-card-icon {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: #eff6ff;
            color: #2563eb;
            font-size: 18px;
        }

        .data-card-title {
            margin: 0;
            font-size: 17px;
            font-weight: 600;
            color: #1e293b;
        }

        .data-card-body {
            padding: 24px;
        }

        .detail-table {
            width: 100%;
            border-collapse: collapse;
        }

        .detail-table th {
            width: 25%;
            padding: 14px 18px;
            background: #f8fafc;
            border-bottom: 1px solid #e8edf5;
            color: #475569;
            font-size: 13px;
            font-weight: 600;
            text-align: left;
            vertical-align: middle;
        }

        .detail-table td {
            padding: 14px 18px;
            border-bottom: 1px solid #eef2f7;
            color: #334155;
            font-size: 14px;
            vertical-align: middle;
        }

        .detail-table tr:last-child th,
        .detail-table tr:last-child td {
            border-bottom: none;
        }

        .student-name {
            font-weight: 600;
            color: #1e293b;
        }

        .type-badge,
        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .type-sakit {
            background: #fef3c7;
            color: #92400e;
        }

        .type-pulang {
            background: #eff6ff;
            color: #2563eb;
        }

        .type-keluar {
            background: #f3e8ff;
            color: #6b21a8;
        }

        .type-izin {
            background: #ccfbf1;
            color: #0f766e;
        }

        .type-dispen {
            background: #dcfce7;
            color: #166534;
        }

        .status-success {
            background: #ecfdf5;
            color: #047857;
        }

        .status-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .status-danger {
            background: #fef2f2;
            color: #dc2626;
        }

        .document-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            min-height: 34px;
            padding: 6px 12px;
            border: 1px solid #dbeafe;
            border-radius: 7px;
            background: #eff6ff;
            color: #2563eb;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.2s ease;
        }

        .document-btn:hover {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .no-document {
            color: #94a3b8;
            font-size: 13px;
        }

        .note-label {
            margin-top: 16px;
            margin-bottom: 8px;
            color: #64748b;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.02em;
        }

        .note-box {
            padding: 14px 16px;
            border: 1px solid #e8edf5;
            border-radius: 8px;
            background: #f8fafc;
            color: #334155;
            font-size: 14px;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .detail-izin-page {
                padding: 16px 0;
            }

            .page-title {
                font-size: 22px;
            }

            .page-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .page-header .btn {
                width: 100%;
            }

            .data-card-header {
                padding: 18px;
            }

            .data-card-body {
                padding: 18px;
            }

            .detail-table {
                display: block;
                overflow-x: auto;
            }

            .detail-table th {
                width: 140px;
                min-width: 140px;
            }

            .detail-table td {
                min-width: 200px;
            }
        }
    </style>

    <div class="detail-izin-page">

        <div class="page-header">
            <div class="page-header-content">
                <h1 class="page-title">Detail Perizinan Siswa</h1>
                <p class="page-subtitle">Informasi lengkap pengajuan perizinan siswa.</p>
            </div>

            <a href="{{ route('admin.izin-pulang.index') }}" class="btn btn-secondary">
                Kembali
            </a>
        </div>

        @php
            $jenisValue = $izinPulang->jenis ?? '';

            $jenisText = match ($jenisValue) {
                'sakit' => 'Sakit',
                'izin' => 'Izin',
                'pulang' => 'Izin Pulang',
                'keluar' => 'Izin Keluar',
                'dispen' => 'Dispen',
                default => ucfirst($jenisValue ?: '-'),
            };

            $jenisClass = match ($jenisValue) {
                'sakit' => 'type-sakit',
                'izin' => 'type-izin',
                'pulang' => 'type-pulang',
                'keluar' => 'type-keluar',
                'dispen' => 'type-dispen',
                default => '',
            };

            $statusValue = $izinPulang->status ?? 'menunggu';

            $statusText = match ($statusValue) {
                'disetujui' => 'Disetujui',
                'ditolak' => 'Ditolak',
                default => 'Menunggu',
            };

            $statusClass = match ($statusValue) {
                'disetujui' => 'status-success',
                'ditolak' => 'status-danger',
                default => 'status-warning',
            };
        @endphp

        <div class="data-card">

            <div class="data-card-header">
                <div class="data-card-icon">
                    <i class="bi bi-calendar-check"></i>
                </div>

                <h2 class="data-card-title">
                    Data Perizinan
                </h2>
            </div>

            <div class="data-card-body">

                <table class="detail-table">

                    <tr>
                        <th>Nama Siswa</th>
                        <td>
                            <span class="student-name">
                                {{ $izinPulang->siswa->nama ?? '-' }}
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <th>NIS</th>
                        <td>
                            {{ $izinPulang->siswa->nis ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Jenis</th>
                        <td>
                            <span class="type-badge {{ $jenisClass }}">
                                {{ $jenisText }}
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <th>Tanggal</th>
                        <td>
                            {{ $izinPulang->tanggal?->format('d-m-Y') ?? '-' }}
                            @if ($izinPulang->tanggal_selesai ?? null)
                                @if ($izinPulang->tanggal_selesai->format('Y-m-d') !== $izinPulang->tanggal?->format('Y-m-d'))
                                    - {{ $izinPulang->tanggal_selesai->format('d-m-Y') }}
                                @endif
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>Jam</th>
                        <td>
                            @if (in_array($jenisValue, ['sakit', 'izin', 'dispen'], true))
                                <span class="text-muted">-</span>
                            @else
                                                {{ $izinPulang->jam_mulai
                                ? \Carbon\Carbon::parse($izinPulang->jam_mulai)->format('H:i')
                                : '-' }}
                                                <span class="text-muted mx-1">-</span>
                                                @if ($izinPulang->jam_selesai)
                                                    {{ \Carbon\Carbon::parse($izinPulang->jam_selesai)->format('H:i') }}
                                                @else
                                                    <span class="text-muted">pulang</span>
                                                @endif
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>Alasan</th>
                        <td>
                            {{ $izinPulang->alasan ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Dokumen</th>
                        <td>

                            @if ($izinPulang->dokumen)

                                <a href="{{ asset('storage/' . $izinPulang->dokumen) }}" target="_blank" class="document-btn">
                                    <i class="bi bi-file-earmark-text"></i>
                                    Lihat Surat
                                </a>

                            @else

                                <span class="no-document">
                                    Tidak ada dokumen
                                </span>

                            @endif

                        </td>
                    </tr>

                </table>

            </div>

        </div>

        <div class="data-card">

            <div class="data-card-header">

                <div class="data-card-icon">
                    <i class="bi bi-info-circle"></i>
                </div>

                <h2 class="data-card-title">
                    Status Perizinan
                </h2>

            </div>

            <div class="data-card-body">

                <span class="status-badge {{ $statusClass }}">
                    {{ $statusText }}
                </span>

                @if ($izinPulang->catatan_walikelas)

                    <div class="note-label">
                        Catatan Wali Kelas
                    </div>

                    <div class="note-box">
                        {{ $izinPulang->catatan_walikelas }}
                    </div>

                @endif

            </div>

        </div>

    </div>

@endsection