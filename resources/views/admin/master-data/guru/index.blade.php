@extends('layouts.app')

@section('title', 'Master Guru')

@section('content')

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .guru-page {
            color: #1e293b;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 24px;
        }

        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .page-subtitle {
            margin: 0;
            color: #64748b;
            font-size: 14px;
        }

        .btn-add {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 9px 17px;
            border-radius: 8px;
            background: #2563eb;
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border: 1px solid #2563eb;
            transition: all 0.2s ease;
        }

        .btn-add:hover {
            background: #1d4ed8;
            border-color: #1d4ed8;
            color: #fff;
        }


        .account-info {
            background: #eff6ff;
            border: 1px solid #dbeafe;
            border-radius: 10px;
            padding: 14px 17px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #1e40af;
        }

        .account-info strong {
            color: #1e3a8a;
        }

        .data-card {
            background: #fff;
            border: 1px solid #e8edf5;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
            overflow: hidden;
        }

        .data-card-header {
            padding: 17px 20px;
            border-bottom: 1px solid #e8edf5;
            background: #fff;
        }

        .data-card-title {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .guru-table {
            width: 100%;
            min-width: 1400px;
            border-collapse: collapse;
            font-size: 13px;
        }

        .guru-table thead th {
            background: #f8fafc;
            color: #475569;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.02em;
            padding: 13px 14px;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
            text-align: left;
        }

        .guru-table tbody td {
            padding: 13px 14px;
            border-bottom: 1px solid #eef2f7;
            color: #475569;
            vertical-align: middle;
            white-space: nowrap;
        }

        .guru-table tbody tr:last-child td {
            border-bottom: none;
        }

        .guru-table tbody tr:hover {
            background: #f8fafc;
        }

        .number-cell {
            color: #64748b;
            width: 50px;
            text-align: center;
        }

        .name-cell {
            color: #1e293b !important;
            font-weight: 600;
        }

        .nip-cell {
            color: #334155 !important;
            font-weight: 500;
        }

        .email-cell {
            color: #2563eb !important;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 5px 9px;
            border-radius: 6px;
            background: #f1f5f9;
            color: #475569;
            font-size: 12px;
            font-weight: 500;
            text-transform: capitalize;
        }

        .mapel-badge {
            display: inline-flex;
            align-items: center;
            padding: 5px 9px;
            border-radius: 6px;
            background: #eff6ff;
            color: #1d4ed8;
            font-size: 12px;
            font-weight: 500;
        }

        .action-wrapper {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 54px;
            padding: 6px 10px;
            border-radius: 7px;
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-edit {
            background: #eff6ff;
            border: 1px solid #dbeafe;
            color: #2563eb;
        }

        .btn-edit:hover {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .btn-delete {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            cursor: pointer;
        }

        .btn-delete:hover {
            background: #fee2e2;
            color: #b91c1c;
        }

        .empty-state {
            padding: 45px 20px !important;
            text-align: center;
            color: #94a3b8 !important;
            white-space: normal !important;
        }

        .room-pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            margin-bottom: 20px;
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
            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .btn-add {
                width: 100%;
            }

            .data-card {
                border-radius: 10px;
            }

            .guru-table {
                min-width: 1200px;
            }
        }
    </style>

    <div class="container-fluid py-4 guru-page">

        <div class="page-header">
            <div>
                <h4 class="page-title">Master Guru</h4>
                <p class="page-subtitle">
                    Kelola data guru dan informasi kepegawaian.
                </p>
            </div>

            <a href="{{ route('guru.create') }}" class="btn-add">
                Tambah Guru
            </a>
        </div>



        @if(session('username') || session('password_awal'))
            <div class="account-info">
                <strong>Username:</strong> {{ session('username') }}
                <br>
                <strong>Password awal:</strong> {{ session('password_awal') }}
            </div>
        @endif

        <div class="data-card">

            <div class="data-card-header">
                <h5 class="data-card-title">Data Guru</h5>
            </div>

            <div class="table-wrapper">
                <table class="guru-table">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Tanggal Lahir</th>
                            <th>Agama</th>
                            <th>Alamat</th>
                            <th>No. HP</th>
                            <th>Email</th>
                            <th>Status Kepegawaian</th>
                            <th>Jabatan</th>
                            <th>TMT</th>
                            <th>Mata Pelajaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($gurus as $guru)

                            <tr>
                                <td class="number-cell">
                                    {{ $gurus->firstItem() + $loop->index }}
                                </td>

                                <td class="nip-cell">
                                    {{ $guru->nip }}
                                </td>

                                <td class="name-cell">
                                    {{ $guru->nama }}
                                </td>

                                <td>
                                    {{ $guru->jk }}
                                </td>

                                <td>
                                    {{ optional($guru->tgl_lahir)->format('d-m-Y') }}
                                </td>

                                <td>
                                    {{ $guru->agama }}
                                </td>

                                <td>
                                    {{ $guru->alamat }}
                                </td>

                                <td>
                                    {{ $guru->no_hp }}
                                </td>

                                <td class="email-cell">
                                    {{ $guru->email }}
                                </td>

                                <td>
                                    <span class="status-badge">
                                        {{ str_replace('_', ' ', $guru->status_kepegawaian) }}
                                    </span>
                                </td>

                                <td>
                                    <span class="status-badge">
                                        {{ str_replace('_', ' ', $guru->jabatan) }}
                                    </span>
                                </td>

                                <td>
                                    {{ optional($guru->tmt)->format('d-m-Y') }}
                                </td>

                                <td>
                                    @if(optional($guru->mataPelajaran)->nama_mapel)
                                        <span class="mapel-badge">
                                            {{ $guru->mataPelajaran->nama_mapel }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="action-wrapper">

                                        <a href="{{ route('guru.edit', $guru->id) }}" class="btn-action btn-edit">
                                            Edit
                                        </a>

                                        <form action="{{ route('guru.destroy', $guru->id) }}" method="POST" class="m-0">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn-action btn-delete"
                                                onclick="return confirm('Hapus data guru?')">
                                                Hapus
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="14" class="empty-state">
                                    Belum ada data guru.
                                </td>
                            </tr>

                        @endforelse
                    </tbody>

                </table>
            </div>
            <div class="room-pagination">
                {{ $gurus->links('pagination::bootstrap-5') }}
            </div>

        </div>

@endsection