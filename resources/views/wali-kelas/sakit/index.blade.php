@extends('layouts.app')

@section('title', 'Izin Tidak Masuk Siswa')

@push('styles')
    <style>
        .page-header {
            margin-bottom: 20px;
        }

        .page-title {
            font-size: 24px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .page-subtitle {
            color: #64748b;
            font-size: 14px;
            margin: 0;
        }

        .card-custom {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            padding: 24px;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 14px;
            background-color: #ffffff;
        }

        .custom-table thead th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: 600;
            padding: 14px 16px;
            border-bottom: 2px solid #e2e8f0;
            font-size: 12px;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .custom-table tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            vertical-align: middle;
        }

        .custom-table tbody tr:last-child td {
            border-bottom: none;
        }

        .custom-table tbody tr:hover {
            background-color: #f8fafc;
        }

        .empty-table {
            text-align: center;
            color: #64748b;
            padding: 28px !important;
            font-style: italic;
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <h1 class="page-title">Izin Tidak Masuk Siswa</h1>
        <p class="page-subtitle">Daftar pengajuan izin tidak masuk siswa yang perlu verifikasi wali kelas.</p>
    </div>

    <div class="card-custom">
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">NO</th>
                        <th>SISWA</th>
                        <th>TANGGAL</th>
                        <th>ALASAN</th>
                        <th>DOKUMEN</th>
                        <th>STATUS</th>
                        <th style="text-align: center;">VERIFIKASI</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Ganti kondisi di bawah sesuai logika data dari controller --}}
                    @forelse ($izinTidakMasuk ?? [] as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->siswa->nama ?? '-' }}</td>
                            <td>{{ $item->tanggal ?? '-' }}</td>
                            <td>{{ $item->alasan ?? '-' }}</td>
                            <td>
                                @if($item->dokumen)
                                    <a href="{{ asset('storage/'.$item->dokumen) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat Dokumen</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ ucfirst($item->status ?? '-') }}</td>
                            <td style="text-align: center;">
                                {{-- Tombol Aksi --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-table">
                                Belum ada pengajuan izin tidak masuk siswa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection