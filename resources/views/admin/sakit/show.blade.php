@extends('layouts.app')

@section('title', 'Detail Pengajuan Sakit')

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
        gap: 7px;
        margin-bottom: 18px;
        padding: 8px 13px;
        border: 1px solid #e2e8f0;
        border-radius: 7px;
        background: #ffffff;
        color: #475569;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-back:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #2563eb;
    }

    .detail-card {
        overflow: hidden;
        margin-bottom: 24px;
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
        padding: 22px;
    }

    .detail-table {
        width: 100%;
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .detail-table th {
        width: 25%;
        padding: 13px 16px;
        background: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
        color: #475569;
        font-size: 12px;
        font-weight: 600;
        vertical-align: middle;
    }

    .detail-table td {
        padding: 13px 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        font-size: 13px;
        vertical-align: middle;
    }

    .detail-table tr:last-child th,
    .detail-table tr:last-child td {
        border-bottom: none;
    }

    .student-name {
        color: #0f172a;
        font-weight: 600;
    }

    .period-text {
        color: #475569;
        font-weight: 500;
    }

    .reason-text {
        line-height: 1.6;
        color: #475569;
    }

    .document-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 12px;
        border: 1px solid #bfdbfe;
        border-radius: 6px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .document-btn:hover {
        background: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
    }

    .not-available {
        color: #94a3b8;
        font-size: 12px;
    }

    .verification-card {
        height: 100%;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .verification-card-header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 18px 20px;
        border-bottom: 1px solid #e2e8f0;
    }

    .verification-icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 15px;
    }

    .verification-title {
        margin: 0;
        color: #0f172a;
        font-size: 14px;
        font-weight: 700;
    }

    .verification-body {
        padding: 20px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 78px;
        padding: 6px 11px;
        margin-bottom: 14px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-success {
        background: #dcfce7;
        color: #166534;
    }

    .status-warning {
        background: #fef3c7;
        color: #92400e;
    }

    .status-danger {
        background: #fee2e2;
        color: #b91c1c;
    }

    .status-info {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .status-default {
        background: #f1f5f9;
        color: #64748b;
    }

    .note-label {
        display: block;
        margin-bottom: 6px;
        color: #64748b;
        font-size: 11px;
        font-weight: 600;
    }

    .note-text {
        margin: 0;
        color: #475569;
        font-size: 12px;
        line-height: 1.7;
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .guru-table {
        width: 100%;
        min-width: 650px;
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .guru-table thead th {
        padding: 12px 14px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        color: #475569;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
        vertical-align: middle;
    }

    .guru-table tbody td {
        padding: 13px 14px;
        border-bottom: 1px solid #f1f5f9;
        color: #475569;
        font-size: 12px;
        vertical-align: middle;
    }

    .guru-table tbody tr:last-child td {
        border-bottom: none;
    }

    .guru-table tbody tr {
        transition: background-color 0.2s ease;
    }

    .guru-table tbody tr:hover {
        background-color: #f8fafc;
    }

    .guru-name {
        color: #0f172a;
        font-weight: 600;
    }

    .schedule-text {
        color: #475569;
        white-space: nowrap;
        font-weight: 500;
    }

    .catatan-text {
        color: #64748b;
        line-height: 1.5;
    }

    .empty-state {
        padding: 45px 20px !important;
        text-align: center;
    }

    .empty-state-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        border-radius: 50%;
        background: #f1f5f9;
        color: #94a3b8;
        font-size: 20px;
    }

    .empty-state-title {
        margin-bottom: 3px;
        color: #475569;
        font-size: 13px;
        font-weight: 600;
    }

    .empty-state-text {
        margin: 0;
        color: #94a3b8;
        font-size: 11px;
    }

    @media (max-width: 768px) {
        .academic-container {
            padding: 18px 10px;
        }

        .page-header h3 {
            font-size: 20px;
        }

        .detail-card-body,
        .verification-body {
            padding: 16px;
        }

        .detail-card-header,
        .verification-card-header {
            padding: 16px;
        }

        .detail-table th {
            width: 35%;
        }

        .detail-table th,
        .detail-table td {
            padding: 11px 12px;
        }
    }
</style>
@endpush

@section('content')

<div class="academic-container">

    <a
        href="{{ route('admin.sakit.index') }}"
        class="btn-back"
    >
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>

    <div class="page-header">
        <h3>Detail Pengajuan Sakit</h3>
        <p>Informasi lengkap pengajuan sakit siswa dan proses verifikasi.</p>
    </div>

    <div class="detail-card">

        <div class="detail-card-header">

            <div class="detail-card-icon">
                <i class="bi bi-person-vcard"></i>
            </div>

            <h5 class="detail-card-title">
                Data Siswa
            </h5>

        </div>

        <div class="detail-card-body">

            <div class="table-wrapper">

                <table class="detail-table">

                    <tr>
                        <th>Nama</th>
                        <td class="student-name">
                            {{ $sakit->siswa->nama ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <th>NIS</th>
                        <td>
                            {{ $sakit->siswa->nis ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <th>NISN</th>
                        <td>
                            {{ $sakit->siswa->nisn ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Periode</th>
                        <td class="period-text">
                            {{ $sakit->tanggal_mulai?->format('d-m-Y') ?? '-' }}
                            <span class="text-muted mx-1">-</span>
                            {{ $sakit->tanggal_selesai?->format('d-m-Y') ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Alasan</th>
                        <td class="reason-text">
                            {{ $sakit->alasan ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Dokumen</th>
                        <td>

                            @if($sakit->dokumen)

                                <a
                                    href="{{ asset('storage/'.$sakit->dokumen) }}"
                                    target="_blank"
                                    class="document-btn"
                                >
                                    <i class="bi bi-file-earmark-text"></i>
                                    Lihat Dokumen
                                </a>

                            @else

                                <span class="not-available">
                                    Tidak ada dokumen
                                </span>

                            @endif

                        </td>
                    </tr>

                </table>

            </div>

        </div>

    </div>

    <div class="row g-4">

        <div class="col-md-4">

            <div class="verification-card">

                <div class="verification-card-header">

                    <div class="verification-icon">
                        <i class="bi bi-person-check"></i>
                    </div>

                    <h5 class="verification-title">
                        Wali Kelas
                    </h5>

                </div>

                <div class="verification-body">

                    @php
                        $statusWali = $sakit->status_wali_kelas ?? 'pending';

                        $badgeWali = match($statusWali) {
                            'diterima' => 'status-success',
                            'ditolak' => 'status-danger',
                            default => 'status-warning'
                        };
                    @endphp

                    <span class="status-badge {{ $badgeWali }}">
                        {{ ucfirst($statusWali) }}
                    </span>

                    <span class="note-label">
                        Catatan
                    </span>

                    <p class="note-text">
                        {{ $sakit->catatan_wali_kelas ?? 'Tidak ada catatan.' }}
                    </p>

                </div>

            </div>

        </div>

        <div class="col-md-8">

            <div class="verification-card">

                <div class="verification-card-header">

                    <div class="verification-icon">
                        <i class="bi bi-person-workspace"></i>
                    </div>

                    <h5 class="verification-title">
                        Guru Mata Pelajaran
                    </h5>

                </div>

                <div class="table-wrapper">

                    <table class="guru-table">

                        <thead>

                            <tr>
                                <th>Guru</th>
                                <th>Jadwal</th>
                                <th>Status</th>
                                <th>Catatan</th>
                            </tr>

                        </thead>

                        <tbody>

                        @forelse(collect($sakit->guru) as $item)

                            @php
                                $statusGuru = $item->status ?? 'pending';

                                $badgeGuru = match($statusGuru) {
                                    'diterima' => 'status-success',
                                    'ditolak' => 'status-danger',
                                    default => 'status-warning'
                                };
                            @endphp

                            <tr>

                                <td class="guru-name">
                                    {{ $item->guru->nama ?? '-' }}
                                </td>

                                <td class="schedule-text">
                                    {{ $item->jadwal->jam_mulai ?? '-' }}
                                    <span class="text-muted">-</span>
                                    {{ $item->jadwal->jam_selesai ?? '-' }}
                                </td>

                                <td>
                                    <span class="status-badge {{ $badgeGuru }} mb-0">
                                        {{ ucfirst($statusGuru) }}
                                    </span>
                                </td>

                                <td class="catatan-text">
                                    {{ $item->catatan ?? '-' }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="4"
                                    class="empty-state"
                                >

                                    <div class="empty-state-icon">
                                        <i class="bi bi-inbox"></i>
                                    </div>

                                    <div class="empty-state-title">
                                        Belum ada guru mapel
                                    </div>

                                    <p class="empty-state-text">
                                        Belum terdapat data verifikasi guru mata pelajaran.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection