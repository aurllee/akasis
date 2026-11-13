@extends('layouts.app')

@section('title', 'Detail Riwayat Nilai PjBL')

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
            font-size: 25px;
            font-weight: 500;
            margin: 0 0 8px;
        }

        .page-subtitle {
            margin: 0 0 22px;
            color: #64748b;
        }

        .pjbl-card {
            border: 1px solid #e2e8f0;
            padding: 18px 20px;
            border-radius: 12px;
            margin-bottom: 16px;
            background: #f8fafc;
        }

        .pjbl-card h3 {
            margin: 0 0 10px;
            font-size: 20px;
        }

        .pjbl-meta {
            margin: 6px 0;
            color: #64748b;
        }

        .btn-nilai {
            display: inline-block;
            margin-top: 12px;
            padding: 9px 14px;
            border-radius: 8px;
            background: #2449a4;
            color: #ffffff;
            text-decoration: none;
            font-weight: 500;
        }

        .btn-nilai:hover {
            color: #ffffff;
            background: #1e3a8a;
        }

        @media (max-width: 768px) {
            .page-card {
                padding: 18px;
            }
        }

        .fs-12 {
            font-size: 13px;
        }
    </style>
@endpush

@section('content')
    <div class="page-wrap">
        <div class="page-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="page-title">Detail Riwayat Penilaian</h1>
                    <p class="page-subtitle mb-0">
                        {{ $penguji->pjbl?->nama_periode ?? $penguji->pjbl?->periode ?? 'PJBL' }}
                    </p>
                </div>
                <a href="{{ route('guru.penilaian-pjbl.riwayat') }}" class="btn btn-secondary fs-12">
                    Kembali
                </a>
            </div>

            <div class="mb-4">
                <p class="mb-1">
                    <strong>Kelas:</strong>
                    {{ $penguji->pjbl?->kelas?->tingkat ?? '' }}
                    {{ $penguji->pjbl?->kelas?->jurusan?->kode_jurusan ?? '' }}
                    {{ $penguji->pjbl?->kelas?->nama_kelas ?? '-' }}
                </p>
                <p class="mb-1"><strong>Tahun Ajaran:</strong> {{ $penguji->pjbl?->tahunAjaran?->tahun_ajaran ?? '-' }}
                    {{ $penguji->pjbl?->tahunAjaran?->semester ?? '-' }}
                </p>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>NIS</th>
                            <th>Nilai</th>
                            <th>Tanggal Penilaian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penguji->penilaian as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->siswa?->nama ?? '-' }}</td>
                                <td>{{ $item->siswa?->nis ?? '-' }}</td>
                                <td class="fw-semibold">{{ $item->nilai }}</td>
                                <td>{{ $item->updated_at?->format('d/m/Y') ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Belum ada nilai pada sesi ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection