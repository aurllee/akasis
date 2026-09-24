@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@push('styles')
    <style>
        body {
            background: #f4f7fb;
            color: #1f2937;
            font-family: 'Poppins', sans-serif;
        }

        .student-welcome,
        .student-panel {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(30, 64, 102, 0.05);
        }

        .student-welcome {
            background: linear-gradient(135deg, #2449a4 0%, #3c73fe 100%);
            color: #ffffff;
            padding: 24px;
        }

        .student-welcome h1 {
            font-size: 24px;
            font-weight: 600;
            margin: 0 0 6px;
        }

        .student-welcome p {
            color: rgba(255, 255, 255, 0.82);
            margin: 0;
        }

        .student-panel {
            padding: 22px;
        }

        .student-panel h2 {
            color: #1e293b;
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 18px;
        }

        .biodata-grid {
            display: grid;
            gap: 12px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .biodata-item {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 14px;
        }

        .biodata-label {
            color: #64748b;
            display: block;
            font-size: 12px;
            margin-bottom: 4px;
        }

        .biodata-value {
            color: #1e293b;
            font-size: 14px;
            font-weight: 600;
        }

        .student-table {
            min-width: 640px;
        }

        .student-table th {
            background: #eff6ff;
            color: #1e40af;
            font-size: 12px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .student-table td {
            color: #334155;
            font-size: 14px;
        }

        .student-table tbody tr:hover {
            background: #f8fafc;
        }

        .empty-state {
            color: #64748b;
            padding: 28px !important;
            text-align: center;
        }

        @media (max-width: 768px) {

            .student-welcome,
            .student-panel {
                padding: 18px;
            }

            .biodata-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    <div class="student-dashboard">
        <section class="student-welcome mb-3">
            <h1>Halo, {{ $siswa?->nama ?? auth()->user()->username ?? 'Siswa' }}</h1>
            <p>Selamat datang di dashboard akademik kamu.</p>
        </section>

        <section class="student-panel mb-3">
            <h2>Biodata Siswa</h2>
            <div class="biodata-grid">
                <div class="biodata-item"><span class="biodata-label">NIS</span><span
                        class="biodata-value">{{ $siswa?->nis ?? 'Tidak tersedia' }}</span></div>
                <div class="biodata-item"><span class="biodata-label">Nomor HP</span><span
                        class="biodata-value">{{ $siswa?->no_hp ?? 'Tidak tersedia' }}</span></div>
                <div class="biodata-item"><span class="biodata-label">Jenis Kelamin</span><span
                        class="biodata-value">{{ $siswa?->jk ?? 'Tidak tersedia' }}</span></div>
                <div class="biodata-item"><span class="biodata-label">Kelas</span><span
                        class="biodata-value">{{ $kelas?->tingkat ?? '-' }} {{ $kelas?->jurusan?->kode_jurusan ?? '' }}
                        {{ $kelas?->nama_kelas ?? '-' }}</span></div>
                <div class="biodata-item"><span class="biodata-label">Wali Kelas</span><span
                        class="biodata-value">{{ $kelas?->waliKelas?->nama ?? 'Tidak tersedia' }}</span></div>
                <div class="biodata-item"><span class="biodata-label">Tahun Ajaran / Semester</span><span
                        class="biodata-value">{{ $kelas?->tahunAjaran?->tahun_ajaran ?? '-' }} /
                        {{ $kelas?->tahunAjaran?->semester ?? '-' }}</span></div>
            </div>
        </section>
    </div>
@endsection