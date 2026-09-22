@extends('layouts.app')

@section('title', 'Master Kelas')

@push('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #212529;
            background: #f5f6fa;
        }

        .academic-page {
            color: #1f2937;
        }

        .academic-panel {
            background: #fff;
            border: 1px solid #e4eaf2;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(30, 64, 102, 0.05);
            padding: 24px;
        }

        .academic-header {
            align-items: center;
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .academic-title {
            color: #1e293b;
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }

        .academic-add {
            background: #2449a4;
            border-radius: 8px;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            padding: 10px 14px;
        }

        .academic-add:hover {
            background: #2449a4;
            color: #fff;
            text-decoration: none;
        }

        .academic-table-wrapper {
            overflow-x: auto;
        }

        .academic-table {
            min-width: 680px;
            width: 100%;
            border-collapse: collapse;
        }

        .academic-table th,
        .academic-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .academic-table th {
            background: #f1f5fb;
            color: #475569;
            font-size: 12px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .academic-table td {
            color: #374151;
            font-size: 14px;
        }

        .academic-table tbody tr:hover {
            background: #f8fbff;
        }

        .academic-code {
            color: #2449a4;
            font-weight: 600;
        }

        .academic-status {
            font-size: 14px;
            font-weight: 600;
            padding: 5px 9px;
        }

        .academic-status.is-inactive {
            background: #f1f5f9;
            color: #64748b;
        }

        .academic-action {
            display: flex;
            gap: 8px;
            white-space: nowrap;
        }

        .academic-action a,
        .academic-action button {
            border: 1px solid transparent;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            padding: 7px 10px;
            text-decoration: none;
        }

        .academic-edit {
            background: #eff6ff;
            border-color: #93c5fd !important;
            color: #1d4ed8;
        }

        .academic-delete {
            background: #fef2f2;
            border-color: #fca5a5 !important;
            color: #b91c1c;
        }

        .academic-edit:hover {
            background: #dbeafe;
            color: #1e40af;
        }

        .academic-delete:hover {
            background: #fee2e2;
            color: #991b1b;
        }

        .academic-empty {
            color: #64748b !important;
            padding: 28px !important;
            text-align: center !important;
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
            .academic-panel {
                padding: 18px;
            }

            .academic-header {
                align-items: flex-start;
                flex-direction: column;
                gap: 14px;
            }
        }
    </style>
@endpush

@section('content')

    <div class="academic-page">
        <div class="academic-panel">
            <div class="academic-header">
                <h1 class="academic-title">Master Kelas</h1>
                <a class="academic-add text-decoration-none" href="{{ route('kelas.create') }}"> Tambah Kelas
                </a>
            </div>

            <div class="academic-table-wrapper">
                <table class="academic-table">
                    <thead>
                        <tr>
                            <th>No</th>
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
                                <td>{{ $kelases->firstItem() + $loop->index }}</td>
                                <td><span class="academic-status">{{ $kelas->tingkat }}</span></td>
                                <td>
                                    <span class="academic-code">{{ optional($kelas->jurusan)->kode_jurusan ?? '-' }}</span> - 
                                    {{ optional($kelas->jurusan)->nama_jurusan ?? '-' }}
                                </td>
                                <td><strong>{{ $kelas->nama_kelas }}</strong></td>
                                <td>{{ optional($kelas->waliKelas)->nama ?? '-' }}</td>
                                <td>{{ optional($kelas->tahunAjaran)->tahun_ajaran ?? '-' }}</td>
                                <td>
                                    <div class="academic-action">
                                        <a class="academic-edit" href="{{ route('kelas.edit', $kelas->id) }}">Edit</a>
                                        <form action="{{ route('kelas.destroy', $kelas->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="academic-delete" type="submit"
                                                onclick="return confirm('Hapus data kelas?')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="academic-empty">Belum ada data kelas.</td>
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
    </div>

@endsection