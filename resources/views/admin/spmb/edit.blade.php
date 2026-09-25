@extends('layouts.app')

@section('title', 'Edit Calon Siswa')

@push('styles')
<style>
    body {
        font-family: 'Poppins', sans-serif;
    }

    .spmb-edit-page {
        color: #1e293b;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 24px;
    }

    .page-title {
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 5px;
    }

    .page-subtitle {
        color: #64748b;
        font-size: 14px;
        margin: 0;
    }

    .header-actions {
        display: flex;
        gap: 10px;
    }

    .btn-back,
    .btn-cancel,
    .btn-save {
        border-radius: 8px;
        padding: 9px 18px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-back,
    .btn-cancel {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
    }

    .btn-back:hover,
    .btn-cancel:hover {
        background: #e2e8f0;
        color: #334155;
    }

    .btn-save {
        background: #2563eb;
        color: #fff;
        border: 1px solid #2563eb;
        cursor: pointer;
    }

    .btn-save:hover {
        background: #1d4ed8;
        border-color: #1d4ed8;
        color: #fff;
    }

    .alert-custom {
        border: 1px solid;
        border-radius: 10px;
        padding: 15px 18px;
        margin-bottom: 22px;
        font-size: 14px;
    }

    .alert-danger-custom {
        background: #fef2f2;
        border-color: #fecaca;
        color: #991b1b;
    }

    .alert-title {
        font-weight: 600;
        margin-bottom: 8px;
    }

    .alert-custom ul {
        padding-left: 20px;
        margin-bottom: 0;
    }

    .form-card {
        background: #fff;
        border: 1px solid #e8edf5;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
        overflow: hidden;
        margin-bottom: 22px;
    }

    .form-card-header {
        padding: 17px 22px;
        background: #fff;
        border-bottom: 1px solid #e8edf5;
    }

    .form-card-title {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
    }

    .form-card-body {
        padding: 22px;
    }

    .form-label {
        color: #334155;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 7px;
    }

    .form-label .required {
        color: #dc2626;
    }

    .form-control,
    .form-select {
        min-height: 42px;
        border: 1px solid #dbe2ea;
        border-radius: 8px;
        color: #1e293b;
        font-size: 14px;
        padding: 9px 12px;
        transition: all 0.2s ease;
        box-shadow: none;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #93c5fd;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.08);
    }

    .form-control[readonly] {
        background: #f8fafc;
        color: #64748b;
        cursor: not-allowed;
    }

    textarea.form-control {
        min-height: auto;
        resize: vertical;
    }

    .form-help {
        display: block;
        margin-top: 6px;
        font-size: 12px;
        color: #94a3b8;
    }

    .info-box {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        background: #eff6ff;
        border: 1px solid #dbeafe;
        border-radius: 10px;
        padding: 15px 17px;
        color: #1e40af;
        font-size: 14px;
        line-height: 1.6;
    }

    .info-box-title {
        font-weight: 600;
        margin-bottom: 3px;
    }

    .info-box-text {
        color: #3b82f6;
    }

    .form-actions-card {
        margin-bottom: 40px;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .header-actions {
            width: 100%;
        }

        .btn-back {
            width: 100%;
            text-align: center;
        }

        .form-card-header,
        .form-card-body {
            padding: 17px;
        }

        .form-actions {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .btn-cancel,
        .btn-save {
            width: 100%;
            text-align: center;
        }
    }
</style>
@endpush

@section('content')

<div class="container-fluid py-4 spmb-edit-page">

    <div class="page-header">
        <div>
            <h4 class="page-title">Edit Calon Siswa</h4>
            <p class="page-subtitle">
                {{ $calonSiswa->no_pendaftaran }}
            </p>
        </div>

        <div class="header-actions">
            <a
                href="{{ route('admin.spmb.show', $calonSiswa->id) }}"
                class="btn-back"
            >
                Kembali
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="alert-custom alert-danger-custom">
            <div class="alert-title">
                Terjadi kesalahan!
            </div>

            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('admin.spmb.update', $calonSiswa->id) }}"
        method="POST"
    >
        @csrf
        @method('PUT')

        <div class="form-card">
            <div class="form-card-header">
                <h5 class="form-card-title">Data Pribadi</h5>
            </div>

            <div class="form-card-body">
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">
                            No. Pendaftaran
                        </label>

                        <input
                            type="text"
                            name="no_pendaftaran"
                            class="form-control"
                            value="{{ old('no_pendaftaran', $calonSiswa->no_pendaftaran) }}"
                            readonly
                        >

                        <small class="form-help">
                            Nomor pendaftaran tidak dapat diubah.
                        </small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            Nama Lengkap
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            name="nama_lengkap"
                            class="form-control"
                            value="{{ old('nama_lengkap', $calonSiswa->nama_lengkap) }}"
                            required
                        >
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">
                            NIK
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            name="nik"
                            class="form-control"
                            value="{{ old('nik', $calonSiswa->nik) }}"
                            required
                        >
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">
                            NISN
                        </label>

                        <input
                            type="text"
                            name="nisn"
                            class="form-control"
                            value="{{ old('nisn', $calonSiswa->nisn) }}"
                        >
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">
                            Jenis Kelamin
                            <span class="required">*</span>
                        </label>

                        <select
                            name="jenis_kelamin"
                            class="form-select"
                            required
                        >
                            <option value="">
                                -- Pilih Jenis Kelamin --
                            </option>

                            <option
                                value="laki-laki"
                                @selected(strtolower((string) old('jenis_kelamin', $calonSiswa->jenis_kelamin)) === 'laki-laki')
                            >
                                Laki-laki
                            </option>

                            <option
                                value="perempuan"
                                @selected(strtolower((string) old('jenis_kelamin', $calonSiswa->jenis_kelamin)) === 'perempuan')
                            >
                                Perempuan
                            </option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            Tempat Lahir
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            name="tempat_lahir"
                            class="form-control"
                            value="{{ old('tempat_lahir', $calonSiswa->tempat_lahir) }}"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            Tanggal Lahir
                            <span class="required">*</span>
                        </label>

                        <input
                            type="date"
                            name="tanggal_lahir"
                            class="form-control"
                            value="{{ old(
                                'tanggal_lahir',
                                $calonSiswa->tanggal_lahir
                                    ? $calonSiswa->tanggal_lahir->format('Y-m-d')
                                    : ''
                            ) }}"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            Asal Sekolah
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            name="asal_sekolah"
                            class="form-control"
                            value="{{ old('asal_sekolah', $calonSiswa->asal_sekolah) }}"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            No. KK
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            name="no_kk"
                            class="form-control"
                            value="{{ old('no_kk', $calonSiswa->no_kk) }}"
                            required
                        >
                    </div>

                    <div class="col-12">
                        <label class="form-label">
                            Alamat
                            <span class="required">*</span>
                        </label>

                        <textarea
                            name="alamat"
                            class="form-control"
                            rows="3"
                            required
                        >{{ old('alamat', $calonSiswa->alamat) }}</textarea>
                    </div>

                </div>
            </div>
        </div>

        <div class="form-card">
            <div class="form-card-header">
                <h5 class="form-card-title">Data Orang Tua / Wali</h5>
            </div>

            <div class="form-card-body">
                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">
                            Nama Ayah
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            name="nama_ayah"
                            class="form-control"
                            value="{{ old('nama_ayah', $calonSiswa->nama_ayah) }}"
                            required
                        >
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">
                            Nama Ibu
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            name="nama_ibu"
                            class="form-control"
                            value="{{ old('nama_ibu', $calonSiswa->nama_ibu) }}"
                            required
                        >
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">
                            No. HP Orang Tua
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            name="no_hp_ortu"
                            class="form-control"
                            value="{{ old('no_hp_ortu', $calonSiswa->no_hp_ortu) }}"
                            required
                        >
                    </div>

                </div>
            </div>
        </div>

        <div class="form-card">
            <div class="form-card-header">
                <h5 class="form-card-title">Data SPMB</h5>
            </div>

            <div class="form-card-body">
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">
                            Jurusan
                            <span class="required">*</span>
                        </label>

                        <select
                            name="jurusan_id"
                            class="form-select"
                            required
                        >
                            <option value="">
                                -- Pilih Jurusan --
                            </option>

                            @foreach($jurusan as $item)
                                <option
                                    value="{{ $item->id }}"
                                    @selected(old('jurusan_id', $calonSiswa->jurusan_id) == $item->id)
                                >
                                    {{ $item->nama_jurusan }}
                                    ({{ $item->kode_jurusan }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            Jalur Pendaftaran
                            <span class="required">*</span>
                        </label>

                        <select
                            name="jalur_pendaftaran"
                            class="form-select"
                            required
                        >
                            <option value="">
                                -- Pilih Jalur --
                            </option>

                            <option
                                value="domisili"
                                @selected(strtolower((string) old('jalur_pendaftaran', $calonSiswa->jalur_pendaftaran)) === 'domisili')
                            >
                                Domisili
                            </option>

                            <option
                                value="afirmasi"
                                @selected(strtolower((string) old('jalur_pendaftaran', $calonSiswa->jalur_pendaftaran)) === 'afirmasi')
                            >
                                Afirmasi
                            </option>

                            <option
                                value="prestasi"
                                @selected(strtolower((string) old('jalur_pendaftaran', $calonSiswa->jalur_pendaftaran)) === 'prestasi')
                            >
                                Prestasi
                            </option>

                            <option
                                value="mutasi"
                                @selected(strtolower((string) old('jalur_pendaftaran', $calonSiswa->jalur_pendaftaran)) === 'mutasi')
                            >
                                Mutasi
                            </option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            Status Penerimaan
                            <span class="required">*</span>
                        </label>

                        <select
                            name="status_penerimaan"
                            class="form-select"
                            required
                        >
                            <option
                                value="diterima"
                                @selected(old('status_penerimaan', $calonSiswa->status_penerimaan) === 'diterima')
                            >
                                Diterima
                            </option>

                            <option
                                value="tidak_diterima"
                                @selected(old('status_penerimaan', $calonSiswa->status_penerimaan) === 'tidak_diterima')
                            >
                                Tidak Diterima
                            </option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            Status Daftar Ulang
                            <span class="required">*</span>
                        </label>

                        <select
                            name="status_daftar_ulang"
                            class="form-select"
                            required
                        >
                            <option
                                value="belum_daftar_ulang"
                                @selected(old('status_daftar_ulang', $calonSiswa->status_daftar_ulang) === 'belum_daftar_ulang')
                            >
                                Belum Daftar Ulang
                            </option>

                            <option
                                value="menunggu_verifikasi"
                                @selected(old('status_daftar_ulang', $calonSiswa->status_daftar_ulang) === 'menunggu_verifikasi')
                            >
                                Menunggu Verifikasi
                            </option>

                            <option
                                value="revisi"
                                @selected(old('status_daftar_ulang', $calonSiswa->status_daftar_ulang) === 'revisi')
                            >
                                Revisi
                            </option>

                            <option
                                value="terverifikasi"
                                @selected(old('status_daftar_ulang', $calonSiswa->status_daftar_ulang) === 'terverifikasi')
                            >
                                Terverifikasi
                            </option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            Tanggal Daftar Ulang
                        </label>

                        <input
                            type="date"
                            name="tanggal_daftar_ulang"
                            class="form-control"
                            value="{{ old('tanggal_daftar_ulang') !== null
                                ? old('tanggal_daftar_ulang')
                                : ($calonSiswa->tanggal_daftar_ulang
                                    ? $calonSiswa->tanggal_daftar_ulang->format('Y-m-d')
                                    : '')
                            }}"
                        >
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            Catatan Revisi
                        </label>

                        <textarea
                            name="catatan_revisi"
                            class="form-control"
                            rows="3"
                            placeholder="Masukkan catatan revisi jika diperlukan"
                        >{{ old('catatan_revisi', $calonSiswa->catatan_revisi) }}</textarea>
                    </div>

                </div>
            </div>
        </div>

        <div class="form-card">
            <div class="form-card-header">
                <h5 class="form-card-title">
                    Dokumen Daftar Ulang
                </h5>
            </div>

            <div class="form-card-body">
                <div class="info-box">
                    <div>
                        <div class="info-box-title">
                            Informasi
                        </div>

                        <div class="info-box-text">
                            Dokumen daftar ulang tidak diubah melalui halaman ini.
                            Proses upload dan verifikasi dokumen dilakukan melalui
                            halaman detail calon siswa.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-card form-actions-card">
            <div class="form-card-body">
                <div class="form-actions">

                    <a
                        href="{{ route('admin.spmb.show', $calonSiswa->id) }}"
                        class="btn-cancel"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="btn-save"
                    >
                        Simpan Perubahan
                    </button>

                </div>
            </div>
        </div>

    </form>

</div>

@endsection