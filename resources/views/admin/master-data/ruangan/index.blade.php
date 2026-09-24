@extends('layouts.app')

@section('title', 'Master Ruangan')

@push('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #212529;
            background: #f5f6fa;
        }

        .room-page {
            color: #1f2937;
        }

        .room-panel {
            background: #fff;
            border: 1px solid #e4eaf2;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(30, 64, 102, 0.05);
            padding: 24px;
        }

        .room-header {
            align-items: center;
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .room-title {
            color: #1e293b;
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }

        .room-add {
            background: #2563eb;
            border-radius: 8px;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            padding: 10px 14px;
        }

        .room-add:hover {
            background: #2449a4;
            color: #fff;
            text-decoration: none;
        }

        .room-table-wrapper {
            overflow-x: auto;
        }

        .room-table {
            min-width: 680px;
            width: 100%;
            border-collapse: collapse;
        }

        .room-table th,
        .room-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .room-table th {
            background: #f1f5fb;
            color: #475569;
            font-size: 12px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .room-table td {
            color: #374151;
            font-size: 14px;
        }

        .room-table tbody tr:hover {
            background: #f8fbff;
        }

        .room-code {
            color: #2449a4;
            font-weight: 600;
        }

        .room-status {
            background: #ecfdf5;
            border-radius: 10px;
            color: #047857;
            display: inline-block;
            font-size: 12px;
            font-weight: 600;
            padding: 5px 9px;
        }

        .room-status.is-inactive {
            background: #f1f5f9;
            color: #64748b;
        }

        .room-action {
            display: flex;
            gap: 8px;
            white-space: nowrap;
        }

        .room-action a,
        .room-action button {
            border: 1px solid transparent;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            padding: 7px 10px;
            text-decoration: none;
        }

        .room-edit {
            background: #eff6ff;
            border-color: #93c5fd !important;
            color: #1d4ed8;
        }

        .room-delete {
            background: #fef2f2;
            border-color: #fca5a5 !important;
            color: #b91c1c;
        }

        .room-edit:hover {
            background: #dbeafe;
            color: #1e40af;
        }

        .room-delete:hover {
            background: #fee2e2;
            color: #991b1b;
        }

        .room-pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
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

        .room-empty {
            color: #64748b;
            padding: 28px !important;
            text-align: center !important;
        }

        @media (max-width: 768px) {
            .room-panel {
                padding: 18px;
            }

            .room-header {
                align-items: flex-start;
                flex-direction: column;
                gap: 14px;
            }
        }
    </style>

@endpush
@section('content')
    <div class="room-page">
        <div class="room-panel">
            <div class="room-header">
                <h1 class="room-title">Master Ruangan</h1>
                <a class="room-add text-decoration-none" href="{{ route('ruangan.create') }}"> Tambah Ruangan
                </a>
            </div>

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
                                <td>{{ $ruangan->firstItem() + $loop->index }}</td>
                                <td class="room-code">{{ $item->kode_ruang }}</td>
                                <td>{{ $item->nama_ruang }}</td>
                                <td>{{ $item->kapasitas }}</td>
                                <td><span
                                        class="room-status {{ $item->status ? '' : 'is-inactive' }}">{{ $item->status ? 'Aktif' : 'Tidak Aktif' }}</span>
                                </td>
                                <td>
                                    <div class="room-action">
                                        <a class="room-edit" href="{{ route('ruangan.edit', $item->id) }}">Edit</a>
                                        <form action="{{ route('ruangan.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="room-delete" type="submit"
                                                onclick="return confirm('Hapus ruangan?')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="room-empty">Belum ada data ruangan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="room-pagination">{{ $ruangan->links('pagination::bootstrap-5') }}</div>
        </div>
    </div>
@endsection