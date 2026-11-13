@extends('layouts.app')

@section('title', 'Edit Ruangan')

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

        .room-field input,
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
            box-shadow: 0 0 0 3px rgba(36, 73, 164, 0.12);
            outline: none;
        }

        .room-actions {
            display: flex;
            gap: 10px;
            margin-top: 22px;
        }

        .room-actions button,
        .room-actions a {
            align-items: center;
            border: 1px solid transparent;
            border-radius: 7px;
            cursor: pointer;
            display: inline-flex;
            font-size: 14px;
            font-weight: 600;
            padding: 10px 15px;
            text-decoration: none;
        }

        .room-save {
            background: #2449a4;
            border-color: #2449a4;
            color: #fff;
        }

        .room-save:hover {
            background: #1e3a8a;
        }

        .room-back {
            background: #fff;
            border-color: #cbd5e1;
            color: #475569;
        }

        .room-back:hover {
            background: #f8fafc;
            border-color: #94a3b8;
            color: #1e293b;
        }
    </style>
@endpush

@section('content')
    <div class="room-form">
        <div class="room-panel">
            <h1>Edit Ruangan</h1>
            <p class="room-subtitle">Perbarui data ruangan yang dipilih.</p>

            @if($errors->any())
                <div class="room-errors">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('ruangan.update', $ruangan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="room-field">
                    <label for="kode_ruang">Kode Ruang</label>
                    <input id="kode_ruang" name="kode_ruang" value="{{ old('kode_ruang', $ruangan->kode_ruang) }}" required>
                </div>

                <div class="room-field">
                    <label for="nama_ruang">Nama Ruang</label>
                    <input id="nama_ruang" name="nama_ruang" value="{{ old('nama_ruang', $ruangan->nama_ruang) }}" required>
                </div>

                <div class="room-field">
                    <label for="kapasitas">Kapasitas</label>
                    <input id="kapasitas" type="number" name="kapasitas" value="{{ old('kapasitas', $ruangan->kapasitas) }}"
                        min="1" required>
                </div>

                <div class="room-field">
                    <label for="status">Status</label>
                    <select id="status" name="status" required>
                        <option value="1" @selected(old('status', $ruangan->status) == 1)>Aktif</option>
                        <option value="0" @selected(old('status', $ruangan->status) == 0)>Tidak Aktif</option>
                    </select>
                </div>

                <div class="room-actions">
                    <button class="room-save" type="submit">

                        Simpan Perubahan
                    </button>
                    <a class="btn btn-secondary" href="{{ route('ruangan.index') }}">

                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection