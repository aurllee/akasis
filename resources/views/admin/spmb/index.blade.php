@extends('layouts.app')

@section('title', 'Data Calon Siswa')

@section('content')

<div class="spmb-page">

    <div class="page-header">

        <div class="page-title">

            <div>
                <h4>Data Calon Siswa</h4>
                <p>Pengelolaan data calon siswa SPMB berdasarkan jurusan.</p>
            </div>

        </div>

        <a href="{{ route('admin.spmb.create') }}" class="btn-add">
            <i class="bi bi-plus-lg"></i>
            <span>Tambah Calon Siswa</span>
        </a>

    </div>

    @if(session('success'))

        <div class="alert-custom alert-success-custom">

            <div class="alert-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>

            <div class="alert-content">
                <strong>Berhasil</strong>
                <span>{{ session('success') }}</span>
            </div>

            <button
                type="button"
                class="alert-close"
                data-bs-dismiss="alert"
            >
                <i class="bi bi-x-lg"></i>
            </button>

        </div>

    @endif

    @if(session('error'))

        <div class="alert-custom alert-danger-custom">

            <div class="alert-icon">
                <i class="bi bi-exclamation-circle-fill"></i>
            </div>

            <div class="alert-content">
                <strong>Terjadi Kesalahan</strong>
                <span>{{ session('error') }}</span>
            </div>

            <button
                type="button"
                class="alert-close"
                data-bs-dismiss="alert"
            >
                <i class="bi bi-x-lg"></i>
            </button>

        </div>

    @endif

    <div class="filter-card">

        <div class="filter-header">

            <div class="filter-title">

                <div class="filter-icon">
                    <i class="bi bi-funnel"></i>
                </div>

                <div>
                    <h5>Filter Data</h5>
                    <span>Cari dan filter data calon siswa</span>
                </div>

            </div>

            <button
                type="button"
                id="resetSpmb"
                class="btn-reset"
            >
                <i class="bi bi-arrow-counterclockwise"></i>
                Reset
            </button>

        </div>

        <div class="filter-body">

            <form
                method="GET"
                action="{{ route('admin.spmb.index') }}"
                id="spmbFilterForm"
            >

                <div class="row g-3">

                    <div class="col-lg-4 col-md-6">

                        <label
                            for="spmbSearch"
                            class="form-label"
                        >
                            Pencarian
                        </label>

                        <div class="input-wrapper">

                            <i class="bi bi-search"></i>

                            <input
                                type="text"
                                name="search"
                                id="spmbSearch"
                                class="form-control custom-input"
                                placeholder="Nama, NISN, NIK, No. Pendaftaran"
                                value="{{ request('search') }}"
                                autocomplete="off"
                            >

                        </div>

                    </div>

                    <div class="col-lg-3 col-md-6">

                        <label
                            for="spmbJurusan"
                            class="form-label"
                        >
                            Jurusan
                        </label>

                        <div class="select-wrapper">

                            <select
                                name="jurusan_id"
                                id="spmbJurusan"
                                class="form-select custom-input"
                            >

                                <option value="">
                                    Semua Jurusan
                                </option>

                                @foreach($jurusan as $item)

                                    <option
                                        value="{{ $item->id }}"
                                        @selected(request('jurusan_id') == $item->id)
                                    >
                                        {{ $item->kode_jurusan }} - {{ $item->nama_jurusan }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                    <div class="col-lg-2 col-md-6">

                        <label
                            for="spmbJalur"
                            class="form-label"
                        >
                            Jalur
                        </label>

                        <div class="select-wrapper">

                            <select
                                name="jalur_pendaftaran"
                                id="spmbJalur"
                                class="form-select custom-input"
                            >

                                <option value="">
                                    Semua
                                </option>

                                @foreach(['Domisili', 'Prestasi', 'Afirmasi', 'Mutasi'] as $jalur)

                                    <option
                                        value="{{ $jalur }}"
                                        @selected(request('jalur_pendaftaran') == $jalur)
                                    >
                                        {{ $jalur }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                    <div class="col-lg-3 col-md-6">

                        <label
                            for="spmbStatus"
                            class="form-label"
                        >
                            Status Daftar Ulang
                        </label>

                        <div class="select-wrapper">

                            <select
                                name="status_daftar_ulang"
                                id="spmbStatus"
                                class="form-select custom-input"
                            >

                                <option value="">
                                    Semua Status
                                </option>

                                <option
                                    value="belum_daftar_ulang"
                                    @selected(request('status_daftar_ulang') == 'belum_daftar_ulang')
                                >
                                    Belum Daftar Ulang
                                </option>

                                <option
                                    value="menunggu_verifikasi"
                                    @selected(request('status_daftar_ulang') == 'menunggu_verifikasi')
                                >
                                    Menunggu Verifikasi
                                </option>

                                <option
                                    value="revisi"
                                    @selected(request('status_daftar_ulang') == 'revisi')
                                >
                                    Revisi
                                </option>

                                <option
                                    value="terverifikasi"
                                    @selected(request('status_daftar_ulang') == 'terverifikasi')
                                >
                                    Terverifikasi
                                </option>

                            </select>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <div class="data-card" id="spmb-search-results">

        <div class="data-card-header">

            <div>

                <h5>Daftar Calon Siswa</h5>

                <span>
                    Data calon siswa yang terdaftar pada sistem SPMB.
                </span>

            </div>

        </div>

        <div class="table-container">

            <div class="table-responsive">

                <table class="custom-table">

                    <thead>

                        <tr>
                            <th width="60">No</th>
                            <th>No. Pendaftaran</th>
                            <th>Nama Calon Siswa</th>
                            <th>NISN</th>
                            <th>Jurusan</th>
                            <th>Jalur</th>
                            <th>Status</th>
                            <th width="155">Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                    @forelse($calonSiswa as $index => $item)

                        <tr>

                            <td>

                                <span class="number-cell">
                                    {{ $calonSiswa->firstItem() + $index }}
                                </span>

                            </td>

                            <td>

                                <span class="registration-number">
                                    {{ $item->no_pendaftaran }}
                                </span>

                            </td>

                            <td>

                                <div class="student-name">

                                    <span class="student-avatar">
                                        {{ strtoupper(substr($item->nama_lengkap, 0, 1)) }}
                                    </span>

                                    <span>
                                        {{ $item->nama_lengkap }}
                                    </span>

                                </div>

                            </td>

                            <td>

                                <span class="nisn-text">
                                    {{ $item->nisn ?? '-' }}
                                </span>

                            </td>

                            <td>

                                @if($item->jurusan)

                                    <div class="jurusan-cell">

                                        <span class="jurusan-code">
                                            {{ $item->jurusan->kode_jurusan }}
                                        </span>

                                        <span class="jurusan-name">
                                            {{ $item->jurusan->nama_jurusan }}
                                        </span>

                                    </div>

                                @else

                                    <span class="empty-text">
                                        Jurusan tidak tersedia
                                    </span>

                                @endif

                            </td>

                            <td>

                                <span class="jalur-badge">
                                    {{ $item->jalur_pendaftaran }}
                                </span>

                            </td>

                            <td>

                                @if($item->status_daftar_ulang === 'terverifikasi')

                                    <span class="status-badge status-verified">
                                        <i class="bi bi-check-circle-fill"></i>
                                        Terverifikasi
                                    </span>

                                @elseif($item->status_daftar_ulang === 'revisi')

                                    <span class="status-badge status-revision">
                                        <i class="bi bi-exclamation-circle-fill"></i>
                                        Revisi
                                    </span>

                                @elseif($item->status_daftar_ulang === 'menunggu_verifikasi')

                                    <span class="status-badge status-waiting">
                                        <i class="bi bi-clock-fill"></i>
                                        Menunggu Verifikasi
                                    </span>

                                @else

                                    <span class="status-badge status-unregistered">
                                        <i class="bi bi-dash-circle-fill"></i>
                                        Belum Daftar Ulang
                                    </span>

                                @endif

                            </td>

                            <td>

                                <div class="action-buttons">

                                    <a
                                        href="{{ route('admin.spmb.show', $item->id) }}"
                                        class="action-btn detail-btn"
                                        title="Lihat Detail"
                                    >
                                        <i class="bi bi-eye-fill"></i>
                                        Detail
                                    </a>

                                    <a
                                        href="{{ route('admin.spmb.edit', $item->id) }}"
                                        class="action-btn edit-btn"
                                        title="Edit Data"
                                    >
                                        <i class="bi bi-pencil-fill"></i>
                                        Edit
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8">

                                <div class="empty-state">

                                    <div class="empty-icon">
                                        <i class="bi bi-inbox"></i>
                                    </div>

                                    <h6>Belum Ada Data</h6>

                                    <p>
                                        Belum ada data calon siswa yang tersedia.
                                    </p>

                                    <a
                                        href="{{ route('admin.spmb.create') }}"
                                        class="empty-action"
                                    >
                                        <i class="bi bi-plus-lg"></i>
                                        Tambah Calon Siswa
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        @if($calonSiswa->hasPages())

            <div class="pagination-container">
                {{ $calonSiswa->links() }}
            </div>

        @endif

    </div>

</div>

@endsection

@push('styles')

<style>

    body {
        font-family: 'Poppins', sans-serif;
    }

    .spmb-page {
        width: 100%;
        padding: 6px 2px 30px;
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
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .page-title h4 {
        margin: 0 0 5px;
        font-size: 23px;
        font-weight: 700;
        color: #172033;
        letter-spacing: -.2px;
    }

    .page-title p {
        margin: 0;
        font-size: 13px;
        color: #718096;
    }

    .btn-add {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 17px;
        border-radius: 9px;
        background: #2563eb;
        color: #fff;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        border: 1px solid #2563eb;
        box-shadow: 0 5px 14px rgba(37, 99, 235, .16);
        transition: .2s ease;
        white-space: nowrap;
    }

    .btn-add:hover {
        background: #1d4ed8;
        border-color: #1d4ed8;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 7px 18px rgba(37, 99, 235, .22);
    }

    .btn-add i {
        font-size: 15px;
    }

    .alert-custom {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 13px 15px;
        border-radius: 10px;
        margin-bottom: 18px;
        border: 1px solid;
    }

    .alert-success-custom {
        background: #f0fdf4;
        border-color: #bbf7d0;
        color: #166534;
    }

    .alert-danger-custom {
        background: #fef2f2;
        border-color: #fecaca;
        color: #991b1b;
    }

    .alert-icon {
        font-size: 18px;
        flex-shrink: 0;
    }

    .alert-content {
        display: flex;
        flex-direction: column;
        gap: 1px;
        flex: 1;
    }

    .alert-content strong {
        font-size: 13px;
        font-weight: 700;
    }

    .alert-content span {
        font-size: 12px;
    }

    .alert-close {
        border: 0;
        background: transparent;
        color: inherit;
        opacity: .65;
        padding: 4px;
        cursor: pointer;
    }

    .alert-close:hover {
        opacity: 1;
    }

    .filter-card {
        background: #fff;
        border: 1px solid #e8edf5;
        border-radius: 12px;
        margin-bottom: 20px;
        overflow: hidden;
        box-shadow: 0 3px 12px rgba(15, 23, 42, .04);
    }

    .filter-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 17px 20px;
        border-bottom: 1px solid #edf1f6;
        background: #fbfcfe;
    }

    .filter-title {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .filter-icon {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eef4ff;
        color: #2563eb;
        font-size: 15px;
    }

    .filter-title h5 {
        margin: 0 0 2px;
        font-size: 14px;
        font-weight: 700;
        color: #263247;
    }

    .filter-title span {
        font-size: 11px;
        color: #8792a5;
    }

    .btn-reset {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 11px;
        border-radius: 7px;
        background: #fff;
        border: 1px solid #dfe5ed;
        color: #64748b;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: .2s ease;
    }

    .btn-reset:hover {
        border-color: #2563eb;
        color: #2563eb;
        background: #f8faff;
    }

    .filter-body {
        padding: 19px 20px 20px;
    }

    .form-label {
        display: block;
        margin-bottom: 7px;
        color: #475569;
        font-size: 12px;
        font-weight: 600;
    }

    .input-wrapper {
        position: relative;
    }

    .input-wrapper > i {
        position: absolute;
        top: 50%;
        left: 13px;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
        z-index: 2;
    }

    .custom-input {
        height: 40px;
        border-radius: 8px !important;
        border: 1px solid #dfe5ed !important;
        color: #334155;
        background-color: #fff;
        font-size: 12px;
        box-shadow: none !important;
        transition: .2s ease;
    }

    .input-wrapper .custom-input {
        padding-left: 37px;
    }

    .custom-input::placeholder {
        color: #a0aabd;
    }

    .custom-input:hover {
        border-color: #c8d2df !important;
    }

    .custom-input:focus {
        border-color: #7aa2ef !important;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .08) !important;
    }

    .select-wrapper select {
        cursor: pointer;
    }

    .data-card {
        background: #fff;
        border: 1px solid #e8edf5;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 3px 12px rgba(15, 23, 42, .04);
        position: relative;
    }

    .data-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 20px;
        border-bottom: 1px solid #edf1f6;
    }

    .data-card-header h5 {
        margin: 0 0 3px;
        font-size: 15px;
        font-weight: 700;
        color: #263247;
    }

    .data-card-header span {
        font-size: 11px;
        color: #8a95a7;
    }

    .table-container {
        width: 100%;
    }

    .custom-table {
        width: 100%;
        min-width: 1050px;
        border-collapse: separate;
        border-spacing: 0;
    }

    .custom-table thead th {
        padding: 13px 14px;
        background: #f8fafc;
        border-bottom: 1px solid #e7ecf3;
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .25px;
        white-space: nowrap;
    }

    .custom-table tbody td {
        padding: 13px 14px;
        border-bottom: 1px solid #edf1f5;
        color: #475569;
        font-size: 12px;
        vertical-align: middle;
    }

    .custom-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .custom-table tbody tr {
        transition: .15s ease;
    }

    .custom-table tbody tr:hover {
        background: #fbfdff;
    }

    .number-cell {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 26px;
        height: 26px;
        padding: 0 6px;
        border-radius: 6px;
        background: #f1f5f9;
        color: #64748b;
        font-size: 11px;
        font-weight: 600;
    }

    .registration-number {
        color: #2563eb;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .student-name {
        display: flex;
        align-items: center;
        gap: 9px;
        min-width: 180px;
    }

    .student-avatar {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #eaf2ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .student-name span:last-child {
        color: #263247;
        font-weight: 600;
    }

    .nisn-text {
        color: #64748b;
        white-space: nowrap;
    }

    .jurusan-cell {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .jurusan-code {
        width: fit-content;
        padding: 3px 7px;
        border-radius: 5px;
        background: #eaf2ff;
        color: #2563eb;
        font-size: 10px;
        font-weight: 700;
    }

    .jurusan-name {
        color: #64748b;
        font-size: 11px;
    }

    .empty-text {
        color: #94a3b8;
        font-size: 11px;
    }

    .jalur-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 9px;
        border-radius: 6px;
        background: #f1f5f9;
        color: #475569;
        font-size: 10px;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 9px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-badge i {
        font-size: 10px;
    }

    .status-verified {
        background: #ecfdf3;
        color: #15803d;
    }

    .status-revision {
        background: #fef2f2;
        color: #dc2626;
    }

    .status-waiting {
        background: #fffbeb;
        color: #b45309;
    }

    .status-unregistered {
        background: #f1f5f9;
        color: #64748b;
    }

    .action-buttons {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        min-width: 58px;
        padding: 6px 9px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 600;
        text-decoration: none;
        transition: .2s ease;
        white-space: nowrap;
    }

    .action-btn i {
        font-size: 10px;
    }

    .detail-btn {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #dbeafe;
    }

    .detail-btn:hover {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .edit-btn {
        background: #fff7ed;
        color: #c2410c;
        border: 1px solid #fed7aa;
    }

    .edit-btn:hover {
        background: #ffedd5;
        color: #9a3412;
    }

    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 300px;
        padding: 35px 20px;
        text-align: center;
    }

    .empty-icon {
        width: 62px;
        height: 62px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 13px;
        background: #f1f5f9;
        color: #94a3b8;
        font-size: 27px;
    }

    .empty-state h6 {
        margin: 0 0 5px;
        color: #475569;
        font-size: 14px;
        font-weight: 700;
    }

    .empty-state p {
        margin: 0 0 15px;
        color: #94a3b8;
        font-size: 12px;
    }

    .empty-action {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 12px;
        border-radius: 7px;
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #dbeafe;
        font-size: 11px;
        font-weight: 600;
        text-decoration: none;
        transition: .2s ease;
    }

    .empty-action:hover {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .pagination-container {
        padding: 15px 20px;
        border-top: 1px solid #edf1f6;
        background: #fbfcfe;
    }

    .pagination-container nav {
        display: flex;
        justify-content: flex-end;
    }

    .pagination-container .pagination {
        margin: 0;
        gap: 4px;
    }

    .pagination-container .page-link {
        min-width: 31px;
        height: 31px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px !important;
        border: 1px solid #e2e8f0;
        color: #64748b;
        background: #fff;
        font-size: 11px;
        box-shadow: none;
    }

    .pagination-container .page-link:hover {
        background: #eff6ff;
        border-color: #bfdbfe;
        color: #2563eb;
    }

    .pagination-container .page-item.active .page-link {
        background: #2563eb;
        border-color: #2563eb;
        color: #fff;
    }

    .pagination-container .page-item.disabled .page-link {
        color: #cbd5e1;
        background: #f8fafc;
    }

    #spmb-search-results.loading {
        opacity: .55;
        pointer-events: none;
        transition: opacity .2s ease;
    }

    @media (max-width: 992px) {

        .page-header {
            align-items: flex-start;
        }

        .page-title h4 {
            font-size: 21px;
        }

        .filter-header,
        .data-card-header {
            padding: 16px;
        }

        .filter-body {
            padding: 17px 16px;
        }

    }

    @media (max-width: 768px) {

        .spmb-page {
            padding-top: 2px;
        }

        .page-header {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-add {
            width: 100%;
        }

        .page-title {
            align-items: flex-start;
        }

        .page-title h4 {
            font-size: 19px;
        }

        .page-title p {
            font-size: 12px;
            line-height: 1.5;
        }

        .filter-header {
            align-items: flex-start;
            gap: 12px;
        }

        .filter-title span {
            display: block;
            max-width: 220px;
            line-height: 1.4;
        }

        .data-card-header {
            align-items: flex-start;
        }

        .pagination-container {
            padding: 13px 15px;
        }

        .pagination-container nav {
            justify-content: center;
        }

    }

    @media (max-width: 500px) {

        .filter-header {
            flex-direction: column;
        }

        .btn-reset {
            width: 100%;
            justify-content: center;
        }

        .alert-custom {
            align-items: flex-start;
        }

        .action-buttons {
            flex-direction: column;
            align-items: stretch;
        }

        .action-btn {
            width: 65px;
        }

    }

</style>

@endpush

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('spmbFilterForm');
    const results = document.getElementById('spmb-search-results');
    const searchInput = document.getElementById('spmbSearch');
    const resetButton = document.getElementById('resetSpmb');

    if (!form || !results) {
        return;
    }

    let searchTimeout;

    function loadData(url = null) {

        let targetUrl = url;

        if (!targetUrl) {

            const formData = new FormData(form);
            const params = new URLSearchParams(formData);

            targetUrl =
                "{{ route('admin.spmb.index') }}" +
                "?" +
                params.toString();

        }

        results.classList.add('loading');

        fetch(targetUrl, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            }
        })
        .then(response => {

            if (!response.ok) {
                throw new Error('Gagal memuat data.');
            }

            return response.text();

        })
        .then(html => {

            const parser = new DOMParser();

            const doc =
                parser.parseFromString(
                    html,
                    'text/html'
                );

            const newResults =
                doc.querySelector(
                    '#spmb-search-results'
                );

            if (newResults) {

                results.innerHTML =
                    newResults.innerHTML;

                history.pushState(
                    {},
                    '',
                    targetUrl
                );

            }

        })
        .catch(error => {

            console.error(
                'Gagal mengambil data:',
                error
            );

        })
        .finally(() => {

            results.classList.remove('loading');

        });

    }

    if (searchInput) {

        searchInput.addEventListener(
            'input',
            function () {

                clearTimeout(searchTimeout);

                searchTimeout = setTimeout(
                    function () {
                        loadData();
                    },
                    400
                );

            }
        );

    }

    form.querySelectorAll('select').forEach(
        function (input) {

            input.addEventListener(
                'change',
                function () {
                    loadData();
                }
            );

        }
    );

    if (resetButton) {

        resetButton.addEventListener(
            'click',
            function () {

                form.reset();

                if (searchInput) {
                    searchInput.value = '';
                }

                loadData();

            }
        );

    }

    results.addEventListener(
        'click',
        function (event) {

            const link =
                event.target.closest(
                    '.pagination a'
                );

            if (!link) {
                return;
            }

            event.preventDefault();

            loadData(link.href);

        }
    );

    window.addEventListener(
        'popstate',
        function () {

            loadData(
                window.location.href
            );

        }
    );

    form.addEventListener(
        'submit',
        function (event) {

            event.preventDefault();

            loadData();

        }
    );

});
</script>

