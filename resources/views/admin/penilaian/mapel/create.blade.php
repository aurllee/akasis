@extends('layouts.app')

@section('title', 'Tambah Penilaian')

@push('styles')
    <style>
        .academic-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            margin-bottom: 24px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .academic-header {
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f1f5f9;
        }

        .academic-header h1 {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 4px 0;
        }

        .academic-header p {
            font-size: 13px;
            color: #64748b;
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
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
            display: block;
        }

        .form-group-custom .form-control,
        .form-group-custom .form-select {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background-color: #ffffff;
            font-size: 14px;
            color: #1e293b;
            outline: none;
            transition: all 0.2s;
        }

        .form-group-custom .form-control:focus,
        .form-group-custom .form-select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        .btn-action-primary {
            background-color: #2563eb;
            color: #ffffff;
            border: 1px solid #2563eb;
            padding: 9px 18px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-action-primary:hover {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
            color: #ffffff;
        }

        .btn-action-secondary {
            background-color: #ffffff;
            color: #475569;
            border: 1px solid #cbd5e1;
            padding: 9px 18px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .btn-action-secondary:hover {
            background-color: #f8fafc;
            color: #1e293b;
            border-color: #94a3b8;
        }
    </style>
@endpush

@section('content')
    <div class="academic-container">
        <div class="academic-card">

            <a href="{{ route('admin.penilaian.mapel.mapel', ['kelasId' => $kelas->id, 'mapelId' => $mataPelajaran->id]) }}"
                class="btn-back-link">
                <i class="bi bi-arrow-left"></i> Kembali ke Penilaian
            </a>

            <div class="academic-header">
                <h1>Tambah Penilaian</h1>
                <p>{{ $kelas->tingkat }} {{ $kelas->nama_kelas }} — {{ $mataPelajaran->nama_mapel }}</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <div class="fw-bold mb-1">Terjadi kesalahan input:</div>
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form method="POST"
                action="{{ route('admin.penilaian.mapel.store', ['kelasId' => $kelas->id, 'mapelId' => $mataPelajaran->id]) }}">
                @csrf

                <div class="form-group-custom">
                    <label for="jadwal_pelajaran_id">Guru / Jadwal <span class="text-danger">*</span></label>
                    <select name="jadwal_pelajaran_id" id="jadwal_pelajaran_id" class="form-select" required>
                        <option value="">-- Pilih Guru / Jadwal --</option>
                        @foreach($jadwal as $j)
                            <option value="{{ $j->id }}" @selected(old('jadwal_pelajaran_id') == $j->id)>
                                {{ $j->guru?->nama ?? '-' }} @if($j->hari) ({{ $j->hari }}) @endif
                            </option>
                        @endforeach
                    </select>
                    @error('jadwal_pelajaran_id')
                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group-custom">
                    <label for="siswa_id">Siswa <span class="text-danger">*</span></label>
                    <select name="siswa_id" id="siswa_id" class="form-select" required>
                        <option value="">-- Pilih Siswa --</option>
                        @foreach($siswa as $item)
                            <option value="{{ $item->id }}" @selected(old('siswa_id') == $item->id)>
                                {{ $item->nama }} — NIS: {{ $item->nis ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                    @error('siswa_id')
                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group-custom">
                    <label for="jenis_nilai">Jenis Nilai <span class="text-danger">*</span></label>
                    <select name="jenis_nilai" id="jenis_nilai" class="form-select" required>
                        <option value="">-- Pilih Jenis Nilai --</option>
                        <option value="harian" @selected(old('jenis_nilai') === 'harian')>Harian</option>
                        <option value="ujian" @selected(old('jenis_nilai') === 'ujian')>Ujian</option>
                    </select>
                    @error('jenis_nilai')
                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group-custom">
                    <label for="tanggal_penilaian">Tanggal Penilaian <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_penilaian" id="tanggal_penilaian" class="form-control"
                        value="{{ old('tanggal_penilaian', date('Y-m-d')) }}" required>
                    @error('tanggal_penilaian')
                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group-custom mb-4">
                    <label for="nilai">Nilai <span class="text-danger">*</span></label>
                    <input type="number" name="nilai" id="nilai" class="form-control" min="0" max="100" step="0.01"
                        value="{{ old('nilai') }}" placeholder="Masukkan nilai 0 - 100" required>
                    @error('nilai')
                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                    @enderror
                </div>

                <div class="d-flex gap-2 justify-content-end pt-3 border-top">
                    <a href="{{ route('admin.penilaian.mapel.mapel', ['kelasId' => $kelas->id, 'mapelId' => $mataPelajaran->id]) }}"
                        class="btn btn-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn-action-primary">
                        Simpan Penilaian
                    </button>
                </div>

            </form>

        </div>
    </div>
@endsection