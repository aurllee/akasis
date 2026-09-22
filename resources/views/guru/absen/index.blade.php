@extends('layouts.app')

@section('title', 'Absensi')

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

        .btn-primary {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 8px;
            background: #2449a4;
            border: none;
            color: #ffffff;
            text-decoration: none;
            font-weight: 500;
        }

        .btn-primary:hover {
            opacity: 0.95;
            color: #ffffff;
            text-decoration: none;
        }

        .empty-state {
            padding: 20px;
            border-radius: 10px;
            background: #f8fafc;
            color: #64748b;
            text-align: center;
        }

        .fs-12 {
            font-size: 13px;
        }
    </style>
@endpush

@section('content')
    <div class="page-wrap">
        <div class="page-card">
            <h1 class="page-title">Absensi</h1>
            <p class="page-subtitle">Daftar jadwal pelajaran yang dapat dibuka untuk absensi.</p>

            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead>
                        <tr>
                            <th width="60">No</th>
                            <th>Hari</th>
                            <th>Kelas</th>
                            <th>Mata Pelajaran</th>
                            <th>JP</th>
                            <th width="180">Aksi</th>
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
                                <td>{{ $item->mapel?->nama_mapel ?? 'Mata pelajaran tidak tersedia' }}</td>
                                <td>
                                    {{ $item->jamPelajaran?->jp ?? '-' }}
                                    - {{ ($item->jamPelajaran?->jp ?? 0) + ($item->jumlah_jp ?? 1) - 1 }}
                                </td>
                                <td>
                                    <form action="{{ route('absensi.buka', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary w-100 fs-12">
                                            Buka Absensi
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state mb-0">
                                        Belum ada jadwal pelajaran untuk Anda.
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