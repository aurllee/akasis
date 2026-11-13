@extends('layouts.app')

@section('title', 'Tambah Kelas')

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
        }

        .academic-form h1 {
            color: #1e293b;
            font-size: 24px;
            font-weight: 600;
            margin: 0 0 6px;
        }

        .academic-subtitle {
            margin: 0 0 20px;
            color: #6b7280;
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
            background: #1d3f8c;
        }
    </style>
@endpush

@section('content')
    <div class="academic-form">
        <div class="academic-panel">
            <h1>Tambah Kelas</h1>
            <p class="academic-subtitle">Form untuk menambahkan data kelas baru.</p>

            @if($errors->any())
                <div class="academic-errors">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('kelas.store') }}" method="POST">
                @csrf

                <div class="academic-field">
                    <label for="tingkat">Tingkat</label>
                    <select id="tingkat" name="tingkat" required>
                        @foreach(['X','XI','XII'] as $tingkat)
                            <option value="{{ $tingkat }}" @selected(old('tingkat') === $tingkat)>{{ $tingkat }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="academic-field">
                    <label for="jurusan_id">Jurusan</label>
                    <select id="jurusan_id" name="jurusan_id" required>
                        <option value="">Pilih jurusan</option>
                        @foreach($jurusans as $jurusan)
                            <option value="{{ $jurusan->id }}" @selected(old('jurusan_id') == $jurusan->id)>
                                {{ $jurusan->kode_jurusan }} - {{ $jurusan->nama_jurusan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="academic-field">
                    <label for="nama_kelas">Nama Kelas</label>
                    <select id="nama_kelas" name="nama_kelas" required>
                        @foreach(['A','B','C','D','E','F','G','H'] as $namaKelas)
                            <option value="{{ $namaKelas }}" @selected(old('nama_kelas') === $namaKelas)>{{ $namaKelas }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="academic-field">
                    <label for="wali_kelas_id">Wali Kelas</label>
                    <select id="wali_kelas_id" name="wali_kelas_id">
                        <option value="">Pilih wali kelas</option>
                        @foreach($gurus as $guru)
                            <option value="{{ $guru->id }}" @selected(old('wali_kelas_id') == $guru->id)>
                                {{ $guru->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="academic-field">
                    <label for="tahun_ajaran_id">Tahun Ajaran</label>
                    <select id="tahun_ajaran_id" name="tahun_ajaran_id">
                        <option value="">Pilih tahun ajaran</option>
                        @foreach($tahunAjarans as $tahun)
                            <option value="{{ $tahun->id }}" @selected(old('tahun_ajaran_id') == $tahun->id)>
                                {{ $tahun->tahun_ajaran }} - {{ $tahun->semester }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="academic-actions">
                    <button class="academic-save" type="submit">
                        Simpan
                    </button>
                    <a class="btn btn-secondary" href="{{ route('kelas.index') }}">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection