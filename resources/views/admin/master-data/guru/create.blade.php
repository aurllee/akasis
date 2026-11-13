@extends('layouts.app')

@section('title', 'Tambah Guru')

@section('content')

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .guru-page {
            padding: 24px 0;
        }

        .page-header {
            margin-bottom: 24px;
        }

        .page-title {
            margin: 0;
            font-size: 26px;
            font-weight: 700;
            color: #1e293b;
        }

        .page-subtitle {
            margin: 6px 0 0;
            color: #64748b;
            font-size: 14px;
        }

        .form-card {
            background: #ffffff;
            border: 1px solid #e8edf5;
            border-radius: 12px;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05);
            overflow: hidden;
        }

        .form-card-header {
            padding: 20px 24px;
            border-bottom: 1px solid #e8edf5;
            background: #ffffff;
        }

        .form-card-title {
            margin: 0;
            font-size: 17px;
            font-weight: 600;
            color: #1e293b;
        }

        .form-card-body {
            padding: 24px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-label {
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #334155;
        }

        .required {
            color: #dc2626;
        }

        .form-control,
        .form-select {
            width: 100%;
            min-height: 42px;
            padding: 10px 12px;
            border: 1px solid #d8dee9;
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
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        .form-help {
            margin-top: 6px;
            font-size: 12px;
            color: #94a3b8;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid #e8edf5;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 40px;
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: 0.2s ease;
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

        .btn-save {
            background: #2563eb;
            color: #ffffff;
        }

        .btn-save:hover {
            background: #1d4ed8;
            color: #ffffff;
        }

        .alert-custom {
            margin-bottom: 20px;
            padding: 13px 16px;
            border-radius: 8px;
            border: 1px solid #fecaca;
            background: #fef2f2;
            color: #b91c1c;
            font-size: 14px;
        }

        .alert-custom ul {
            margin: 6px 0 0;
            padding-left: 20px;
        }

        @media (max-width: 768px) {
            .guru-page {
                padding: 16px 0;
            }

            .page-title {
                font-size: 22px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .form-group.full {
                grid-column: auto;
            }

            .form-card-body {
                padding: 18px;
            }

            .form-card-header {
                padding: 18px;
            }

            .form-actions {
                flex-direction: column-reverse;
            }

            .btn {
                width: 100%;
            }
        }
    </style>

    <div class="guru-page">

        <div class="page-header">
            <h1 class="page-title">Tambah Guru</h1>
            <p class="page-subtitle">
                Tambahkan data guru baru ke dalam master data.
            </p>
        </div>

        @include('admin.master-data.partials.errors')

        <div class="form-card">
            <div class="form-card-header">
                <h2 class="form-card-title">Informasi Guru</h2>
            </div>

            <div class="form-card-body">
                <form action="{{ route('guru.store') }}" method="POST">
                    @csrf

                    <div class="form-grid">

                        <div class="form-group">
                            <label class="form-label">
                                Kode Guru <span class="required">*</span>
                            </label>
                            <input type="text" name="kode_guru" class="form-control" value="{{ old('kode_guru') }}"
                                required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                NIP <span class="required">*</span>
                            </label>
                            <input type="text" name="nip" class="form-control" value="{{ old('nip') }}" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Nama <span class="required">*</span>
                            </label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Jenis Kelamin <span class="required">*</span>
                            </label>
                            <select name="jk" class="form-select" required>
                                <option value="">Pilih jenis kelamin</option>
                                <option value="Laki-laki" @selected(old('jk') === 'Laki-laki')>
                                    Laki-laki
                                </option>
                                <option value="Perempuan" @selected(old('jk') === 'Perempuan')>
                                    Perempuan
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Tanggal Lahir <span class="required">*</span>
                            </label>
                            <input type="date" name="tgl_lahir" class="form-control" value="{{ old('tgl_lahir') }}"
                                required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Agama <span class="required">*</span>
                            </label>
                            <select name="agama" class="form-select" required>
                                <option value="">Pilih agama</option>
                                @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu'] as $agama)
                                    <option value="{{ $agama }}" @selected(old('agama') === $agama)>
                                        {{ $agama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                No. HP <span class="required">*</span>
                            </label>
                            <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Email <span class="required">*</span>
                            </label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                TMT <span class="required">*</span>
                            </label>
                            <input type="date" name="tmt" class="form-control" value="{{ old('tmt') }}" required>
                        </div>

                        <div class="form-group full">
                            <label class="form-label">
                                Alamat <span class="required">*</span>
                            </label>
                            <textarea name="alamat" class="form-control" required>{{ old('alamat') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Status Kepegawaian <span class="required">*</span>
                            </label>
                            <select name="status_kepegawaian" class="form-select" required>
                                <option value="">Pilih status kepegawaian</option>
                                @foreach(['PNS', 'PPPK', 'Honorer', 'Guru_tetap', 'Guru_tidak_tetap'] as $status)
                                    <option value="{{ $status }}" @selected(old('status_kepegawaian') === $status)>
                                        {{ str_replace('_', ' ', $status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Jabatan <span class="required">*</span>
                            </label>
                            <select name="jabatan" class="form-select" required>
                                <option value="">Pilih jabatan</option>
                                @foreach(['Guru', 'Kepala_sekolah', 'Waka_sekolah'] as $jabatan)
                                    <option value="{{ $jabatan }}" @selected(old('jabatan') === $jabatan)>
                                        {{ str_replace('_', ' ', $jabatan) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group full">
                            <label class="form-label">
                                Mata Pelajaran <span class="required">*</span>
                            </label>
                            <select name="mata_pelajaran_id" class="form-select" required>
                                <option value="">Pilih mata pelajaran</option>
                                @foreach($mataPelajaran as $mapel)
                                    <option value="{{ $mapel->id }}" @selected(old('mata_pelajaran_id') == $mapel->id)>
                                        {{ $mapel->nama_mapel }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="form-actions">
                        <a href="{{ route('guru.index') }}" class="btn btn-back">
                            Kembali
                        </a>

                        <button type="submit" class="btn btn-save">
                            Simpan Data Guru
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>

@endsection