@extends('layouts.app')

@section('title', 'Master Siswa')

@section('content')

<style>

    body {
        font-family: 'Poppins', sans-serif;
    }
    .siswa-page {
        padding: 24px;
    }

    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .page-title {
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 6px;
    }

    .page-subtitle {
        font-size: 14px;
        color: #64748b;
        margin: 0;
    }

    .btn-add {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 18px;
        background: #2563eb;
        color: #ffffff;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: 0.2s ease;
        white-space: nowrap;
    }

    .btn-add:hover {
        background: #1d4ed8;
        color: #ffffff;
    }

    

    .data-card {
        background: #ffffff;
        border: 1px solid #e8edf5;
        border-radius: 12px;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05);
        overflow: hidden;
    }

    .data-card-header {
        padding: 18px 20px;
        border-bottom: 1px solid #eef2f7;
    }

    .data-card-title {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .siswa-table {
        width: 100%;
        min-width: 1500px;
        border-collapse: collapse;
    }

    .siswa-table th {
        padding: 13px 14px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        color: #475569;
        font-size: 12px;
        font-weight: 700;
        text-align: left;
        white-space: nowrap;
    }

    .siswa-table td {
        padding: 13px 14px;
        border-bottom: 1px solid #eef2f7;
        color: #475569;
        font-size: 13px;
        vertical-align: middle;
        white-space: nowrap;
    }

    .siswa-table tbody tr {
        transition: 0.15s ease;
    }

    .siswa-table tbody tr:hover {
        background: #f8fafc;
    }

    .number-cell {
        width: 55px;
        text-align: center;
        color: #64748b;
        font-weight: 600;
    }

    .nis-cell {
        color: #1e293b;
        font-weight: 600;
    }

    .name-cell {
        color: #1e293b;
        font-weight: 600;
    }

    .jk-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        padding: 5px 9px;
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #dbeafe;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }

    .empty-state {
        padding: 40px 20px !important;
        text-align: center !important;
        color: #94a3b8 !important;
        font-size: 14px !important;
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
        padding: 7px 11px;
        border-radius: 6px;
        text-decoration: none;
        border: none;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .btn-edit {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #dbeafe;
    }

    .btn-edit:hover {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .btn-delete {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }

    .btn-delete:hover {
        background: #fee2e2;
        color: #b91c1c;
    }

    .delete-form {
        margin: 0;
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
        .siswa-page {
            padding: 16px;
        }

        .page-header {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-add {
            width: 100%;
        }

        .page-title {
            font-size: 21px;
        }

        .data-card-header {
            padding: 16px;
        }
    }
</style>

<div class="siswa-page">

<div class="page-header">
    <div>
        <h1 class="page-title">Master Siswa</h1>
        <p class="page-subtitle">
            Kelola data siswa yang terdaftar dalam sistem akademik.
        </p>
    </div>

    <a href="{{ route('siswa.create') }}" class="btn-add">
        Tambah Siswa
    </a>
</div>


<div class="data-card">

    <div class="data-card-header">
        <h2 class="data-card-title">Data Siswa</h2>
    </div>

    <div class="table-wrapper">
        <table class="siswa-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>NISN</th>
                    <th>Nama</th>
                    <th>JK</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>Agama</th>
                    <th>NIK</th>
                    <th>No. KK</th>
                    <th>Alamat</th>
                    <th>Nama Orang Tua</th>
                    <th>No. HP</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($siswas as $siswa)
                    <tr>
                        <td class="number-cell">
                            {{ $siswas->firstItem() + $loop->index }}
                        </td>

                        <td class="nis-cell">
                            {{ $siswa->nis }}
                        </td>

                        <td>
                            {{ $siswa->nisn ?? '-' }}
                        </td>

                        <td class="name-cell">
                            {{ $siswa->nama }}
                        </td>

                        <td>
                            <span class="jk-badge">
                                {{ $siswa->jk }}
                            </span>
                        </td>

                        <td>
                            {{ $siswa->tempat_lahir }}
                        </td>

                        <td>
                            {{ optional($siswa->tanggal_lahir)->format('d-m-Y') }}
                        </td>

                        <td>
                            {{ $siswa->agama }}
                        </td>

                        <td>
                            {{ $siswa->nik ?? '-' }}
                        </td>

                        <td>
                            {{ $siswa->no_kk ?? '-' }}
                        </td>

                        <td>
                            {{ $siswa->alamat }}
                        </td>
                        <td>
                            {{ $siswa->nama_orang_tua }}
                        </td>

                        <td>
                            {{ $siswa->no_hp ?? '-' }}
                        </td>

                        <td>
                            {{ $siswa->email ?? '-' }}
                        </td>

                        <td>
                            <div class="action-wrapper">

                                <a
                                    href="{{ route('siswa.edit', $siswa->id) }}"
                                    class="btn-action btn-edit"
                                >
                                    Edit
                                </a>

                                <form
                                    action="{{ route('siswa.destroy', $siswa->id) }}"
                                    method="POST"
                                    class="delete-form"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn-action btn-delete"
                                        onclick="return confirm('Hapus data siswa?')"
                                    >
                                        Hapus
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="14" class="empty-state">
                            Belum ada data siswa.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="room-pagination">{{ $siswas->links('pagination::bootstrap-5') }}>
    </div>
</div>

</div>

@endsection
