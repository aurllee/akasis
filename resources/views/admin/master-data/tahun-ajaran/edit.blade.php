@extends('layouts.app')

@section('title', 'Edit Tahun Ajaran')

@push('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #212529;
            background: #f5f6fa;
        }

        .room-form {
            color: #1f2937;
        }

        .room-panel {
            background: #fff;
            border: 1px solid #e4eaf2;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(30, 64, 102, 0.05);
            padding: 24px;
        }

        .room-form h1 {
            color: #1e293b;
            font-size: 24px;
            font-weight: 600;
            margin: 0 0 6px;
        }

        .room-subtitle {
            margin: 0 0 20px;
            color: #64748b;
        }

        .room-errors {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            color: #b91c1c;
            margin: 0 0 18px;
            padding: 12px 16px;
        }

        .room-errors ul {
            margin: 0;
            padding-left: 18px;
        }

        .room-field {
            margin-bottom: 16px;
        }

        .room-field label {
            color: #334155;
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 7px;
        }

        .room-field input[type="text"],
        .room-field select {
            background: #fff;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            box-sizing: border-box;
            color: #1e293b;
            font: inherit;
            padding: 10px 12px;
            width: 100%;
        }

        .room-field input:focus,
        .room-field select:focus {
            border-color: #2449a4;
            box-shadow: 0 0 0 3px rgba(36, 73, 164, 0.2);
        }


        .checkbox-label {
            display: inline-flex !important;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .checkbox-input {
            width: 18px !important;
            height: 18px !important;
            border: 2px solid #cbd5e1;
            border-radius: 4px;
            cursor: pointer;
            accent-color: #2449a4;
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
    </style>
@endpush

@section('content')
    <div class="room-form">
        <div class="room-panel">
            <h1>Edit Tahun Ajaran</h1>
            <p class="room-subtitle">Ubah informasi tahun ajaran di bawah ini.</p>

            @if ($errors->any())
                <div class="room-errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('tahun-ajaran.update', $tahunAjaran->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="room-field">
                    <label for="tahun_ajaran">Tahun Ajaran</label>
                    <input type="text" id="tahun_ajaran" name="tahun_ajaran"
                        value="{{ old('tahun_ajaran', $tahunAjaran->tahun_ajaran) }}" maxlength="9" required>
                </div>

                <div class="room-field">
                    <label for="semester">Semester</label>
                    <select id="semester" name="semester" required>
                        <option value="Ganjil" @selected(old('semester', $tahunAjaran->semester) === 'Ganjil')>Ganjil</option>
                        <option value="Genap" @selected(old('semester', $tahunAjaran->semester) === 'Genap')>Genap</option>
                    </select>
                </div>

                <div class="room-field">
                    <label class="checkbox-label">
                        <input type="checkbox" name="status" value="1" class="checkbox-input" @checked(old('status', $tahunAjaran->status))>
                        <span>Aktif</span>
                    </label>
                </div>

                <div class="academic-actions">
                    <button type="submit" class="academic-save">Simpan</button>
                    <a href="{{ route('tahun-ajaran.index') }}" class="btn btn-secondary"
                        style="text-decoration: none; margin-left: 10px;">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection