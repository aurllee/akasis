@extends('layouts.app')

@section('title', 'Izin Tidak Masuk Siswa')

@push('styles')
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Poppins', sans-serif;
        }

        .page-header {
            margin-bottom: 24px;
        }

        .page-title {
            margin: 0 0 8px;
            color: #0f172a;
            font-size: 24px;
            font-weight: 700;
        }

        .page-subtitle {
            margin: 0;
            color: #64748b;
            font-size: 14px;
        }

        .filter-card {
            margin-bottom: 24px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        .filter-card-body {
            padding: 22px;
        }

        .form-label-custom {
            display: block;
            margin-bottom: 7px;
            color: #334155;
            font-size: 13px;
            font-weight: 600;
        }

        .custom-input,
        .custom-select {
            width: 100%;
            min-height: 42px;
            padding: 9px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            background-color: #ffffff;
            color: #1e293b;
            font-size: 13px;
            outline: none;
            transition: all 0.2s ease;
        }

        .custom-input::placeholder {
            color: #94a3b8;
        }

        .custom-input:focus,
        .custom-select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .data-card {
            overflow: hidden;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        .data-card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 18px 22px;
            border-bottom: 1px solid #e2e8f0;
        }

        .data-card-icon {
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

        .data-card-title {
            margin: 0;
            color: #0f172a;
            font-size: 15px;
            font-weight: 700;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .custom-table {
            width: 100%;
            min-width: 1000px;
            border-collapse: separate;
            border-spacing: 0;
            margin: 0;
            background: #ffffff;
        }

        .custom-table thead th {
            padding: 13px 16px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            color: #475569;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .custom-table tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid #f1f5f9;
            color: #475569;
            font-size: 13px;
            vertical-align: middle;
        }

        .custom-table tbody tr:last-child td {
            border-bottom: none;
        }

        .custom-table tbody tr:hover {
            background-color: #f8fafc;
        }

        .number-cell {
            width: 60px;
            color: #64748b;
            font-weight: 600;
            text-align: center;
        }

        .student-name {
            color: #0f172a;
            font-weight: 600;
        }

        .student-nis {
            display: block;
            margin-top: 4px;
            color: #94a3b8;
            font-size: 11px;
        }

        .date-cell {
            white-space: nowrap;
            font-weight: 500;
            color: #475569;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 90px;
            padding: 6px 11px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-approved {
            background: #dcfce7;
            color: #166534;
        }

        .status-rejected {
            background: #fee2e2;
            color: #b91c1c;
        }

        .action-group {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 8px;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 0;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .action-btn.btn-success {
            background: #16a34a;
            color: #ffffff;
        }

        .action-btn.btn-success:hover {
            background: #15803d;
        }

        .action-btn.btn-danger {
            background: #dc2626;
            color: #ffffff;
        }

        .action-btn.btn-danger:hover {
            background: #b91c1c;
        }

        .btn-doc {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #93c5fd;
            border-radius: 8px;
            background: #eff6ff;
            color: #1d4ed8;
            padding: 7px 10px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
        }

        .empty-state {
            text-align: center;
            color: #64748b;
            padding: 32px 16px !important;
            font-style: italic;
        }

        .empty-state-icon {
            display: inline-flex;
            width: 38px;
            height: 38px;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
            border-radius: 50%;
            background: #f1f5f9;
            color: #64748b;
            font-size: 18px;
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <h1 class="page-title">Izin Tidak Masuk Siswa</h1>
        <p class="page-subtitle">Daftar pengajuan izin tidak masuk siswa yang perlu verifikasi wali kelas.</p>
    </div>

    <form method="GET" action="{{ route('wali-kelas.sakit.index') }}" class="filter-card">
        <div class="filter-card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-8">
                    <label for="search" class="form-label-custom">Cari Siswa</label>
                    <input
                        type="text"
                        id="search"
                        name="search"
                        class="custom-input"
                        placeholder="Nama / NIS / NISN..."
                        value="{{ request('search') }}"
                        autocomplete="off"
                    >
                </div>

                <div class="col-md-4">
                    <label for="status" class="form-label-custom">Status</label>
                    <select id="status" name="status" class="custom-select">
                        <option value="">Semua</option>
                        <option value="menunggu" @selected(request('status') === 'menunggu')>Menunggu</option>
                        <option value="disetujui" @selected(request('status') === 'disetujui')>Disetujui</option>
                        <option value="ditolak" @selected(request('status') === 'ditolak')>Ditolak</option>
                    </select>
                </div>
            </div>
        </div>
    </form>

    <div class="data-card">
        <div class="data-card-header">
            <div class="data-card-icon">
                <i class="bi bi-calendar-x"></i>
            </div>
            <h5 class="data-card-title">Data Pengajuan Izin Tidak Masuk</h5>
        </div>

        <div class="table-wrapper">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Siswa</th>
                        <th>Tanggal</th>
                        <th>Alasan</th>
                        <th>Dokumen</th>
                        <th>Status</th>
                        <th class="text-center">Verifikasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data ?? [] as $item)
                        @php
                            $statusValue = $item->status_walikelas ?? 'menunggu';
                            $statusText = match ($statusValue) {
                                'disetujui' => 'Disetujui',
                                'ditolak' => 'Ditolak',
                                default => 'Menunggu',
                            };
                            $statusClass = match ($statusValue) {
                                'disetujui' => 'status-approved',
                                'ditolak' => 'status-rejected',
                                default => 'status-pending',
                            };
                        @endphp

                        <tr>
                            <td class="number-cell">{{ $loop->iteration }}</td>
                            <td>
                                <div class="student-name">{{ $item->siswa->nama ?? '-' }}</div>
                                <span class="student-nis">NIS: {{ $item->siswa->nis ?? '-' }}</span>
                            </td>
                            <td class="date-cell">
                                {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') : '-' }}
                            </td>
                            <td>{{ $item->alasan ?? '-' }}</td>
                            <td>
                                @if ($item->dokumen)
                                    <a href="{{ asset('storage/' . $item->dokumen) }}" target="_blank" class="btn-doc">
                                        <i class="bi bi-file-earmark-text me-1"></i>Lihat
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                            </td>
                            <td class="text-center">
                                @if (($item->status_walikelas ?? 'menunggu') === 'menunggu')
                                    <div class="action-group">
                                        <form action="{{ route('wali-kelas.sakit.setujui', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="action-btn btn-success">Setujui</button>
                                        </form>

                                        <form action="{{ route('wali-kelas.sakit.tolak', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="catatan" value="Tidak ada catatan">
                                            <button type="submit" class="action-btn btn-danger">Tolak</button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="bi bi-inbox"></i>
                                </div>
                                <div>Belum ada pengajuan izin tidak masuk siswa.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection