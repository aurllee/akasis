@extends('layouts.app')

@section('title', 'Master Tahun Ajaran')

@section('content')

<style>
    body {
        font-family: 'Poppins', sans-serif;
    }

    .tahun-ajaran-page {
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
        padding: 20px 24px;
        border-bottom: 1px solid #e8edf5;
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

    .tahun-ajaran-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 680px;
    }

    .tahun-ajaran-table th {
        padding: 13px 18px;
        background: #f8fafc;
        border-bottom: 1px solid #e8edf5;
        color: #475569;
        font-size: 13px;
        font-weight: 600;
        text-align: left;
        white-space: nowrap;
    }

    .tahun-ajaran-table td {
        padding: 14px 18px;
        border-bottom: 1px solid #eef2f7;
        color: #334155;
        font-size: 14px;
        vertical-align: middle;
    }

    .tahun-ajaran-table tbody tr:last-child td {
        border-bottom: none;
    }

    .tahun-ajaran-table tbody tr {
        transition: 0.2s ease;
    }

    .tahun-ajaran-table tbody tr:hover {
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

    .status-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        background: #ecfdf5;
        color: #047857;
    }

    .status-badge.is-inactive {
        background: #f1f5f9;
        color: #64748b;
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
        .tahun-ajaran-page {
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

        .tahun-ajaran-table th,
        .tahun-ajaran-table td {
            padding: 12px 14px;
        }
    }
</style>

<div class="tahun-ajaran-page">

    <div class="page-header">
        <div class="page-header-content">
            <div>
                <h1 class="page-title">Master Tahun Ajaran</h1>
                <p class="page-subtitle">
                    Kelola data tahun ajaran sekolah.
                </p>
            </div>

            <a href="{{ route('tahun-ajaran.create') }}" class="btn-add">
                Tambah Tahun Ajaran
            </a>
        </div>
    </div>

    <div class="data-card">

        <div class="data-card-header">
            <h2 class="data-card-title">Data Tahun Ajaran</h2>
        </div>

        <div class="table-wrapper">
            <table class="tahun-ajaran-table">
                <thead>
                    <tr>
                        <th class="number-cell">No</th>
                        <th>Tahun Ajaran</th>
                        <th>Semester</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($tahunAjaran as $tahun)
                        <tr>
                            <td class="number-cell">
                                {{ $tahunAjaran->firstItem() + $loop->index }}
                            </td>

                            <td class="kode-cell">
                                {{ $tahun->tahun_ajaran }}
                            </td>

                            <td>
                                {{ $tahun->semester }}
                            </td>

                            <td>
                                <span class="status-badge {{ $tahun->status ? '' : 'is-inactive' }}">
                                    {{ $tahun->status ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>

                            <td>
                                <div class="action-wrapper">
                                    <a href="{{ route('tahun-ajaran.edit', $tahun->id) }}" class="btn-action btn-edit">
                                        Edit
                                    </a>

                                    <form action="{{ route('tahun-ajaran.destroy', $tahun->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn-action btn-delete" onclick="return confirm('Hapus tahun ajaran?')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-state">
                                Belum ada data tahun ajaran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="room-pagination">
            {{ $tahunAjaran->links('pagination::bootstrap-5') }}
        </div>

    </div>

</div>

@endsection