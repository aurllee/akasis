@extends('layouts.app')

@section('title', 'Detail Penilaian')

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
        font-size: 25px;

    }

    .page-subtitle {
        margin: 0 0 20px;
        color: #64748b;
    }

    .card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
        overflow: hidden;
    }

    .card-body {
        padding: 20px;
    }

    .card-body.p-0 {
        padding: 0;
    }

    .card-footer {
        padding: 14px 20px;
        border-top: 1px solid #e2e8f0;
    }

    .d-flex {
        display: flex;
    }

    .justify-content-between {
        justify-content: space-between;
    }

    .align-items-center {
        align-items: center;
    }

    .mb-1 {
        margin-bottom: 4px;
    }

    .mb-3 {
        margin-bottom: 16px;
    }

    .mb-4 {
        margin-bottom: 24px;
    }

    .fw-bold {
        font-weight: 700;
    }

    .fw-semibold {
        font-weight: 600;
    }

    .text-muted {
        color: #64748b;
    }

    .text-start {
        text-align: left;
    }

    .text-center {
        text-align: center;
    }

    .d-block {
        display: block;
    }

    .row {
        display: flex;
        gap: 24px;
    }

    .col-md-4 {
        flex: 1;
    }

    small {
        display: block;
        margin-bottom: 6px;
        font-size: 12px;
    }

    .btn,
    .btn-action {
        display: inline-block;
        padding: 9px 14px;
        border-radius: 8px;
        text-decoration: none;
        cursor: pointer;
        font-size: 14px;
        border: 1px solid transparent;
    }

    .btn-primary,
    .btn-action.btn-primary {
        background: #2449a4;
        color: #ffffff;
    }

    .btn-secondary {
        background: #64748b;
        color: #ffffff;
    }

    .btn-outline-secondary {
        border-color: #cbd5e1;
        color: #475569;
        background: #ffffff;
    }

    .filter-form {
        display: flex;
        align-items: end;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .filter-form label {
        display: block;
        margin-bottom: 6px;
        font-size: 13px;
        font-weight: 600;
    }

    .filter-form select {
        min-width: 180px;
        padding: 9px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 13px;
    }

    .filter-form button,
    .filter-form a {
        font-size: 13px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        min-width: 700px;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        padding: 10px 12px;
        border: 1px solid #e2e8f0;
        vertical-align: middle;
    }

    .table th {
        background: #eff6ff;
        color: #1e40af;
    }

    .form-control {
        box-sizing: border-box;
        width: 100%;
        padding: 8px;
        border: 1px solid #cbd5e1;
        border-radius: 4px;
    }

    .nilai-input {
        text-align: right;
    }

    .nilai-cell {
        text-align: right;
    }

    .py-5 {
        padding-top: 48px;
        padding-bottom: 48px;
    }

    .pagination {
        display: flex;
        gap: 6px;
        align-items: center;
        padding: 14px 0 0;
        flex-wrap: wrap;
    }

    .pagination a,
    .pagination span {
        padding: 6px 10px;
        border: 1px solid #cbd5e1;
        border-radius: 4px;
        text-decoration: none;
        color: #475569;
    }

    .pagination .active span {
        background: #2449a4;
        color: #ffffff;
    }

    @media (max-width: 768px) {
        .row {
            flex-direction: column;
            gap: 14px;
        }

        .d-flex {
            align-items: flex-start;
            flex-direction: column;
            gap: 12px;
        }
    }

    .shadow-medium {
        box-shadow: 0 0.125rem 0.3rem rgba(0, 0, 0, 0.12);
    }

    .fs-12 {
        font-size: 13px;
    }

    .walas-page .wali-detail-page.page-wrap {
        max-width: none;
        margin: 0;
    }

    .walas-page .wali-detail-page .page-title {
        font-weight: 500;
    }

    .walas-page .wali-detail-page .card {
        padding: 0;
        border-radius: 10px;
    }

    .walas-page .wali-detail-page .card.border-0 {
        border: 0;
    }

    .walas-page .wali-detail-page .shadow-medium {
        box-shadow: 0 0.125rem 0.3rem rgba(0, 0, 0, 0.12);
    }

    .walas-page .wali-detail-page .shadow-sm {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .walas-page .wali-detail-page .table th,
    .walas-page .wali-detail-page .table td {
        padding: 10px 12px;
    }

    .walas-page .wali-detail-page .table th {
        font-size: 1rem;
        font-weight: 600;
        letter-spacing: normal;
        text-transform: none;
        white-space: normal;
        border-bottom: 1px solid #e2e8f0;
    }

    .walas-page .wali-detail-page .table td {
        font-size: 1rem;
    }

    .walas-page .wali-detail-page table tbody tr:hover td {
        background: transparent;
    }
</style>
@endpush

@section('content')
<div class="page-wrap wali-detail-page">
    <div class="page-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="page-title">Detail Penilaian</h1>
                <p class="page-subtitle mb-0">
                    {{ $jadwal->mataPelajaran->nama_mapel ?? '-' }}
                    - Kelas
                    {{ $jadwal->kelas?->tingkat ?? '-' }}
                    {{ $jadwal->kelas?->jurusan?->kode_jurusan ?? '-' }}
                    {{ $jadwal->kelas?->nama_kelas ?? '-' }}
                </p>
            </div>

            <a href="{{ route('wali-kelas.kelas-mengajar') }}" class="btn btn-secondary fs-12">
                Kembali
            </a>
        </div>

        <div class="card border-0 shadow-medium mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <small class="text-muted">Mata Pelajaran</small>
                        <div class="fw-semibold">
                            {{ $jadwal->mataPelajaran->nama_mapel ?? '-' }}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <small class="text-muted">Kelas</small>
                        <div class="fw-semibold">
                            {{ $jadwal->kelas?->tingkat ?? '-' }}
                            {{ $jadwal->kelas?->jurusan?->kode_jurusan ?? '-' }}
                            {{ $jadwal->kelas?->nama_kelas ?? '-' }}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <small class="text-muted">Semester</small>
                        <div class="fw-semibold">
                            {{ $jadwal->kelas->tahunAjaran->semester ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">Daftar Nilai Siswa</h5>

            <a href="{{ route('wali-kelas.input-nilai', $jadwal->id) }}" class="btn btn-primary fs-12">
                + Tambah Penilaian
            </a>
        </div>

        <form action="{{ route('wali-kelas.detail-nilai', $jadwal->id) }}" method="GET" class="filter-form">
            <div>
                <label for="jenis_nilai">Filter Jenis Penilaian</label>
                <select name="jenis_nilai" id="jenis_nilai">
                    <option value="">Semua</option>
                    <option value="harian" @selected($jenisNilai==='harian' )>Harian</option>
                    <option value="ujian" @selected($jenisNilai==='ujian' )>Ujian</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary fs-12">Tampilkan</button>
            @if($jenisNilai)
            <a href="{{ route('wali-kelas.detail-nilai', $jadwal->id) }}" class="btn btn-outline-secondary">Reset</a>
            @endif
        </form>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead class="table-light text-center">
                            <tr>
                                <th width="60">No</th>
                                <th width="120">NIS</th>
                                <th class="text-start">Nama Siswa</th>

                                @foreach($jenisPenilaian as $jenis)
                                @php
                                $tanggalJenis = \Carbon\Carbon::parse($jenis->tanggal_penilaian)->format('d-m-Y');
                                @endphp
                                <th width="160">
                                    <span class="d-block fw-semibold">
                                        {{ ucfirst($jenis->jenis_nilai) }} {{ $jenis->penilaian_ke }}
                                    </span>
                                    <small class="text-muted d-block mt-1">
                                        {{ $tanggalJenis }}
                                    </small>
                                    <small class="text-muted d-block">
                                        {{ $jenis->judul_tugas ?: '-' }}
                                    </small>
                                </th>
                                @endforeach
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($siswa as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center">{{ $item->nisn ?? '-' }}</td>
                                <td>
                                    <strong>{{ $item->nama }}</strong>
                                </td>

                                @foreach($jenisPenilaian as $jenis)
                                @php
                                $nilai = $nilaiSiswa
                                ->where('siswa_id', $item->id)
                                ->where('jenis_nilai', $jenis->jenis_nilai)
                                ->where('tanggal_penilaian', $jenis->tanggal_penilaian)
                                ->where('judul_tugas', $jenis->judul_tugas)
                                ->first();
                                @endphp

                                <td class="nilai-cell text-center">
                                    {{ $nilai->nilai ?? '-' }}
                                </td>
                                @endforeach

                                <td class="text-center">
                                    <a href="{{ route('wali-kelas.input-nilai', $jadwal->id) }}"
                                        class="btn btn-primary">
                                        Input
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ 3 + $jenisPenilaian->count() + 1 }}"
                                    class="text-center py-5 text-muted">
                                    Belum ada siswa pada kelas ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($siswa->count() > 0)
            <div class="card-footer bg-white text-end"></div>
            @endif

        </div>
    </div>
</div>
@endsection