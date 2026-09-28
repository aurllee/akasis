@extends('layouts.app')

@section('title', 'Edit Pembagian Kelas')

@push('styles')
    <style>
        .academic-form {
            color: #1f2937;
        }

        .academic-panel {
            background: #fff;
            border: 1px solid #e4eaf2;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(30, 64, 102, 0.05);
            padding: 24px;
            width: 100%;
        }

        .academic-form h1 {
            color: #1e293b;
            font-size: 24px;
            font-weight: 600;
            margin: 0 0 6px;
        }

        .academic-subtitle {
            color: #6b7280;
            margin: 0 0 20px;
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

        .academic-info {
            background: #f8fafc;
            border: 1px solid #e4eaf2;
            border-radius: 8px;
            display: grid;
            gap: 8px 20px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            margin-bottom: 20px;
            padding: 16px;
        }

        .academic-info p {
            margin: 0;
        }

        .academic-info strong {
            color: #475569;
            display: block;
            font-size: 12px;
            margin-bottom: 4px;
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

        .academic-field select:focus {
            border-color: #2449a4;
            box-shadow: 0 0 0 3px rgba(36, 73, 164, 0.12);
            outline: none;
        }

        .academic-actions {
            border-top: 1px solid #eef2f7;
            display: flex;
            gap: 10px;
            margin-top: 22px;
            padding-top: 22px;
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
            background: #1d3f8c;
        }

        .academic-back {
            background: #fff;
            border: 1px solid #94a3b8;
            border-radius: 7px;
            color: #2449a4;
            display: inline-flex;
            padding: 10px 15px;
            text-decoration: none;
        }

        .academic-back:hover {
            background: #eff6ff;
            border-color: #2449a4;
            color: #1d3f8c;
        }

        @media (max-width: 600px) {
            .academic-panel {
                padding: 20px;
            }

            .academic-info {
                grid-template-columns: 1fr;
            }

            .academic-actions {
                flex-direction: column;
            }

            .academic-actions button,
            .academic-actions a {
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="academic-form">
        <div class="academic-panel">
            <h1>Edit Pembagian Kelas</h1>
            <p class="academic-subtitle">Perbarui kelas untuk siswa yang dipilih.</p>

            @if ($errors->any())
                <div class="academic-errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="academic-info">
                <p>
                    <strong>NISN</strong>
                    {{ $pembagian->siswa?->nisn ?? '-' }}
                </p>
                <p>
                    <strong>Nama Siswa</strong>
                    {{ $pembagian->siswa?->nama ?? 'Data siswa tidak tersedia' }}
                </p>
            </div>

            <form action="{{ route('pembagian_kelas.update', $pembagian->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="academic-field">
                    <label for="kelas_id">Kelas</label>
                    <select name="kelas_id" id="kelas_id" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($kelas as $k)
                            <option value="{{ $k->id }}" @selected(old('kelas_id', $pembagian->kelas_id) == $k->id)>
                                {{ $k->tingkat }} {{ $k->nama_kelas }}
                                - {{ $k->jurusan?->nama_jurusan ?? 'Jurusan belum dipilih' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="academic-actions">
                    <button class="academic-save" type="submit">Simpan Perubahan</button>
                    <a class="academic-back" href="{{ route('pembagian_kelas.index') }}">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection