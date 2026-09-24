@extends('layouts.app')

@section('title', 'Edit Penilaian PJBL')

@push('styles')
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Poppins', sans-serif;
        }

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
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .btn-action-primary {
            background: #2563eb;
            color: #ffffff;
            border: none;
            padding: 9px 18px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background 0.2s;
            cursor: pointer;
        }

        .btn-action-primary:hover {
            background: #1d4ed8;
            color: #ffffff;
        }

        .btn-action-secondary {
            background: #f1f5f9;
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
            background: #e2e8f0;
            color: #1e293b;
        }
    </style>
@endpush

@section('content')
    <div class="academic-container">
        <a href="{{ route('admin.penilaian.pjbl.penilaian', ['kelasId' => $kelas->id, 'pjblId' => $pjbl->id]) }}" class="btn-back-link">
            <i class="bi bi-arrow-left"></i> Kembali ke Penilaian
        </a>

        <div class="academic-card">
            <div class="academic-header">
                <h1>Edit Penilaian PJBL</h1>
                <p>Perbarui data penilaian PJBL untuk siswa terkait.</p>
            </div>

            <form action="{{ route('admin.penilaian.pjbl.update', [
                'kelasId' => $kelas->id,
                'pjblId' => $pjbl->id,
                'id' => $penilaian->id,
            ]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group-custom">
                    <label for="siswa_id">Siswa <span class="text-danger">*</span></label>
                    <select name="siswa_id" id="siswa_id" class="form-select" required>
                        @foreach($siswa as $item)
                            <option value="{{ $item->id }}" {{ old('siswa_id', $penilaian->siswa_id) == $item->id ? 'selected' : '' }}>
                                {{ $item->nama }}
                                @if(!empty($item->nis)) ({{ $item->nis }}) @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group-custom">
                    <label for="pjbl_id">PJBL <span class="text-danger">*</span></label>
                    <select name="pjbl_id" id="pjbl_id" class="form-select" required>
                        <option value="{{ $pjbl->id }}" selected>
                            PJBL #{{ $pjbl->id }}
                            @if($pjbl->kelas)
                                - {{ $pjbl->kelas->tingkat }} {{ $pjbl->kelas->nama_kelas }}
                            @endif
                        </option>
                    </select>
                </div>

                <div class="form-group-custom">
                    <label for="pjbl_penguji_id">ID Penguji <span class="text-danger">*</span></label>
                    <input type="number" name="pjbl_penguji_id" id="pjbl_penguji_id" class="form-control"
                        value="{{ old('pjbl_penguji_id', $penilaian->pjbl_penguji_id) }}" placeholder="Masukkan ID Penguji"
                        required>
                </div>

                <div class="form-group-custom mb-4">
                    <label for="nilai">Nilai <span class="text-danger">*</span></label>
                    <input type="number" name="nilai" id="nilai" class="form-control" min="0" max="100" step="0.01"
                        value="{{ old('nilai', $penilaian->nilai) }}" placeholder="Masukkan nilai 0 - 100" required>
                </div>

                <div class="d-flex gap-2 justify-content-end pt-3 border-top">
                    <a href="{{ route('admin.penilaian.pjbl.penilaian', ['kelasId' => $kelas->id, 'pjblId' => $pjbl->id]) }}"
                        class="btn-action-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn-action-primary">
                        <i class="bi bi-check-lg"></i> Perbarui Penilaian
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection