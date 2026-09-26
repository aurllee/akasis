@extends('layouts.app')

@section('title', 'Input Nilai')

@push('styles')
<style>
    .nilai-page .page-wrap {
        width: 100%;
    }

    .nilai-page .page-card {
        padding: 24px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(15, 23, 42, 0.04);
    }

    .nilai-page .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 24px;
    }

    .nilai-page .page-header h1 {
        margin: 0 0 6px;
        color: #1e293b;
        font-size: 25px;
        font-weight: 500;
    }

    .nilai-page .page-header p {
        margin: 0;
        color: #64748b;
        font-size: 14px;
    }

    .nilai-page .table th {
        background: #eff6ff;
        color: #1e40af;
        font-size: 0.82rem;
    }

    .nilai-page .table td,
    .nilai-page .table th {
        vertical-align: middle;
    }

    .nilai-page .nilai-input {
        max-width: 180px;
    }

    @media (max-width: 768px) {
        .nilai-page .page-header {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
<div class="nilai-page">
    <div class="page-wrap">
        <div class="page-card">
            <div class="page-header">
                <div>
                    <h1>Input Nilai</h1>
                    <p>
                        {{ $jadwal->mataPelajaran?->nama_mapel ?? 'Mata pelajaran tidak tersedia' }}
                        - Tingkat {{ $jadwal->kelas?->tingkat ?? '-' }}
                        - Kelas {{ $jadwal->kelas?->nama_kelas ?? '-' }}
                        - Jurusan {{ $jadwal->kelas?->jurusan?->nama_jurusan ?? '-' }}
                    </p>
                </div>
            </div>

            <form action="{{ route('wali-kelas.simpan-nilai', $jadwal->id) }}" method="POST" id="formInputNilai">
                @csrf

                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label for="jenis_nilai" class="form-label fw-semibold">Jenis Nilai</label>
                        <select name="jenis_nilai" id="jenis_nilai" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <option value="harian" @selected(old('jenis_nilai', $nilai->first()?->jenis_nilai ?? 'harian') === 'harian')>
                                Harian
                            </option>
                            <option value="ujian" @selected(old('jenis_nilai', $nilai->first()?->jenis_nilai) === 'ujian')>
                                Ujian
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="tanggal_penilaian" class="form-label fw-semibold">Tanggal Penilaian</label>
                        <input type="date" name="tanggal_penilaian" id="tanggal_penilaian" class="form-control"
                            value="{{ old('tanggal_penilaian', $nilai->first()?->tanggal_penilaian?->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
                            required>
                    </div>
                    <div class="col-md-6">
                        <label for="judul_tugas" class="form-label fw-semibold">Judul Tugas</label>
                        <input type="text" name="judul_tugas" id="judul_tugas" class="form-control"
                            value="{{ old('judul_tugas') }}"
                            placeholder="Contoh: Tugas Bab 1" maxlength="255" required>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered mb-0" id="nilaiTable">
                        <thead>
                            <tr>
                                <th width="60">No</th>
                                <th>NISN</th>
                                <th>Nama Siswa</th>
                                <th width="180">Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($siswa as $item)
                            @php
                            $siswaItem = $item->siswa;
                            @endphp
                            <tr data-siswa-id="{{ $siswaItem?->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $siswaItem?->nisn ?? '-' }}</td>
                                <td>{{ $siswaItem?->nama ?? '-' }}</td>
                                <td>
                                    <input type="number" name="nilai[{{ $siswaItem?->id }}]"
                                        value="{{ old('nilai.' . $siswaItem?->id) }}"
                                        class="form-control nilai-input" min="0" max="100" step="0.01"
                                        placeholder="0-100">
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    Belum ada siswa di kelas ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <a href="{{ route('wali-kelas.kelas-mengajar') }}" class="btn btn-secondary">Kembali</a>
                    <a href="{{ route('wali-kelas.detail-nilai', $jadwal->id) }}" class="btn btn-outline-secondary">
                        Lihat Detail
                    </a>
                    @if ($siswa->isNotEmpty())
                    <button type="submit" class="btn btn-primary">Simpan Semua Nilai</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection