@extends('layouts.app')

@section('title', 'Absensi')

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
            color: #0f172a;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .page-header p {
            color: #64748b;
            font-size: 13px;
            margin: 0;
        }

        .filter-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            margin-bottom: 24px;
        }

        .filter-card .card-body {
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
            padding: 18px 22px;
            border-bottom: 1px solid #e2e8f0;
        }

        .data-card-title {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #0f172a;
            font-size: 15px;
            font-weight: 700;
        }

        .data-card-title i {
            color: #2563eb;
            font-size: 17px;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .custom-table {
            width: 100%;
            min-width: 1000px;
            margin: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .custom-table thead th {
            padding: 13px 16px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            color: #475569;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
            vertical-align: middle;
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

        .custom-table tbody tr {
            transition: background-color 0.2s ease;
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

        .date-cell {
            color: #475569;
            white-space: nowrap;
        }

        .subject-name {
            color: #334155;
            font-weight: 500;
        }

        .teacher-name {
            color: #64748b;
        }

        .time-cell {
            color: #475569;
            white-space: nowrap;
            font-weight: 500;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 78px;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
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

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 7px 12px;
            border: 1px solid #bfdbfe;
            border-radius: 6px;
            background: #eff6ff;
            color: #2563eb;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .action-btn:hover {
            background: #2563eb;
            border-color: #2563eb;
            color: #ffffff;
        }

        .empty-state {
            padding: 55px 20px !important;
            text-align: center;
        }

        .empty-state-icon {
            width: 52px;
            height: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            border-radius: 50%;
            background: #f1f5f9;
            color: #94a3b8;
            font-size: 22px;
        }

        .empty-state-title {
            margin-bottom: 4px;
            color: #475569;
            font-size: 14px;
            font-weight: 600;
        }

        .empty-state-text {
            margin: 0;
            color: #94a3b8;
            font-size: 12px;
        }

        .pagination-wrapper {
            padding: 18px 22px;
            border-top: 1px solid #f1f5f9;
        }

        .pagination-wrapper .pagination {
            margin: 0;
        }

        .pagination-wrapper .page-link {
            border-color: #e2e8f0;
            color: #475569;
            font-size: 12px;
            border-radius: 6px;
            margin: 0 2px;
        }

        .pagination-wrapper .page-item.active .page-link {
            background-color: #2563eb;
            border-color: #2563eb;
            color: #ffffff;
        }

        .pagination-wrapper .page-link:hover {
            background-color: #eff6ff;
            border-color: #bfdbfe;
            color: #2563eb;
        }

        @media (max-width: 768px) {
            .academic-container {
                padding: 18px 10px;
            }

            .page-header h3 {
                font-size: 20px;
            }

            .filter-card .card-body {
                padding: 16px;
            }

            .data-card-header {
                padding: 16px;
            }

            .pagination-wrapper {
                padding: 15px;
            }
        }
    </style>

@endpush

@section('content')

    <div class="academic-container">

        <div class="page-header">
            <h3>Absensi</h3>
            <p>Rekap kehadiran siswa.</p>
        </div>

        <div class="filter-card">
            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-6">
                        <label for="searchAbsensi" class="form-label-custom">
                            Cari Siswa
                        </label>

                        <input type="text" id="searchAbsensi" class="custom-input" placeholder="Nama / NIS / NISN...">
                    </div>

                    <div class="col-md-4">
                        <label for="statusAbsensi" class="form-label-custom">
                            Status
                        </label>

                        <select id="statusAbsensi" class="custom-select">
                            <option value="">Semua Status</option>
                            <option value="Hadir">Hadir</option>
                            <option value="Izin">Izin</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Alpha">Alpha</option>
                            <option value="Terlambat">Terlambat</option>
                        </select>
                    </div>

                </div>

            </div>
        </div>

        <div id="absensiContent">

            <div class="data-card">

                <div class="data-card-header">
                    <div class="data-card-title">
                        <i class="bi bi-calendar-check"></i>
                        Data Absensi
                    </div>
                </div>

                <div class="table-wrapper">

                    <table class="custom-table">

                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Siswa</th>
                                <th>Tanggal</th>
                                <th>Mata Pelajaran</th>
                                <th>Guru</th>
                                <th>Waktu Absen</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($absensi as $item)

                                @php
                                    $statusClass = match (strtolower((string) $item->status)) {
                                        'hadir' => 'status-hadir',
                                        'izin' => 'status-izin',
                                        'sakit' => 'status-sakit',
                                        'alpha' => 'status-alpha',
                                        'terlambat' => 'status-terlambat',
                                        default => 'status-default'
                                    };
                                @endphp

                                <tr>

                                    <td class="number-cell">
                                        {{ $absensi->firstItem() + $loop->index }}
                                    </td>

                                    <td>
                                        <div class="student-name">
                                            {{ $item->siswa->nama ?? '-' }}
                                        </div>
                                    </td>

                                    <td class="date-cell">
                                        {{ $item->tanggal ?? '-' }}
                                    </td>

                                    <td>
                                        <div class="subject-name">
                                            {{ $item->sesi->jadwal->mataPelajaran->nama_mapel ?? '-' }}
                                        </div>
                                    </td>

                                    <td>
                                        <div class="teacher-name">
                                            {{ $item->sesi->jadwal->guru->nama ?? '-' }}
                                        </div>
                                    </td>

                                    <td class="time-cell">
                                        {{ $item->jam_masuk ?? '-' }}
                                    </td>

                                    <td>
                                        <span class="status-badge {{ $statusClass }}">
                                            {{ $item->status ?? '-' }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('admin.absensi.show', $item->id) }}" class="action-btn">
                                            <i class="bi bi-eye"></i>
                                            Detail
                                        </a>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="8" class="empty-state">
                                        <div class="empty-state-icon">
                                            <i class="bi bi-calendar-x"></i>
                                        </div>

                                        <div class="empty-state-title">
                                            Tidak ada data absensi
                                        </div>

                                        <p class="empty-state-text">
                                            Data absensi belum tersedia atau tidak sesuai dengan filter.
                                        </p>
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="pagination-wrapper" id="absensiPagination">
                    {{ $absensi->links() }}
                </div>

            </div>

        </div>

    </div>

@endsection

@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const searchInput = document.getElementById('searchAbsensi');
            const statusInput = document.getElementById('statusAbsensi');

            let timer = null;

            function loadAbsensi(url = null) {

                const search = searchInput.value.trim();
                const status = statusInput.value;

                let requestUrl = url;

                if (!requestUrl) {

                    const params = new URLSearchParams();

                    if (search !== '') {
                        params.append('search', search);
                    }

                    if (status !== '') {
                        params.append('status', status);
                    }

                    requestUrl =
                        "{{ route('admin.absensi.index') }}" +
                        '?' +
                        params.toString();
                }

                fetch(requestUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => {

                        if (!response.ok) {
                            throw new Error('Gagal memuat data.');
                        }

                        return response.text();
                    })
                    .then(html => {

                        const parser = new DOMParser();

                        const doc = parser.parseFromString(
                            html,
                            'text/html'
                        );

                        const newContent =
                            doc.querySelector('#absensiContent');

                        const currentContent =
                            document.querySelector('#absensiContent');

                        if (newContent && currentContent) {
                            currentContent.innerHTML =
                                newContent.innerHTML;
                        }

                        if (requestUrl) {
                            window.history.replaceState(
                                {},
                                '',
                                requestUrl
                            );
                        }

                    })
                    .catch(error => {
                        console.error(
                            'Gagal mengambil data absensi:',
                            error
                        );
                    });
            }

            searchInput.addEventListener('input', function () {

                clearTimeout(timer);

                timer = setTimeout(function () {
                    loadAbsensi();
                }, 300);

            });

            statusInput.addEventListener('change', function () {
                loadAbsensi();
            });

            document.addEventListener('click', function (event) {

                const link = event.target.closest(
                    '#absensiContent .pagination a'
                );

                if (!link) {
                    return;
                }

                event.preventDefault();

                loadAbsensi(link.href);

            });

        });
    </script>

@endpush