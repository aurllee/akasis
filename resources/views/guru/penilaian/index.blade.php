@extends('layouts.app')

@section('title', 'Penilaian')

@push('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #1f2937;
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

        .btn-action {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            text-decoration: none;
            margin-right: 8px;
        }

        .btn-primary {
            background: #2449a4;
            color: #ffffff;
            border-color: #2449a4;
        }

        .btn-outline-secondary {
            border: 1px solid #cbd5e1;
            color: #475569;
            background: #ffffff;
        }

        .btn-primary:hover,
        .btn-outline-secondary:hover {
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
    </style>
@endpush

@section('content')
    <div class="page-wrap">
        <div class="page-card">
            <h1 class="page-title">Penilaian</h1>
            <p class="page-subtitle">Daftar jadwal pelajaran yang dapat dinilai.</p>

            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead>
                        <tr>
                            <th width="60">No</th>
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th width="220">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jadwal as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->mapel?->nama_mapel ?? 'Mata pelajaran tidak tersedia' }}</td>
                                <td>
                                    {{ $item->kelas?->tingkat ?? '' }}
                                    {{ $item->kelas?->jurusan?->kode_jurusan ?? '' }}
                                    {{ $item->kelas?->nama_kelas ?? '' }}
                                </td>
                                <td>
                                    <a href="{{ route('guru.penilaian.create', $item->id) }}"
                                        class="btn-action btn-primary fs-12">
                                        Input Nilai
                                    </a>
                                    <a href="{{ route('guru.penilaian.detail', $item->id) }}"
                                        class="btn-action btn-outline-secondary fs-12">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
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