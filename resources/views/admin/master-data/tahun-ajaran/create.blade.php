@extends('layouts.app')

@section('title', 'Tambah Tahun Ajaran')

@push('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #212529;
            background: #f5f6fa;
        }

        .academic-form {
            color: #1f2937;
        }

        .academic-panel {
            background: #fff;
            border: 1px solid #e4eaf2;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(30, 64, 102, 0.05);
            padding: 24px;
        }

        .academic-form h1 {
            color: #1e293b;
            font-size: 24px;
            font-weight: 600;
            margin: 0 0 6px;
        }

        .academic-subtitle {
            margin: 0 0 20px;
            color: #64748b;
        }

        .academic-errors {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            color: #b91c1c;
            margin: 0 0 18px;
            padding: 12px 16px;
        }

        .academic-errors ul {
            margin: 0;
            padding-left: 18px;
        }

        .academic-field {
            margin-bottom: 16px;
        }

        .academic-field label {
            color: #334155;
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 7px;
        }

        .academic-field input,
        .academic-field select {
            background: #fff;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            box-sizing: border-box;
            color: #1e293b;
            font: inherit;
            padding: 10px 12px;
            width: 100%;
        }

        .academic-field input:focus,
        .academic-field select:focus {
            border-color: #2449a4;
            box-shadow: 0 0 0 3px rgba(36, 73, 164, 0.12);
            outline: none;
        }

        .academic-actions {
            display: flex;
            gap: 10px;
            margin-top: 22px;
        }

        .academic-actions button,
        .academic-actions a {
            align-items: center;
            border: 1px solid transparent;
            border-radius: 7px;
            cursor: pointer;
            display: inline-flex;
            font-size: 14px;
            font-weight: 600;
            padding: 10px 15px;
            text-decoration: none;
            transition: background-color .2s ease, border-color .2s ease, color .2s ease;
        }

        .academic-save {
            background: #2449a4;
            border-color: #2449a4;
            color: #fff;
        }

        .academic-save:hover {
            background: #1e3a8a;
        }

        .academic-back {
            background: #fff;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            color: #475569;
            display: inline-flex;
            padding: 10px 15px;
            text-decoration: none;
        }

        .academic-back:hover {
            background: #f8fafc;
            border-color: #94a3b8;
            color: #1e293b;
        }

        .custom-checkbox {
            width: 18px;
            height: 18px;
            border: 2px solid #cbd5e1;
            border-radius: 4px;
            cursor: pointer;
            accent-color: #2449a4;
        }
    </style>

@endpush

@section('content')

    <div class="academic-form">
        <div class="academic-panel">
            <h1>Tambah Tahun Ajaran</h1>
            <p class="academic-subtitle">Form untuk menambahkan tahun ajaran baru.</p>

            @if($errors->any())
                <div class="academic-errors">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('tahun-ajaran.store') }}" method="POST">
                @csrf
                <div class="academic-field">
                    <label for="tahun_ajaran">Tahun Ajaran</label>
                    <input id="tahun_ajaran" name="tahun_ajaran" value="{{ old('tahun_ajaran') }}" maxlength="9"
                        placeholder="2026/2027" required>
                </div>

                <div class="academic-field">
                    <label for="semester">Semester</label>
                    <select id="semester" name="semester" required>
                        <option value="">Pilih semester</option>
                        <option value="Ganjil" @selected(old('semester') === 'Ganjil')>Ganjil</option>
                        <option value="Genap" @selected(old('semester') === 'Genap')>Genap</option>
                    </select>
                </div>

                <div class="form-check my-3">
                    <input type="checkbox" id="is_active" name="is_active" class="custom-checkbox">
                    <label class="form-check-label" for="is_active">
                        Aktif
                    </label>
                </div>

                <div class="academic-actions">
                    <button class="academic-save" type="submit">
                        Simpan
                    </button>
                    <a class="btn btn-secondary" href="{{ route('tahun-ajaran.index') }}">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection