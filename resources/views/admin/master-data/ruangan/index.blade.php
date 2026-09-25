@extends('layouts.app')

@section('title', 'Master Ruangan')

@push('styles')
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #f5f7fb;
        color: #1f2937;
    }

    .room-page {
        padding: 8px 0;
    }

    .room-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05);
        overflow: hidden;
    }

    .room-card-header {
        padding: 22px 24px;
        border-bottom: 1px solid #eef0f4;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .room-header-title {
        margin: 0;
        color: #1f2937;
        font-size: 22px;
        font-weight: 700;
    }

    .room-header-subtitle {
        margin: 5px 0 0;
        color: #6b7280;
        font-size: 13px;
    }

    .room-add-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 15px;
        border-radius: 8px;
        background: #2563eb;
        border: 1px solid #2563eb;
        color: #ffffff;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .room-add-btn:hover {
        background: #1d4ed8;
        border-color: #1d4ed8;
        color: #ffffff;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .room-card-body {
        padding: 0;
    }

    .room-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .room-table {
        width: 100%;
        min-width: 720px;
        margin: 0;
        border-collapse: collapse;
    }

    .room-table thead th {
        padding: 14px 18px;
        background: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        white-space: nowrap;
    }

    .room-table tbody td {
        padding: 14px 18px;
        border-bottom: 1px solid #f1f5f9;
        color: #374151;
        font-size: 13px;
        vertical-align: middle;
    }

    .room-table tbody tr {
        transition: background 0.2s ease;
    }

    .room-table tbody tr:hover {
        background: #f8fbff;
    }

    .room-table tbody tr:last-child td {
        border-bottom: none;
    }

    .room-number {
        width: 60px;
        color: #64748b !important;
        font-weight: 500;
    }

    .room-code {
        color: #2563eb !important;
        font-weight: 700;
    }

    .room-name {
        color: #1f2937 !important;
        font-weight: 600;
    }

    .room-capacity {
        color: #475569 !important;
        font-weight: 500;
    }

    .room-status {
        display: inline-flex;
        align-items: center;
        padding: 5px 10px;
        border-radius: 20px;
        background: #ecfdf5;
        color: #047857;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .room-status.is-inactive {
        background: #f1f5f9;
        color: #64748b;
    }

    .room-action {
        display: flex;
        align-items: center;
        gap: 7px;
        white-space: nowrap;
    }

    .room-edit,
    .room-delete {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 52px;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .room-edit {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #2563eb;
    }

    .room-edit:hover {
        background: #dbeafe;
        border-color: #93c5fd;
        color: #1d4ed8;
        text-decoration: none;
    }

    .room-delete {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #dc2626;
    }

    .room-delete:hover {
        background: #fee2e2;
        border-color: #fca5a5;
        color: #b91c1c;
    }

    .room-empty {
        padding: 45px 20px !important;
        text-align: center !important;
        color: #94a3b8 !important;
        font-size: 13px !important;
    }

    .room-pagination-wrapper {
        padding: 18px 24px;
        border-top: 1px solid #eef0f4;
        display: flex;
        justify-content: center;
    }

    .room-pagination-wrapper nav {
        margin: 0;
    }

    .room-pagination-wrapper .pagination {
        margin: 0;
        gap: 5px;
    }

    .room-pagination-wrapper .page-item {
        margin: 0;
    }

    .room-pagination-wrapper .page-link {
        min-width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 10px;
        border: 1px solid #dbe1e8;
        border-radius: 7px !important;
        background: #ffffff;
        color: #64748b;
        font-size: 12px;
        box-shadow: none;
    }

    .room-pagination-wrapper .page-link:hover {
        background: #eff6ff;
        border-color: #93c5fd;
        color: #2563eb;
    }

    .room-pagination-wrapper .page-item.active .page-link {
        background: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
    }

    .room-pagination-wrapper .page-item.disabled .page-link {
        background: #f8fafc;
        border-color: #e5e7eb;
        color: #cbd5e1;
    }

    @media (max-width: 768px) {
        .room-card-header {
            align-items: flex-start;
            flex-direction: column;
            padding: 18px;
        }

        .room-add-btn {
            width: 100%;
            justify-content: center;
        }

        .room-pagination-wrapper {
            padding: 16px;
            overflow-x: auto;
            justify-content: flex-start;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="room-page">

        <div class="room-card">

            <div class="room-card-header">
                <div>
                    <h1 class="room-header-title">Master Ruangan</h1>
                    <p class="room-header-subtitle">
                        Kelola data ruangan yang digunakan dalam kegiatan pembelajaran.
                    </p>
                </div>

                <a href="{{ route('ruangan.create') }}" class="room-add-btn">
                    <i class="bi bi-plus-lg"></i>
                    Tambah Ruangan
                </a>
            </div>

            <div class="room-card-body">
                <div class="room-table-wrapper">
                    <table class="room-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Ruang</th>
                                <th>Nama Ruang</th>
                                <th>Kapasitas</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($ruangan as $item)
                                <tr>
                                    <td class="room-number">
                                        {{ $ruangan->firstItem() + $loop->index }}
                                    </td>

                                    <td class="room-code">
                                        {{ $item->kode_ruang }}
                                    </td>

                                    <td class="room-name">
                                        {{ $item->nama_ruang }}
                                    </td>

                                    <td class="room-capacity">
                                        {{ $item->kapasitas }}
                                    </td>

                                    <td>
                                        <span class="room-status {{ $item->status ? '' : 'is-inactive' }}">
                                            {{ $item->status ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="room-action">
                                            <a
                                                href="{{ route('ruangan.edit', $item->id) }}"
                                                class="room-edit"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                action="{{ route('ruangan.destroy', $item->id) }}"
                                                method="POST"
                                                class="d-inline"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="room-delete"
                                                    onclick="return confirm('Hapus ruangan?')"
                                                >
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="room-empty">
                                        Belum ada data ruangan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($ruangan->hasPages())
                    <div class="room-pagination-wrapper">
                        {{ $ruangan->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>

        </div>

    </div>
</div>
@endsection