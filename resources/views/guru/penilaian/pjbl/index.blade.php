@extends('layouts.app')

@section('title', 'Penilaian PjBL')

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
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h2 class="page-title">Penilaian PjBL</h2>

                <a href="{{ route('guru.penilaian-pjbl.riwayat') }}" class="btn-nilai fs-12">
                    <i class="bi bi-clock-history me-1"></i>
                    Riwayat Penilaian
                </a>
            </div>

            <p class="page-subtitle">Guru: {{ $guru->nama ?? '-' }}</p>
            @forelse ($pjblPenguji as $item)
                <div class="pjbl-card">
                    <h3>{{ $item->pjbl->periode ? ucwords(str_replace('_', ' ', $item->pjbl->periode)) : '-' }}</h3>

                    <p class="pjbl-meta">
                        Kelas: {{ $item->pjbl->kelas->tingkat ?? '-' }} {{ $item->pjbl->kelas->jurusan->kode_jurusan ?? '-' }}
                        {{ $item->pjbl->kelas->nama_kelas ?? '-' }}
                    </p>

                    <p class="pjbl-meta">
                        Tahun Ajaran: {{ $item->pjbl->tahunAjaran->tahun_ajaran ?? '-' }}
                        {{ $item->pjbl->tahunAjaran->semester ?? '-' }}
                    </p>

                    <p class="pjbl-meta">
                        Jenis Penguji: {{ $item->jenis_peguji ? ucwords(str_replace('_', ' ', $item->jenis_peguji)) : '-' }}
                    </p>

                    <a href="{{ route('guru.penilaian-pjbl.nilai', $item->pjbl_id) }}" class="btn-nilai fs-12">
                        Mulai Menilai
                    </a>
                </div>
            @empty
                <p class="mb-0 text-muted">Belum ada PjBL yang ditugaskan kepada Anda.</p>
            @endforelse
        </div>
    </div>
@endsection