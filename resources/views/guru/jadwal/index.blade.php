@extends('layouts.app')

@section('title', 'Jadwal Mengajar')

@push('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #1f2937;
            background: #f4f7fb;
        }

        .page-wrap {
            width: 100%;
        }

        .page-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(15, 23, 42, 0.04);
            padding: 24px;
        }

        .page-title {
            margin: 0 0 8px;
            font-size: 25px;
            font-weight: 500;
            font-size: 25px;
        }

        .page-subtitle {
            margin: 0 0 20px;
            color: #64748b;
        }

        .table th {
            background: #eff6ff;
            color: #1e40af;
            font-size: 0.82rem;
            vertical-align: middle;
        }

        .table td {
            vertical-align: middle;
        }

        .empty-state {
            padding: 20px;
            border-radius: 10px;
            background: #f8fafc;
            color: #64748b;
            text-align: center;
        }
    </style>
@endpush

@section('content')
    <div class="page-wrap">
        <div class="page-card">
            <h1 class="page-title">Jadwal Mengajar</h1>
            <p class="page-subtitle">Daftar jadwal pelajaran yang telah dipublikasikan.</p>

            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead>
                        <tr>
                            <th width="60">No</th>
                            <th>Hari</th>
                            <th>Kelas</th>
                            <th>Mata Pelajaran</th>
                            <th>Ruangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jadwal as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->hari ?? '-' }}</td>
                                <td>
                                    {{ $item->kelas?->tingkat ?? '' }}
                                    {{ $item->kelas?->jurusan?->kode_jurusan ?? '' }}
                                    {{ $item->kelas?->nama_kelas ?? '' }}
                                </td>
                                <td>{{ $item->mapel?->nama_mapel ?? '-' }}</td>
                                <td>{{ $item->ruangan?->nama_ruang ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state mb-0">
                                        Belum ada jadwal yang dipublikasikan.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection