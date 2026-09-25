@extends('layouts.app')

@section('title', 'Tambah Calon Siswa')

@section('content')

<style>
    body {
        font-family: 'Poppins', sans-serif;
    }

    .spmb-create-page {
        color: #1e293b;
    }

    .page-header {
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

    .required {
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

    textarea.form-control {
        min-height: auto;
        resize: vertical;
    }

    .file-input {
        padding: 7px 10px;
    }

    .document-item {
        background: #f8fafc;
        border: 1px solid #edf1f6;
        border-radius: 10px;
        padding: 16px;
        height: 100%;
        transition: border-color 0.2s ease;
    }

    .document-item:hover {
        border-color: #dbeafe;
    }

    .document-label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        color: #334155;
        margin-bottom: 8px;
    }

    .document-help {
        display: block;
        margin-top: 7px;
        font-size: 12px;
        color: #94a3b8;
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

    .btn-cancel,
    .btn-save {
        border-radius: 8px;
        padding: 9px 18px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-cancel {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
    }

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

    @media (max-width: 768px) {
        .page-title {
            font-size: 21px;
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

<div class="container-fluid py-4 spmb-create-page">

    <div class="page-header">
        <div>
            <h4 class="page-title">Tambah Calon Siswa</h4>
            <p class="page-subtitle">
                Masukkan data calon siswa dan dokumen daftar ulang.
            </p>
        </div>
    </div>

    <div id="form-error-alert" class="alert-custom alert-danger-custom" style="display: none;">
        <div class="alert-title">
            Terdapat kesalahan:
        </div>

        <ul id="form-error-list"></ul>
    </div>

    <form
        id="spmb-create-form"
        action="{{ route('admin.spmb.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf

        <div class="form-card">
            <div class="form-card-header">
                <h5 class="form-card-title">Data Pribadi</h5>
            </div>

            <div class="form-card-body">
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">
                            Nama Lengkap
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            name="nama_lengkap"
                            class="form-control"
                            value="{{ old('nama_lengkap') }}"
                            required
                        >
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">
                            NIK
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            name="nik"
                            maxlength="16"
                            class="form-control"
                            value="{{ old('nik') }}"
                            required
                        >
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">
                            NISN
                        </label>

                        <input
                            type="text"
                            name="nisn"
                            maxlength="10"
                            class="form-control"
                            value="{{ old('nisn') }}"
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
                            <option value="">Pilih</option>

                            <option
                                value="laki-laki"
                                @selected(old('jenis_kelamin') === 'laki-laki')
                            >
                                Laki-laki
                            </option>

                            <option
                                value="perempuan"
                                @selected(old('jenis_kelamin') === 'perempuan')
                            >
                                Perempuan
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">
                            Tempat Lahir
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            name="tempat_lahir"
                            class="form-control"
                            value="{{ old('tempat_lahir') }}"
                            required
                        >
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">
                            Tanggal Lahir
                            <span class="required">*</span>
                        </label>

                        <input
                            type="date"
                            name="tanggal_lahir"
                            class="form-control"
                            value="{{ old('tanggal_lahir') }}"
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
                        >{{ old('alamat') }}</textarea>
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
                            value="{{ old('asal_sekolah') }}"
                            required
                        >
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">
                            Tahun Lulus
                        </label>

                        <input
                            type="number"
                            name="tahun_lulus"
                            class="form-control"
                            value="{{ old('tahun_lulus') }}"
                        >
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">
                            No. KK
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            name="no_kk"
                            maxlength="16"
                            class="form-control"
                            value="{{ old('no_kk') }}"
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
                            <option value="">Pilih Jurusan</option>

                            @foreach($jurusan as $item)
                                <option
                                    value="{{ $item->id }}"
                                    @selected(old('jurusan_id') == $item->id)
                                >
                                    {{ $item->kode_jurusan }} - {{ $item->nama_jurusan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">
                            Jalur Pendaftaran
                            <span class="required">*</span>
                        </label>

                        <select
                            name="jalur_pendaftaran"
                            class="form-select"
                            required
                        >
                            <option value="">Pilih Jalur</option>

                            <option
                                value="Domisili"
                                @selected(old('jalur_pendaftaran') === 'Domisili')
                            >
                                Domisili
                            </option>

                            <option
                                value="Prestasi"
                                @selected(old('jalur_pendaftaran') === 'Prestasi')
                            >
                                Prestasi
                            </option>

                            <option
                                value="Afirmasi"
                                @selected(old('jalur_pendaftaran') === 'Afirmasi')
                            >
                                Afirmasi
                            </option>

                            <option
                                value="Mutasi"
                                @selected(old('jalur_pendaftaran') === 'Mutasi')
                            >
                                Mutasi
                            </option>
                        </select>
                    </div>

                    <div class="col-md-3">
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
                                @selected(old('status_penerimaan', 'diterima') === 'diterima')
                            >
                                Diterima
                            </option>

                            <option
                                value="tidak_diterima"
                                @selected(old('status_penerimaan') === 'tidak_diterima')
                            >
                                Tidak Diterima
                            </option>
                        </select>
                    </div>

                </div>
            </div>
        </div>

        <div class="form-card">
            <div class="form-card-header">
                <h5 class="form-card-title">Data Orang Tua</h5>
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
                            value="{{ old('nama_ayah') }}"
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
                            value="{{ old('nama_ibu') }}"
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
                            value="{{ old('no_hp_ortu') }}"
                            required
                        >
                    </div>

                </div>
            </div>
        </div>

        <div class="form-card">
            <div class="form-card-header">
                <h5 class="form-card-title">Dokumen Daftar Ulang</h5>
            </div>

            <div class="form-card-body">
                <div class="row g-3">

                    @php
                        $dokumen = [
                            'skl_ijazah' => 'SKL / Ijazah',
                            'rapor' => 'Rapor',
                            'kk' => 'Kartu Keluarga',
                            'akta_kelahiran' => 'Akta Kelahiran',
                            'surat_kesehatan' => 'Surat Kesehatan',
                            'surat_pernyataan_orang_tua' => 'Surat Pernyataan Orang Tua',
                            'bukti_penerimaan' => 'Bukti Penerimaan Tahap',
                        ];
                    @endphp

                    @foreach($dokumen as $key => $label)
                        <div class="col-md-6">
                            <div class="document-item">

                                <label class="document-label">
                                    {{ $label }}
                                </label>

                                <input
                                    type="file"
                                    name="dokumen[{{ $key }}]"
                                    class="form-control file-input"
                                    accept=".pdf,.jpg,.jpeg,.png"
                                >

                                <small class="document-help">
                                    PDF/JPG/PNG, maksimal 2 MB.
                                </small>

                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

        <div class="form-card form-actions-card">
            <div class="form-card-body">
                <div class="form-actions">

                    <a
                        href="{{ route('admin.spmb.index') }}"
                        class="btn-cancel"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="btn-save"
                    >
                        Simpan Calon Siswa
                    </button>

                </div>
            </div>
        </div>

    </form>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('spmb-create-form');
        const errorAlert = document.getElementById('form-error-alert');
        const errorList = document.getElementById('form-error-list');

        if (!form) {
            return;
        }

        form.addEventListener('submit', async function (event) {
            event.preventDefault();

            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.textContent = 'Menyimpan...';
            }

            try {
                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                if (response.redirected) {
                    window.location.href = response.url;
                    return;
                }

                if (!response.ok) {
                    const payload = await response.json().catch(() => ({}));
                    const errors = payload.errors || {};
                    const list = [];

                    Object.values(errors).forEach((messages) => {
                        if (Array.isArray(messages)) {
                            messages.forEach((message) => list.push(message));
                        }
                    });

                    errorList.innerHTML = list.length
                        ? list.map((message) => '<li>' + message + '</li>').join('')
                        : '<li>Terjadi kesalahan saat mengirim data.</li>';

                    errorAlert.style.display = 'block';
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    return;
                }

                if (response.ok) {
                    window.location.href = '{{ route('admin.spmb.index') }}';
                }
            } catch (error) {
                errorList.innerHTML = '<li>Terjadi kesalahan jaringan. Silakan coba lagi.</li>';
                errorAlert.style.display = 'block';
                window.scrollTo({ top: 0, behavior: 'smooth' });
            } finally {
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.textContent = 'Simpan Calon Siswa';
                }
            }
        });
    });
</script>

@endsection