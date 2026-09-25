@extends('layouts.app')

@section('title', 'Master Kelas')

@section('content')

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .kelas-page {
            padding: 24px 0;
        }

        .page-header {
            margin-bottom: 24px;
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

        .btn-add {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 40px;
            padding: 9px 18px;
            border-radius: 8px;
            background: #2563eb;
            color: #ffffff;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.2s ease;
        }

        .btn-add:hover {
            background: #1d4ed8;
            color: #ffffff;
        }

        .page-header-content {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 20px;
        }

        .data-card {
            background: #ffffff;
            border: 1px solid #e8edf5;
            border-radius: 12px;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05);
            overflow: hidden;
        }

        .data-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 20px 24px;
            border-bottom: 1px solid #e8edf5;
        }

        .filter-form {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-label {
            color: #64748b;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
        }

        .filter-select {
            min-width: 210px;
            min-height: 38px;
            padding: 7px 10px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            background: #ffffff;
            color: #334155;
            font-size: 13px;
        }

        .filter-button,
        .reset-button {
            min-height: 38px;
            padding: 7px 12px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
        }

        .filter-button {
            border: 1px solid #2563eb;
            background: #2563eb;
            color: #ffffff;
        }

        .reset-button {
            border: 1px solid #cbd5e1;
            background: #ffffff;
            color: #475569;
        }

        .data-card-title {
            margin: 0;
            font-size: 17px;
            font-weight: 600;
            color: #1e293b;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .kelas-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 680px;
        }

        .kelas-table th {
            padding: 13px 18px;
            background: #f8fafc;
            border-bottom: 1px solid #e8edf5;
            color: #475569;

            .data-card-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .filter-form {
                align-items: stretch;
                flex-wrap: wrap;
                width: 100%;
            }

            .filter-select {
                flex: 1;
            }

            font-size: 13px;
            font-weight: 600;
            text-align: left;
            white-space: nowrap;
        }

        .kelas-table td {
            padding: 14px 18px;
            border-bottom: 1px solid #eef2f7;
            color: #334155;
            font-size: 14px;
            vertical-align: middle;
        }

        .kelas-table tbody tr:last-child td {
            border-bottom: none;
        }

        .kelas-table tbody tr {
            transition: 0.2s ease;
        }

        .kelas-table tbody tr:hover {
            background: #f8fafc;
        }

        .number-cell {
            width: 60px;
            color: #64748b;
            text-align: center;
        }

        .kode-cell {
            font-weight: 600;
            color: #2563eb;
            white-space: nowrap;
        }

        .nama-cell {
            font-weight: 600;
            color: #1e293b;
        }

        .action-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 34px;
            padding: 7px 12px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            border: 1px solid transparent;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .btn-edit {
            background: #eff6ff;
            color: #2563eb;
            border-color: #dbeafe;
        }

        .btn-edit:hover {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .btn-delete {
            background: #fef2f2;
            color: #dc2626;
            border-color: #fee2e2;
        }

        .btn-delete:hover {
            background: #fee2e2;
            color: #b91c1c;
        }

        .delete-form {
            margin: 0;
        }

        .empty-state {
            padding: 40px 20px !important;
            text-align: center;
            color: #94a3b8 !important;
        }

        .room-pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            padding: 0 24px 24px;
        }

        .room-pagination nav {
            display: flex;
        }

        .room-pagination ul.pagination {
            align-items: center;
            display: flex;
            gap: 6px;
            margin: 0;
        }

        .room-pagination .page-item {
            margin: 0;
        }

        .room-pagination .page-link {
            align-items: center;
            background: #fff;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            color: #475569;
            display: flex;
            font-size: 13px;
            height: 34px;
            justify-content: center;
            min-width: 34px;
            padding: 0 10px;
        }

        .room-pagination .page-link:hover {
            background: #eff6ff;
            border-color: #93c5fd;
            color: #1d4ed8;
        }

        .room-pagination .page-item.active .page-link {
            background: #2449a4;
            border-color: #2449a4;
            color: #fff;
        }

        .room-pagination .page-item.disabled .page-link {
            background: #f8fafc;
            border-color: #e2e8f0;
            color: #94a3b8;
        }

        @media (max-width: 768px) {
            .kelas-page {
                padding: 16px 0;
            }

            .page-header-content {
                align-items: flex-start;
                flex-direction: column;
            }

            .page-title {
                font-size: 22px;
            }

            .btn-add {
                width: 100%;
            }

            .data-card-header {
                padding: 18px;
            }

            .kelas-table th,
            .kelas-table td {
                padding: 12px 14px;
            }
        }
    </style>

    <div class="kelas-page">

        <div class="page-header">
            <div class="page-header-content">
                <div>
                    <h1 class="page-title">Master Kelas</h1>
                    <p class="page-subtitle">
                        Kelola data kelas sekolah.
                    </p>
                </div>

                <a href="{{ route('kelas.create') }}" class="btn-add">
                    Tambah Kelas
                </a>
            </div>
        </div>

        <div class="data-card">

            <div class="data-card-header">
                <h2 class="data-card-title">Data Kelas</h2>

                <form method="GET" action="{{ route('kelas.index') }}" class="filter-form">
                    <label for="jurusan_id" class="filter-label">Filter Jurusan</label>
                    <select name="jurusan_id" id="jurusan_id" class="filter-select">
                        <option value="">Semua Jurusan</option>
                        @foreach($jurusans as $jurusan)
                            <option value="{{ $jurusan->id }}" @selected((string) request('jurusan_id') === (string) $jurusan->id)>
                                {{ $jurusan->kode_jurusan }} - {{ $jurusan->nama_jurusan }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="filter-button">Terapkan</button>
                    @if(request()->filled('jurusan_id'))
                        <a href="{{ route('kelas.index') }}" class="reset-button">Reset</a>
                    @endif
                </form>
            </div>

            <div class="table-wrapper">
                <table class="kelas-table">
                    <thead>
                        <tr>
                            <th class="number-cell">No</th>
                            <th>Tingkat</th>
                            <th>Jurusan</th>
                            <th>Nama Kelas</th>
                            <th>Wali Kelas</th>
                            <th>Tahun Ajaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($kelases as $kelas)
                            <tr>
                                <td class="number-cell">
                                    {{ $kelases->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    {{ $kelas->tingkat }}
                                </td>

                                <td>
                                    <span class="kode-cell">{{ optional($kelas->jurusan)->kode_jurusan ?? '-' }}</span> -
                                    {{ optional($kelas->jurusan)->nama_jurusan ?? '-' }}
                                </td>

                                <td class="nama-cell">
                                    {{ $kelas->nama_kelas }}
                                </td>

                                <td>
                                    {{ optional($kelas->waliKelas)->nama ?? '-' }}
                                </td>

                                <td>
                                    {{ optional($kelas->tahunAjaran)->tahun_ajaran ?? '-' }}
                                </td>

                                <td>
                                    <div class="action-wrapper">
                                        <a href="{{ route('kelas.edit', $kelas->id) }}" class="btn-action btn-edit">
                                            Edit
                                        </a>

                                        <form action="{{ route('kelas.destroy', $kelas->id) }}" method="POST"
                                            class="delete-form">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn-action btn-delete"
                                                onclick="return confirm('Hapus data kelas?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="empty-state">
                                    Belum ada data kelas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="room-pagination">
                {{ $kelases->links('pagination::bootstrap-5') }}
            </div>

        </div>

    </div>

@endsection