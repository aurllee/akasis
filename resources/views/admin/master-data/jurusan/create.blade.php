@extends('layouts.app')

@section('title', 'Tambah Jurusan')

@section('content')

<style>

    body {
        font-family: 'Poppins', sans-serif;
    }
    
    .jurusan-page {
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

    .form-group {
        margin-bottom: 20px;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 600;
        color: #334155;
    }

    .required {
        color: #dc2626;
    }

    .form-control {
        width: 100%;
        min-height: 42px;
        padding: 10px 12px;
        border: 1px solid #d8dee9;
        border-radius: 8px;
        background: #ffffff;
        color: #1e293b;
        font-size: 14px;
        outline: none;
        box-sizing: border-box;
        transition: 0.2s ease;
    }

    .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
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
        border: 1px solid #2563eb;
    }

    .btn-save:hover {
        background: #1d4ed8;
        border-color: #1d4ed8;
        color: #ffffff;
    }

    @media (max-width: 768px) {
        .jurusan-page {
            padding: 16px 0;
        }

        .page-title {
            font-size: 22px;
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

<div class="jurusan-page">

<div class="page-header">
    <h1 class="page-title">Tambah Jurusan</h1>
    <p class="page-subtitle">
        Tambahkan data jurusan baru ke dalam master data.
    </p>
</div>

@if ($errors->any())
    <div class="alert-custom">
        <strong>Terjadi kesalahan pada data.</strong>

        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-card">

    <div class="form-card-header">
        <h2 class="form-card-title">Informasi Jurusan</h2>
    </div>

    <div class="form-card-body">

        <form action="{{ route('jurusan.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="kode_jurusan" class="form-label">
                    Kode Jurusan <span class="required">*</span>
                </label>

                <input
                    type="text"
                    id="kode_jurusan"
                    name="kode_jurusan"
                    class="form-control"
                    value="{{ old('kode_jurusan') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label for="nama_jurusan" class="form-label">
                    Nama Jurusan <span class="required">*</span>
                </label>

                <input
                    type="text"
                    id="nama_jurusan"
                    name="nama_jurusan"
                    class="form-control"
                    value="{{ old('nama_jurusan') }}"
                    required
                >
            </div>

            <div class="form-actions">
                <a
                    href="{{ route('jurusan.index') }}"
                    class="btn btn-back"
                >
                    Kembali
                </a>

                <button
                    type="submit"
                    class="btn btn-save"
                >
                    Simpan
                </button>
            </div>

        </form>

    </div>

</div>

</div>

@endsection