@endpush@extends('layouts.app')

@section('title', 'Data Calon Siswa')

@section('content')

<div class="spmb-page">

    <div class="page-header">

        <div class="page-title">

            <div>
                <h4>Data Calon Siswa</h4>
                <p>Pengelolaan data calon siswa SPMB berdasarkan jurusan.</p>
            </div>

        </div>

        <a href="{{ route('admin.spmb.create') }}" class="btn-add">
            <i class="bi bi-plus-lg"></i>
            <span>Tambah Calon Siswa</span>
        </a>

    </div>

    @if(session('success'))

        <div class="alert-custom alert-success-custom">

            <div class="alert-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>

            <div class="alert-content">
                <strong>Berhasil</strong>
                <span>{{ session('success') }}</span>
            </div>

            <button
                type="button"
                class="alert-close"
                data-bs-dismiss="alert"
            >
                <i class="bi bi-x-lg"></i>
            </button>

        </div>

    @endif

    @if(session('error'))

        <div class="alert-custom alert-danger-custom">

            <div class="alert-icon">
                <i class="bi bi-exclamation-circle-fill"></i>
            </div>

            <div class="alert-content">
                <strong>Terjadi Kesalahan</strong>
                <span>{{ session('error') }}</span>
            </div>

            <button
                type="button"
                class="alert-close"
                data-bs-dismiss="alert"
            >
                <i class="bi bi-x-lg"></i>
            </button>

        </div>

    @endif

    <div class="filter-card">

        <div class="filter-header">

            <div class="filter-title">

                <div class="filter-icon">
                    <i class="bi bi-funnel"></i>
                </div>

                <div>
                    <h5>Filter Data</h5>
                    <span>Cari dan filter data calon siswa</span>
                </div>

            </div>

            <button
                type="button"
                id="resetSpmb"
                class="btn-reset"
            >
                <i class="bi bi-arrow-counterclockwise"></i>
                Reset
            </button>

        </div>

        <div class="filter-body">

            <form
                method="GET"
                action="{{ route('admin.spmb.index') }}"
                id="spmbFilterForm"
            >

                <div class="row g-3">

                    <div class="col-lg-4 col-md-6">

                        <label
                            for="spmbSearch"
                            class="form-label"
                        >
                            Pencarian
                        </label>

                        <div class="input-wrapper">

                            <i class="bi bi-search"></i>

                            <input
                                type="text"
                                name="search"
                                id="spmbSearch"
                                class="form-control custom-input"
                                placeholder="Nama, NISN, NIK, No. Pendaftaran"
                                value="{{ request('search') }}"
                                autocomplete="off"
                            >

                        </div>

                    </div>

                    <div class="col-lg-3 col-md-6">

                        <label
                            for="spmbJurusan"
                            class="form-label"
                        >
                            Jurusan
                        </label>

                        <div class="select-wrapper">

                            <select
                                name="jurusan_id"
                                id="spmbJurusan"
                                class="form-select custom-input"
                            >

                                <option value="">
                                    Semua Jurusan
                                </option>

                                @foreach($jurusan as $item)

                                    <option
                                        value="{{ $item->id }}"
                                        @selected(request('jurusan_id') == $item->id)
                                    >
                                        {{ $item->kode_jurusan }} - {{ $item->nama_jurusan }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                    <div class="col-lg-2 col-md-6">

                        <label
                            for="spmbJalur"
                            class="form-label"
                        >
                            Jalur
                        </label>

                        <div class="select-wrapper">

                            <select
                                name="jalur_pendaftaran"
                                id="spmbJalur"
                                class="form-select custom-input"
                            >

                                <option value="">
                                    Semua
                                </option>

                                @foreach(['Domisili', 'Prestasi', 'Afirmasi', 'Mutasi'] as $jalur)

                                    <option
                                        value="{{ $jalur }}"
                                        @selected(request('jalur_pendaftaran') == $jalur)
                                    >
                                        {{ $jalur }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                    <div class="col-lg-3 col-md-6">

                        <label
                            for="spmbStatus"
                            class="form-label"
                        >
                            Status Daftar Ulang
                        </label>

                        <div class="select-wrapper">

                            <select
                                name="status_daftar_ulang"
                                id="spmbStatus"
                                class="form-select custom-input"
                            >

                                <option value="">
                                    Semua Status
                                </option>

                                <option
                                    value="belum_daftar_ulang"
                                    @selected(request('status_daftar_ulang') == 'belum_daftar_ulang')
                                >
                                    Belum Daftar Ulang
                                </option>

                                <option
                                    value="menunggu_verifikasi"
                                    @selected(request('status_daftar_ulang') == 'menunggu_verifikasi')
                                >
                                    Menunggu Verifikasi
                                </option>

                                <option
                                    value="revisi"
                                    @selected(request('status_daftar_ulang') == 'revisi')
                                >
                                    Revisi
                                </option>

                                <option
                                    value="terverifikasi"
                                    @selected(request('status_daftar_ulang') == 'terverifikasi')
                                >
                                    Terverifikasi
                                </option>

                            </select>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <div class="data-card" id="spmb-search-results">

        <div class="data-card-header">

            <div>

                <h5>Daftar Calon Siswa</h5>

                <span>
                    Data calon siswa yang terdaftar pada sistem SPMB.
                </span>

            </div>

        </div>

        <div class="table-container">

            <div class="table-responsive">

                <table class="custom-table">

                    <thead>

                        <tr>
                            <th width="60">No</th>
                            <th>No. Pendaftaran</th>
                            <th>Nama Calon Siswa</th>
                            <th>NISN</th>
                            <th>Jurusan</th>
                            <th>Jalur</th>
                            <th>Status</th>
                            <th width="155">Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                    @forelse($calonSiswa as $index => $item)

                        <tr>

                            <td>

                                <span class="number-cell">
                                    {{ $calonSiswa->firstItem() + $index }}
                                </span>

                            </td>

                            <td>

                                <span class="registration-number">
                                    {{ $item->no_pendaftaran }}
                                </span>

                            </td>

                            <td>

                                <div class="student-name">

                                    <span class="student-avatar">
                                        {{ strtoupper(substr($item->nama_lengkap, 0, 1)) }}
                                    </span>

                                    <span>
                                        {{ $item->nama_lengkap }}
                                    </span>

                                </div>

                            </td>

                            <td>

                                <span class="nisn-text">
                                    {{ $item->nisn ?? '-' }}
                                </span>

                            </td>

                            <td>

                                @if($item->jurusan)

                                    <div class="jurusan-cell">

                                        <span class="jurusan-code">
                                            {{ $item->jurusan->kode_jurusan }}
                                        </span>

                                        <span class="jurusan-name">
                                            {{ $item->jurusan->nama_jurusan }}
                                        </span>

                                    </div>

                                @else

                                    <span class="empty-text">
                                        Jurusan tidak tersedia
                                    </span>

                                @endif

                            </td>

                            <td>

                                <span class="jalur-badge">
                                    {{ $item->jalur_pendaftaran }}
                                </span>

                            </td>

                            <td>

                                @if($item->status_daftar_ulang === 'terverifikasi')

                                    <span class="status-badge status-verified">
                                        <i class="bi bi-check-circle-fill"></i>
                                        Terverifikasi
                                    </span>

                                @elseif($item->status_daftar_ulang === 'revisi')

                                    <span class="status-badge status-revision">
                                        <i class="bi bi-exclamation-circle-fill"></i>
                                        Revisi
                                    </span>

                                @elseif($item->status_daftar_ulang === 'menunggu_verifikasi')

                                    <span class="status-badge status-waiting">
                                        <i class="bi bi-clock-fill"></i>
                                        Menunggu Verifikasi
                                    </span>

                                @else

                                    <span class="status-badge status-unregistered">
                                        <i class="bi bi-dash-circle-fill"></i>
                                        Belum Daftar Ulang
                                    </span>

                                @endif

                            </td>

                            <td>

                                <div class="action-buttons">

                                    <a
                                        href="{{ route('admin.spmb.show', $item->id) }}"
                                        class="action-btn detail-btn"
                                        title="Lihat Detail"
                                    >
                                        <i class="bi bi-eye-fill"></i>
                                        Detail
                                    </a>

                                    <a
                                        href="{{ route('admin.spmb.edit', $item->id) }}"
                                        class="action-btn edit-btn"
                                        title="Edit Data"
                                    >
                                        <i class="bi bi-pencil-fill"></i>
                                        Edit
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8">

                                <div class="empty-state">

                                    <div class="empty-icon">
                                        <i class="bi bi-inbox"></i>
                                    </div>

                                    <h6>Belum Ada Data</h6>

                                    <p>
                                        Belum ada data calon siswa yang tersedia.
                                    </p>

                                    <a
                                        href="{{ route('admin.spmb.create') }}"
                                        class="empty-action"
                                    >
                                        <i class="bi bi-plus-lg"></i>
                                        Tambah Calon Siswa
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        @if($calonSiswa->hasPages())

            <div class="pagination-container">
                {{ $calonSiswa->links() }}
            </div>

        @endif

    </div>

</div>

@endsection

@push('styles')

<style>

    body {
        font-family: 'Poppins', sans-serif;
    }

    .spmb-page {
        width: 100%;
        padding: 6px 2px 30px;
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
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .page-title h4 {
        margin: 0 0 5px;
        font-size: 23px;
        font-weight: 700;
        color: #172033;
        letter-spacing: -.2px;
    }

    .page-title p {
        margin: 0;
        font-size: 13px;
        color: #718096;
    }

    .btn-add {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 17px;
        border-radius: 9px;
        background: #2563eb;
        color: #fff;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        border: 1px solid #2563eb;
        box-shadow: 0 5px 14px rgba(37, 99, 235, .16);
        transition: .2s ease;
        white-space: nowrap;
    }

    .btn-add:hover {
        background: #1d4ed8;
        border-color: #1d4ed8;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 7px 18px rgba(37, 99, 235, .22);
    }

    .btn-add i {
        font-size: 15px;
    }

    .alert-custom {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 13px 15px;
        border-radius: 10px;
        margin-bottom: 18px;
        border: 1px solid;
    }

    .alert-success-custom {
        background: #f0fdf4;
        border-color: #bbf7d0;
        color: #166534;
    }

    .alert-danger-custom {
        background: #fef2f2;
        border-color: #fecaca;
        color: #991b1b;
    }

    .alert-icon {
        font-size: 18px;
        flex-shrink: 0;
    }

    .alert-content {
        display: flex;
        flex-direction: column;
        gap: 1px;
        flex: 1;
    }

    .alert-content strong {
        font-size: 13px;
        font-weight: 700;
    }

    .alert-content span {
        font-size: 12px;
    }

    .alert-close {
        border: 0;
        background: transparent;
        color: inherit;
        opacity: .65;
        padding: 4px;
        cursor: pointer;
    }

    .alert-close:hover {
        opacity: 1;
    }

    .filter-card {
        background: #fff;
        border: 1px solid #e8edf5;
        border-radius: 12px;
        margin-bottom: 20px;
        overflow: hidden;
        box-shadow: 0 3px 12px rgba(15, 23, 42, .04);
    }

    .filter-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 17px 20px;
        border-bottom: 1px solid #edf1f6;
        background: #fbfcfe;
    }

    .filter-title {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .filter-icon {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eef4ff;
        color: #2563eb;
        font-size: 15px;
    }

    .filter-title h5 {
        margin: 0 0 2px;
        font-size: 14px;
        font-weight: 700;
        color: #263247;
    }

    .filter-title span {
        font-size: 11px;
        color: #8792a5;
    }

    .btn-reset {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 11px;
        border-radius: 7px;
        background: #fff;
        border: 1px solid #dfe5ed;
        color: #64748b;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: .2s ease;
    }

    .btn-reset:hover {
        border-color: #2563eb;
        color: #2563eb;
        background: #f8faff;
    }

    .filter-body {
        padding: 19px 20px 20px;
    }

    .form-label {
        display: block;
        margin-bottom: 7px;
        color: #475569;
        font-size: 12px;
        font-weight: 600;
    }

    .input-wrapper {
        position: relative;
    }

    .input-wrapper > i {
        position: absolute;
        top: 50%;
        left: 13px;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
        z-index: 2;
    }

    .custom-input {
        height: 40px;
        border-radius: 8px !important;
        border: 1px solid #dfe5ed !important;
        color: #334155;
        background-color: #fff;
        font-size: 12px;
        box-shadow: none !important;
        transition: .2s ease;
    }

    .input-wrapper .custom-input {
        padding-left: 37px;
    }

    .custom-input::placeholder {
        color: #a0aabd;
    }

    .custom-input:hover {
        border-color: #c8d2df !important;
    }

    .custom-input:focus {
        border-color: #7aa2ef !important;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .08) !important;
    }

    .select-wrapper select {
        cursor: pointer;
    }

    .data-card {
        background: #fff;
        border: 1px solid #e8edf5;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 3px 12px rgba(15, 23, 42, .04);
        position: relative;
    }

    .data-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 20px;
        border-bottom: 1px solid #edf1f6;
    }

    .data-card-header h5 {
        margin: 0 0 3px;
        font-size: 15px;
        font-weight: 700;
        color: #263247;
    }

    .data-card-header span {
        font-size: 11px;
        color: #8a95a7;
    }

    .table-container {
        width: 100%;
    }

    .custom-table {
        width: 100%;
        min-width: 1050px;
        border-collapse: separate;
        border-spacing: 0;
    }

    .custom-table thead th {
        padding: 13px 14px;
        background: #f8fafc;
        border-bottom: 1px solid #e7ecf3;
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .25px;
        white-space: nowrap;
    }

    .custom-table tbody td {
        padding: 13px 14px;
        border-bottom: 1px solid #edf1f5;
        color: #475569;
        font-size: 12px;
        vertical-align: middle;
    }

    .custom-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .custom-table tbody tr {
        transition: .15s ease;
    }

    .custom-table tbody tr:hover {
        background: #fbfdff;
    }

    .number-cell {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 26px;
        height: 26px;
        padding: 0 6px;
        border-radius: 6px;
        background: #f1f5f9;
        color: #64748b;
        font-size: 11px;
        font-weight: 600;
    }

    .registration-number {
        color: #2563eb;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .student-name {
        display: flex;
        align-items: center;
        gap: 9px;
        min-width: 180px;
    }

    .student-avatar {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #eaf2ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .student-name span:last-child {
        color: #263247;
        font-weight: 600;
    }

    .nisn-text {
        color: #64748b;
        white-space: nowrap;
    }

    .jurusan-cell {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .jurusan-code {
        width: fit-content;
        padding: 3px 7px;
        border-radius: 5px;
        background: #eaf2ff;
        color: #2563eb;
        font-size: 10px;
        font-weight: 700;
    }

    .jurusan-name {
        color: #64748b;
        font-size: 11px;
    }

    .empty-text {
        color: #94a3b8;
        font-size: 11px;
    }

    .jalur-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 9px;
        border-radius: 6px;
        background: #f1f5f9;
        color: #475569;
        font-size: 10px;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 9px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-badge i {
        font-size: 10px;
    }

    .status-verified {
        background: #ecfdf3;
        color: #15803d;
    }

    .status-revision {
        background: #fef2f2;
        color: #dc2626;
    }

    .status-waiting {
        background: #fffbeb;
        color: #b45309;
    }

    .status-unregistered {
        background: #f1f5f9;
        color: #64748b;
    }

    .action-buttons {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        min-width: 58px;
        padding: 6px 9px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 600;
        text-decoration: none;
        transition: .2s ease;
        white-space: nowrap;
    }

    .action-btn i {
        font-size: 10px;
    }

    .detail-btn {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #dbeafe;
    }

    .detail-btn:hover {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .edit-btn {
        background: #fff7ed;
        color: #c2410c;
        border: 1px solid #fed7aa;
    }

    .edit-btn:hover {
        background: #ffedd5;
        color: #9a3412;
    }

    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 300px;
        padding: 35px 20px;
        text-align: center;
    }

    .empty-icon {
        width: 62px;
        height: 62px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 13px;
        background: #f1f5f9;
        color: #94a3b8;
        font-size: 27px;
    }

    .empty-state h6 {
        margin: 0 0 5px;
        color: #475569;
        font-size: 14px;
        font-weight: 700;
    }

    .empty-state p {
        margin: 0 0 15px;
        color: #94a3b8;
        font-size: 12px;
    }

    .empty-action {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 12px;
        border-radius: 7px;
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #dbeafe;
        font-size: 11px;
        font-weight: 600;
        text-decoration: none;
        transition: .2s ease;
    }

    .empty-action:hover {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .pagination-container {
        padding: 15px 20px;
        border-top: 1px solid #edf1f6;
        background: #fbfcfe;
    }

    .pagination-container nav {
        display: flex;
        justify-content: flex-end;
    }

    .pagination-container .pagination {
        margin: 0;
        gap: 4px;
    }

    .pagination-container .page-link {
        min-width: 31px;
        height: 31px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px !important;
        border: 1px solid #e2e8f0;
        color: #64748b;
        background: #fff;
        font-size: 11px;
        box-shadow: none;
    }

    .pagination-container .page-link:hover {
        background: #eff6ff;
        border-color: #bfdbfe;
        color: #2563eb;
    }

    .pagination-container .page-item.active .page-link {
        background: #2563eb;
        border-color: #2563eb;
        color: #fff;
    }

    .pagination-container .page-item.disabled .page-link {
        color: #cbd5e1;
        background: #f8fafc;
    }

    #spmb-search-results.loading {
        opacity: .55;
        pointer-events: none;
        transition: opacity .2s ease;
    }

    @media (max-width: 992px) {

        .page-header {
            align-items: flex-start;
        }

        .page-title h4 {
            font-size: 21px;
        }

        .filter-header,
        .data-card-header {
            padding: 16px;
        }

        .filter-body {
            padding: 17px 16px;
        }

    }

    @media (max-width: 768px) {

        .spmb-page {
            padding-top: 2px;
        }

        .page-header {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-add {
            width: 100%;
        }

        .page-title {
            align-items: flex-start;
        }

        .page-title h4 {
            font-size: 19px;
        }

        .page-title p {
            font-size: 12px;
            line-height: 1.5;
        }

        .filter-header {
            align-items: flex-start;
            gap: 12px;
        }

        .filter-title span {
            display: block;
            max-width: 220px;
            line-height: 1.4;
        }

        .data-card-header {
            align-items: flex-start;
        }

        .pagination-container {
            padding: 13px 15px;
        }

        .pagination-container nav {
            justify-content: center;
        }

    }

    @media (max-width: 500px) {

        .filter-header {
            flex-direction: column;
        }

        .btn-reset {
            width: 100%;
            justify-content: center;
        }

        .alert-custom {
            align-items: flex-start;
        }

        .action-buttons {
            flex-direction: column;
            align-items: stretch;
        }

        .action-btn {
            width: 65px;
        }

    }

</style>

@endpush

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('spmbFilterForm');
    const results = document.getElementById('spmb-search-results');
    const searchInput = document.getElementById('spmbSearch');
    const resetButton = document.getElementById('resetSpmb');

    if (!form || !results) {
        return;
    }

    let searchTimeout;

    function loadData(url = null) {

        let targetUrl = url;

        if (!targetUrl) {

            const formData = new FormData(form);
            const params = new URLSearchParams(formData);

            targetUrl =
                "{{ route('admin.spmb.index') }}" +
                "?" +
                params.toString();

        }

        results.classList.add('loading');

        fetch(targetUrl, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            }
        })
        .then(response => {

            if (!response.ok) {
                throw new Error('Gagal memuat data.');
            }

            return response.text();

        })
        .then(html => {

            const parser = new DOMParser();

            const doc =
                parser.parseFromString(
                    html,
                    'text/html'
                );

            const newResults =
                doc.querySelector(
                    '#spmb-search-results'
                );

            if (newResults) {

                results.innerHTML =
                    newResults.innerHTML;

                history.pushState(
                    {},
                    '',
                    targetUrl
                );

            }

        })
        .catch(error => {

            console.error(
                'Gagal mengambil data:',
                error
            );

        })
        .finally(() => {

            results.classList.remove('loading');

        });

    }

    if (searchInput) {

        searchInput.addEventListener(
            'input',
            function () {

                clearTimeout(searchTimeout);

                searchTimeout = setTimeout(
                    function () {
                        loadData();
                    },
                    400
                );

            }
        );

    }

    form.querySelectorAll('select').forEach(
        function (input) {

            input.addEventListener(
                'change',
                function () {
                    loadData();
                }
            );

        }
    );

    if (resetButton) {

        resetButton.addEventListener(
            'click',
            function () {

                form.reset();

                if (searchInput) {
                    searchInput.value = '';
                }

                loadData();

            }
        );

    }

    results.addEventListener(
        'click',
        function (event) {

            const link =
                event.target.closest(
                    '.pagination a'
                );

            if (!link) {
                return;
            }

            event.preventDefault();

            loadData(link.href);

        }
    );

    window.addEventListener(
        'popstate',
        function () {

            loadData(
                window.location.href
            );

        }
    );

    form.addEventListener(
        'submit',
        function (event) {

            event.preventDefault();

            loadData();

        }
    );

});
</script>

@endpush