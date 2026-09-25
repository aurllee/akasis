@extends('layouts.app')

@section('title', 'Perizinan Siswa')

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
            min-width: 900px;
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

        .type-badge,
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

        .type-sakit {
            background: #fef3c7;
            color: #92400e;
        }

        .type-pulang {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .type-keluar {
            background: #ede9fe;
            color: #6d28d9;
        }

        .type-izin {
            background: #ccfbf1;
            color: #0f766e;
        }

        .type-dispen {
            background: #dcfce7;
            color: #166534;
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

        .btn-detail {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 7px 11px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            background: #ffffff;
            color: #475569;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-detail:hover {
            background: #f8fafc;
            color: #2563eb;
            border-color: #93c5fd;
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
        <h1 class="page-title">Perizinan Siswa</h1>
        <p class="page-subtitle">
            Monitoring pengajuan sakit, izin pulang, izin keluar, dan dispen siswa.
        </p>
    </div>

    <form method="GET" action="{{ route('admin.izin-pulang.index') }}" class="filter-card">
        <div class="filter-card-body">
            <div class="row g-3 align-items-end">

                <div class="col-md-6">
                    <label for="search" class="form-label-custom">
                        Cari Siswa
                    </label>

                    <input type="text" id="search" name="search" class="custom-input" placeholder="Nama / NIS / NISN..."
                        value="{{ request('search') }}" autocomplete="off">
                </div>

                <div class="col-md-3">
                    <label for="jenis" class="form-label-custom">
                        Jenis
                    </label>

                    <select id="jenis" name="jenis" class="custom-select">
                        <option value="">Semua Jenis</option>

                        <option value="sakit" @selected(request('jenis') === 'sakit')>
                            Sakit
                        </option>

                        <option value="izin" @selected(request('jenis') === 'izin')>
                            Izin
                        </option>

                        <option value="pulang" @selected(request('jenis') === 'pulang')>
                            Izin Pulang
                        </option>

                        <option value="keluar" @selected(request('jenis') === 'keluar')>
                            Izin Keluar
                        </option>

                        <option value="dispen" @selected(request('jenis') === 'dispen')>
                            Dispen
                        </option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="status" class="form-label-custom">
                        Status
                    </label>

                    <select id="status" name="status" class="custom-select">
                        <option value="">Semua Status</option>

                        <option value="menunggu" @selected(request('status') === 'menunggu')>
                            Menunggu
                        </option>

                        <option value="disetujui" @selected(request('status') === 'disetujui')>
                            Disetujui
                        </option>

                        <option value="ditolak" @selected(request('status') === 'ditolak')>
                            Ditolak
                        </option>
                    </select>
                </div>

            </div>

            <div class="mt-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i>
                    Filter
                </button>

                <a href="{{ route('admin.izin-pulang.index') }}" class="btn btn-light border">
                    Reset
                </a>
            </div>
        </div>
    </form>

    <div class="data-card">

        <div class="data-card-header">
            <div class="data-card-icon">
                <i class="bi bi-calendar-check"></i>
            </div>

            <h5 class="data-card-title">
                Data Perizinan Siswa
            </h5>
        </div>

        <div class="table-wrapper">

            <table class="custom-table">

                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Siswa</th>
                        <th>Jenis</th>
                        <th>Tanggal</th>
                        <th>Alasan</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($izinPulang as $item)

                        @php
                            $jenisValue = strtolower($item->jenis ?? '');

                            $jenisText = match ($jenisValue) {
                                'sakit' => 'Sakit',
                                'izin' => 'Izin',
                                'pulang' => 'Izin Pulang',
                                'keluar' => 'Izin Keluar',
                                'dispen' => 'Dispen',
                                default => ucfirst($item->jenis ?? '-'),
                            };

                            $jenisClass = match ($jenisValue) {
                                'sakit' => 'type-sakit',
                                'izin' => 'type-izin',
                                'pulang' => 'type-pulang',
                                'keluar' => 'type-keluar',
                                'dispen' => 'type-dispen',
                                default => '',
                            };

                            $statusValue = strtolower($item->status ?? 'menunggu');

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

                            <td class="number-cell">
                                {{ $izinPulang->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <div class="student-name">
                                    {{ $item->siswa->nama ?? '-' }}
                                </div>

                                <span class="student-nis">
                                    NIS: {{ $item->siswa->nis ?? '-' }}
                                </span>
                            </td>

                            <td>
                                <span class="type-badge {{ $jenisClass }}">
                                    {{ $jenisText }}
                                </span>
                            </td>

                            <td class="date-cell">
                                @if ($item->sumber === 'dispen')
                                    {{ $item->tanggal_mulai ? \Carbon\Carbon::parse($item->tanggal_mulai)->format('d-m-Y') : '-' }}
                                    @if ($item->tanggal_selesai && $item->tanggal_selesai != $item->tanggal_mulai)
                                        - {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d-m-Y') }}
                                    @endif
                                @else
                                    {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') : '-' }}
                                @endif
                            </td>

                            <td>
                                {{ $item->alasan ?? $item->kegiatan ?? '-' }}
                            </td>

                            <td>
                                <span class="status-badge {{ $statusClass }}">
                                    {{ $statusText }}
                                </span>
                            </td>

                            <td class="text-center">
                                <a href="{{ route('admin.izin-pulang.show', ['id' => $item->id, 'sumber' => $item->sumber]) }}"
                                    class="btn-detail">
                                    <i class="bi bi-eye"></i>
                                    Detail
                                </a>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="empty-state">

                                <div class="empty-state-icon">
                                    <i class="bi bi-inbox"></i>
                                </div>

                                <div>
                                    Belum ada data perizinan siswa.
                                </div>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if ($izinPulang->hasPages())
            <div class="p-3 border-top">
                {{ $izinPulang->links() }}
            </div>
        @endif

    </div>

@endsection