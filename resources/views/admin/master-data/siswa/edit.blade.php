@extends('layouts.app')

@section('title', 'Edit Siswa')

@section('content')

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .siswa-page {
            padding: 24px;
        }

        .page-header {
            margin-bottom: 24px;
        }

        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 6px;
        }

        .page-subtitle {
            font-size: 14px;
            color: #64748b;
            margin: 0;
        }

        .form-card {
            background: #ffffff;
            border: 1px solid #e8edf5;
            border-radius: 12px;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05);
            padding: 28px;
            max-width: 1000px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .form-group {
            margin: 0;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        .required {
            color: #dc2626;
        }

        .form-control,
        .form-select {
            width: 100%;
            min-height: 43px;
            padding: 10px 13px;
            border: 1px solid #dbe2ea;
            border-radius: 8px;
            background: #ffffff;
            color: #1e293b;
            font-size: 14px;
            outline: none;
            transition: 0.2s ease;
            box-sizing: border-box;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.08);
        }

        textarea.form-control {
            min-height: 110px;
            resize: vertical;
        }

        .form-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 28px;
            padding-top: 22px;
            border-top: 1px solid #eef2f7;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 130px;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .btn-save {
            background: #2563eb;
            color: #ffffff;
        }

        .btn-save:hover {
            background: #1d4ed8;
            color: #ffffff;
        }

        .btn-back {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .btn-back:hover {
            background: #e2e8f0;
            color: #334155;
        }

        @media (max-width: 768px) {
            .siswa-page {
                padding: 16px;
            }

            .form-card {
                padding: 20px;
            }

            .page-title {
                font-size: 21px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 18px;
            }

            .form-group.full-width {
                grid-column: auto;
            }

            .form-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .btn {
                width: 100%;
            }
        }
    </style>

    <div class="siswa-page">

        <div class="page-header">
            <h1 class="page-title">Edit Siswa</h1>
            <p class="page-subtitle">
                Perbarui informasi data siswa yang tersimpan dalam sistem.
            </p>
        </div>

        <div class="form-card">

            @include('admin.master-data.partials.errors')

            <form action="{{ route('siswa.update', $siswa->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-grid">

                    <div class="form-group">
                        <label class="form-label">
                            NIS <span class="required">*</span>
                        </label>

                        <input type="text" name="nis" class="form-control" value="{{ old('nis', $siswa->nis) }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            NISN
                        </label>

                        <input type="text" name="nisn" class="form-control" value="{{ old('nisn', $siswa->nisn) }}">
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">
                            Nama <span class="required">*</span>
                        </label>

                        <input type="text" name="nama" class="form-control" value="{{ old('nama', $siswa->nama) }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Jenis Kelamin <span class="required">*</span>
                        </label>

                        <select name="jk" class="form-select" required>
                            @foreach(['Perempuan', 'Laki-laki'] as $jk)
                                <option value="{{ $jk }}" @selected(old('jk', $siswa->jk) === $jk)>
                                    {{ $jk }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Tempat Lahir <span class="required">*</span>
                        </label>

                        <input type="text" name="tempat_lahir" class="form-control"
                            value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Tanggal Lahir <span class="required">*</span>
                        </label>

                        <input type="date" name="tanggal_lahir" class="form-control"
                            value="{{ old('tanggal_lahir', optional($siswa->tanggal_lahir)->format('Y-m-d')) }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Agama <span class="required">*</span>
                        </label>

                        <select name="agama" class="form-select" required>
                            @foreach(['Islam', 'Kristen', 'Katolik', 'Budha', 'Hindu', 'Konghucu'] as $agama)
                                <option value="{{ $agama }}" @selected(old('agama', $siswa->agama) === $agama)>
                                    {{ $agama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            NIK
                        </label>

                        <input type="text" name="nik" class="form-control" value="{{ old('nik', $siswa->nik) }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            No. KK
                        </label>

                        <input type="text" name="no_kk" class="form-control" value="{{ old('no_kk', $siswa->no_kk) }}">
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">
                            Alamat <span class="required">*</span>
                        </label>

                        <textarea name="alamat" class="form-control" required>{{ old('alamat', $siswa->alamat) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Nama Orang Tua <span class="required">*</span>
                        </label>

                        <input type="text" name="nama_orang_tua" class="form-control"
                            value="{{ old('nama_orang_tua', $siswa->nama_orang_tua) }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            No. HP
                        </label>

                        <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $siswa->no_hp) }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Email
                        </label>

                        <input type="email" name="email" class="form-control" value="{{ old('email', $siswa->email) }}">
                    </div>

                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-save">
                        Simpan Perubahan
                    </button>

                    <a href="{{ route('siswa.index') }}" class="btn btn-back">
                        Kembali
                    </a>
                </div>

            </form>

        </div>

    </div>

@endsection