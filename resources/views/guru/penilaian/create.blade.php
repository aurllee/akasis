@extends('layouts.app')

@section('title', 'Input Nilai')

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

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
        }

        .page-header h3 {
            margin: 0 0 6px;
            font-size: 25px;
            font-weight: 500;
        }

        .page-header p {
            margin: 0;
            color: #64748b;
        }

        .form-control,
        .form-select {
            box-sizing: border-box;
            padding: 8px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
        }

        .penilaian-filter {
            font-size: 13px;
        }

        .penilaian-filter .form-label,
        .penilaian-filter .form-control,
        .penilaian-filter .form-select {
            font-size: 13px;
        }

        .form-select {
            max-width: 220px;
            width: 100%;
        }

        .table th {
            background: #eff6ff;
            color: #1e40af;
            font-size: 0.82rem;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        .btn-action {
            display: inline-block;
            padding: 9px 14px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            border: none;
            cursor: pointer;
            font-size: 13px;
        }

        .btn-primary {
            background: #2449a4;
            color: #ffffff;
        }

        .btn-secondary {
            background: #64748b;
            color: #ffffff;
        }

        .btn-action:hover {
            opacity: 0.95;
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
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
            <div class="page-header mb-4">
                <div>
                    <h3>Input Nilai</h3>
                    <p>
                        {{ $jadwal->mapel?->nama_mapel ?? 'Mata pelajaran tidak tersedia' }}
                        - Tingkat {{ $jadwal->kelas?->tingkat ?? 'Tingkat tidak tersedia' }}
                        - Kelas {{ $jadwal->kelas?->nama_kelas ?? 'Kelas tidak tersedia' }}
                        - Jurusan {{ $jadwal->kelas?->jurusan?->nama_jurusan ?? 'Jurusan tidak tersedia' }}
                    </p>
                </div>


            </div>

            <form action="{{ route('guru.penilaian.store', $jadwal->id) }}" method="POST">
                @csrf

                <div class="penilaian-filter mb-3" style="max-width: 220px;">
                    <label class="form-label fw-semibold">Jenis Nilai</label>
                    <select name="jenis_nilai" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <option value="harian">Harian</option>
                        <option value="ujian">Ujian</option>
                    </select>
                </div>

                <div class="penilaian-filter mb-4">
                    <label for="tanggal_penilaian" class="form-label fw-semibold">Tanggal Penilaian</label>
                    <input type="date" name="tanggal_penilaian" id="tanggal_penilaian" class="form-control"
                        value="{{ old('tanggal_penilaian', date('Y-m-d')) }}" required>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th width="60">No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th width="180">Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($siswa as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->nisn }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>
                                        <input type="number" name="nilai[{{ $item->id }}]" class="form-control" min="0"
                                            max="100" step="0.01" placeholder="0-100">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn-action btn-primary fs-12">
                        Simpan Semua Nilai
                    </button>

                    <a href="{{ route('guru.penilaian.detail', $jadwal->id) }}" class="btn-action btn-secondary fs-12">
                        Lihat Detail
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection