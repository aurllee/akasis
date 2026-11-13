@extends('layouts.app')

@section('title', 'Tambah Mata Pelajaran')

@section('content')

<style>

body {
    font-family: 'Poppins', sans-serif;
}

    .mapel-page {
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
        max-width: 900px;
    }

    .form-group {
        margin-bottom: 20px;
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

    .form-control {
        width: 100%;
        padding: 11px 13px;
        border: 1px solid #dbe2ea;
        border-radius: 8px;
        background: #ffffff;
        color: #1e293b;
        font-size: 14px;
        outline: none;
        transition: 0.2s ease;
        box-sizing: border-box;
    }

    .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.08);
    }

    .color-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .color-input {
        width: 58px;
        height: 42px;
        padding: 3px;
        border: 1px solid #dbe2ea;
        border-radius: 8px;
        background: #ffffff;
        cursor: pointer;
    }

    .color-code {
        font-size: 14px;
        color: #64748b;
        font-family: monospace;
        background: #f8fafc;
        border: 1px solid #e8edf5;
        padding: 9px 12px;
        border-radius: 7px;
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
        min-width: 100px;
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
        .mapel-page {
            padding: 16px;
        }

        .form-card {
            padding: 20px;
        }

        .page-title {
            font-size: 21px;
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

<div class="mapel-page">

<div class="page-header">
    <h1 class="page-title">Tambah Mata Pelajaran</h1>
    <p class="page-subtitle">
        Tambahkan data mata pelajaran baru ke dalam sistem.
    </p>
</div>

<div class="form-card">

    @include('admin.master-data.partials.errors')

    <form action="{{ route('mata_pelajaran.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label">
                Kode Mapel <span class="required">*</span>
            </label>

            <input
                type="text"
                name="kode_mapel"
                class="form-control"
                value="{{ old('kode_mapel') }}"
                placeholder="Masukkan kode mata pelajaran"
                required
            >
        </div>

        <div class="form-group">
            <label class="form-label">
                Nama Mapel <span class="required">*</span>
            </label>

            <input
                type="text"
                name="nama_mapel"
                class="form-control"
                value="{{ old('nama_mapel') }}"
                placeholder="Masukkan nama mata pelajaran"
                required
            >
        </div>

        <div class="form-group">
            <label class="form-label">
                Warna <span class="required">*</span>
            </label>

            <div class="color-wrapper">
                <input
                    type="color"
                    name="warna"
                    id="warna"
                    class="color-input"
                    value="{{ old('warna', '#d3d3d3') }}"
                    required
                >

                <span class="color-code" id="colorCode">
                    {{ old('warna', '#d3d3d3') }}
                </span>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-save">
                Simpan
            </button>

            <a href="{{ route('mata_pelajaran.index') }}" class="btn btn-back">
                Kembali
            </a>
        </div>

    </form>

</div>

</div>

<script>
    const colorInput = document.getElementById('warna');
    const colorCode = document.getElementById('colorCode');

    colorInput.addEventListener('input', function () {
        colorCode.textContent = this.value.toUpperCase();
    });
</script>

@endsection
