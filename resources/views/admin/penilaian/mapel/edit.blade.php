@extends('layouts.app')

@section('title', 'Edit Penilaian')

@push('styles')
<style>
    .academic-container {
        font-family: 'Poppins', sans-serif;
        color: #1f2937;
        width: 100%;
        padding: 0;
    }

    .academic-card {
        width: 100%;
        padding: 24px;
        background: #fff;
        border: 1px solid #e4eaf2;
        border-radius: 12px;
        box-shadow: 0 6px 18px rgba(30, 64, 102, 0.05);
        margin-bottom: 24px;
    }

    .academic-header {
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f1f5f9;
    }

    .academic-header h1 {
        font-size: 24px;
        font-weight: 600;
        color: #1e293b;
        margin: 0 0 4px 0;
    }

    .academic-header p {
        font-size: 14px;
        color: #6b7280;
        margin: 0;
    }

    .btn-back-link {
        color: #64748b;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 12px;
        transition: color 0.2s;
    }

    .btn-back-link:hover {
        color: #2563eb;
    }

    .form-group-custom {
        margin-bottom: 18px;
    }

    .form-group-custom label {
        font-size: 14px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 7px;
        display: block;
    }

    .form-group-custom .form-control,
    .form-group-custom .form-select {
        width: 100%;
        min-height: 42px;
        padding: 10px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 7px;
        background-color: #ffffff;
        font-size: 14px;
        color: #1e293b;
        outline: none;
        transition: all 0.2s;
    }

    .form-group-custom .form-control:focus,
    .form-group-custom .form-select:focus {
        border-color: #2449a4;
        box-shadow: 0 0 0 3px rgba(36, 73, 164, 0.12);
    }

    .score-item {
        padding: 16px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        margin-bottom: 14px;
        background: #ffffff;
    }

    .score-item-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 10px;
    }

    .score-title {
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .score-meta {
        margin-top: 3px;
        font-size: 12px;
        color: #64748b;
    }

    .score-input {
        font-size: 16px !important;
        font-weight: 600;
    }

    .academic-card .form-control::placeholder {
        color: #94a3b8;
        font-size: 13px;
        font-weight: 400;
        opacity: 1;
    }

    .empty-box {
        padding: 18px;
        text-align: center;
        border: 1px dashed #cbd5e1;
        border-radius: 8px;
        color: #64748b;
        font-size: 13px;
        background: #f8fafc;
    }

    .btn-action-primary {
        background-color: #2449a4 !important;
        color: #ffffff !important;
        border: 1px solid #2449a4 !important;
        padding: 10px 15px;
        border-radius: 7px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
        cursor: pointer;
    }

    .btn-action-primary:hover {
        background-color: #1d3f8c !important;
        border-color: #1d3f8c !important;
        color: #ffffff !important;
    }

    .btn-action-secondary {
        background-color: #fff;
        color: #2449a4;
        border: 1px solid #94a3b8;
        padding: 10px 15px;
        border-radius: 7px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }

    .btn-action-secondary:hover {
        background-color: #eff6ff;
        color: #1d3f8c;
        border-color: #2449a4;
    }

    @media (max-width: 576px) {
        .academic-card {
            padding: 20px;
        }

        .score-item-header {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
<div class="academic-container">
    <div class="academic-card">

        <a href="{{ route('admin.penilaian.mapel.mapel', [
                'kelasId' => $kelas->id,
                'mapelId' => $mataPelajaran->id
            ]) }}" class="btn-back-link">
            <i class="bi bi-arrow-left"></i>
            Kembali ke Penilaian
        </a>

        <div class="academic-header">
            <h1>
                {{ $bulkEdit ? 'Edit Semua Nilai' : 'Edit Penilaian' }}
            </h1>

            <p>
                {{ $kelas->tingkat }}
                {{ $kelas->nama_kelas }}
                —
                {{ $mataPelajaran->nama_mapel }}

                @if($bulkEdit)
                — {{ $targetSiswa->nama }}
                @endif
            </p>
        </div>

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4"
            role="alert">

            <div class="fw-bold mb-1">
                Terjadi kesalahan input:
            </div>

            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>

            <button type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close">
            </button>
        </div>
        @endif

        @if($bulkEdit)

        <form method="POST"
            action="{{ route('admin.penilaian.mapel.update', [
                        'kelasId' => $kelas->id,
                        'mapelId' => $mataPelajaran->id,
                        'id' => $targetSiswa->id
                    ]) }}">

            @csrf
            @method('PUT')

            <input type="hidden"
                name="bulk"
                value="1">

            <input type="hidden"
                name="jenis_nilai"
                value="{{ $jenisNilai }}">

            <input type="hidden"
                name="return_to"
                value="{{ old('return_to', request('return_to')) }}">

            @if($penilaian->isEmpty())

            <div class="empty-box">
                Belum ada penilaian
                {{ $jenisNilai }}
                yang dibuat pada kelas dan mata pelajaran ini.
            </div>

            @else

            @foreach($penilaian as $score)

            @php
            $hasValue = $score->id !== null;
            @endphp

            <div class="score-item">

                <div class="score-item-header">

                    <div>
                        <p class="score-title">
                            {{ $score->judul_tugas ?: 'Penilaian ' . ($loop->iteration) }}
                        </p>

                        <div class="score-meta">
                            Tanggal:
                            {{ $score->tanggal_penilaian?->format('d-m-Y') ?? '-' }}
                        </div>
                    </div>

                </div>

                @if($hasValue)

                <input type="number"
                    name="scores[{{ $score->id }}]"
                    id="score_{{ $score->id }}"
                    class="form-control score-input"
                    min="0"
                    max="100"
                    step="0.01"
                    value="{{ old('scores.' . $score->id, $score->nilai) }}"
                    placeholder="Masukkan nilai 0 - 100">

                @error('scores.' . $score->id)
                <small class="text-danger mt-1 d-block">
                    {{ $message }}
                </small>
                @enderror

                @else

                <input type="number"
                    name="new_scores[{{ $score->key }}]"
                    id="new_score_{{ $score->key }}"
                    class="form-control score-input"
                    min="0"
                    max="100"
                    step="0.01"
                    value="{{ old('new_scores.' . $score->key) }}"
                    placeholder="Kosongkan jika belum ada nilai">

                @error('new_scores.' . $score->key)
                <small class="text-danger mt-1 d-block">
                    {{ $message }}
                </small>
                @enderror

                @endif

            </div>

            @endforeach

            @endif

            <div class="d-flex gap-2 justify-content-end pt-3 border-top mt-3">

                <a href="{{ request('return_to') ?: route('admin.penilaian.mapel.mapel', [
                            'kelasId' => $kelas->id,
                            'mapelId' => $mataPelajaran->id
                        ]) }}"
                    class="btn-action-secondary">
                    Batal
                </a>

                @if(!$penilaian->isEmpty())

                <button type="submit"
                    class="btn-action-primary">
                    <i class="bi bi-check2"></i>
                    Simpan Semua Nilai
                </button>

                @endif

            </div>

        </form>

        @else

        <form method="POST"
            action="{{ route('admin.penilaian.mapel.update', [
                        'kelasId' => $kelas->id,
                        'mapelId' => $mataPelajaran->id,
                        'id' => $penilaian->id
                    ]) }}">

            @csrf
            @method('PUT')

            <input type="hidden"
                name="return_to"
                value="{{ old('return_to', request('return_to')) }}">

            <div class="form-group-custom">

                <label for="jadwal_pelajaran_id">
                    Guru / Jadwal
                    <span class="text-danger">*</span>
                </label>

                <select name="jadwal_pelajaran_id"
                    id="jadwal_pelajaran_id"
                    class="form-select"
                    required>

                    @foreach($jadwal as $j)

                    <option value="{{ $j->id }}"
                        @selected(
                        old( 'jadwal_pelajaran_id' ,
                        $penilaian->jadwal_pelajaran_id
                        ) == $j->id
                        )>

                        {{ $j->guru?->nama ?? '-' }}

                        @if($j->hari)
                        ({{ $j->hari }})
                        @endif

                    </option>

                    @endforeach

                </select>

                @error('jadwal_pelajaran_id')
                <small class="text-danger mt-1 d-block">
                    {{ $message }}
                </small>
                @enderror

            </div>

            <div class="form-group-custom">

                <label for="siswa_id">
                    Siswa
                    <span class="text-danger">*</span>
                </label>

                <select name="siswa_id"
                    id="siswa_id"
                    class="form-select"
                    required>

                    @foreach($siswa as $item)

                    <option value="{{ $item->id }}"
                        @selected(
                        old( 'siswa_id' ,
                        $penilaian->siswa_id
                        ) == $item->id
                        )>

                        {{ $item->nama }}
                        —
                        NIS:
                        {{ $item->nis ?? '-' }}

                    </option>

                    @endforeach

                </select>

                @error('siswa_id')
                <small class="text-danger mt-1 d-block">
                    {{ $message }}
                </small>
                @enderror

            </div>

            <div class="form-group-custom">

                <label for="jenis_nilai">
                    Jenis Nilai
                    <span class="text-danger">*</span>
                </label>

                <select name="jenis_nilai"
                    id="jenis_nilai"
                    class="form-select"
                    required>

                    <option value="harian"
                        @selected(
                        old( 'jenis_nilai' ,
                        $penilaian->jenis_nilai
                        ) === 'harian'
                        )>
                        Harian
                    </option>

                    <option value="ujian"
                        @selected(
                        old( 'jenis_nilai' ,
                        $penilaian->jenis_nilai
                        ) === 'ujian'
                        )>
                        Ujian
                    </option>

                </select>

                @error('jenis_nilai')
                <small class="text-danger mt-1 d-block">
                    {{ $message }}
                </small>
                @enderror

            </div>

            <div class="form-group-custom">

                <label for="judul_tugas">
                    Judul Tugas
                </label>

                <input type="text"
                    name="judul_tugas"
                    id="judul_tugas"
                    class="form-control"
                    maxlength="255"
                    value="{{ old('judul_tugas', $penilaian->judul_tugas) }}"
                    placeholder="Contoh: Tugas 1">

                @error('judul_tugas')
                <small class="text-danger mt-1 d-block">
                    {{ $message }}
                </small>
                @enderror

            </div>

            <div class="form-group-custom">

                <label for="tanggal_penilaian">
                    Tanggal Penilaian
                    <span class="text-danger">*</span>
                </label>

                <input type="date"
                    name="tanggal_penilaian"
                    id="tanggal_penilaian"
                    class="form-control"
                    value="{{ old(
                                'tanggal_penilaian',
                                $penilaian->tanggal_penilaian?->format('Y-m-d')
                            ) }}"
                    required>

                @error('tanggal_penilaian')
                <small class="text-danger mt-1 d-block">
                    {{ $message }}
                </small>
                @enderror

            </div>

            <div class="form-group-custom mb-4">

                <label for="nilai">
                    Nilai
                    <span class="text-danger">*</span>
                </label>

                <input type="number"
                    name="nilai"
                    id="nilai"
                    class="form-control"
                    min="0"
                    max="100"
                    step="0.01"
                    value="{{ old('nilai', $penilaian->nilai) }}"
                    placeholder="Masukkan nilai 0 - 100"
                    required>

                @error('nilai')
                <small class="text-danger mt-1 d-block">
                    {{ $message }}
                </small>
                @enderror

            </div>

            <div class="d-flex gap-2 justify-content-end pt-3 border-top">

                <a href="{{ route('admin.penilaian.mapel.mapel', [
                            'kelasId' => $kelas->id,
                            'mapelId' => $mataPelajaran->id
                        ]) }}"
                    class="btn-action-secondary">
                    Batal
                </a>

                <button type="submit"
                    class="btn-action-primary">
                    <i class="bi bi-check2"></i>
                    Simpan Perubahan
                </button>

            </div>

        </form>

        @endif

    </div>
</div>
@endsection