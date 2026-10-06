@extends('layouts.app')

@section('title', 'Data Calon Siswa')

@section('content')

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

        <button type="button" id="resetSpmb" class="btn-reset">
            <i class="bi bi-arrow-counterclockwise"></i>
            Reset
        </button>

    </div>

    <div class="filter-body">

        <form
            method="GET"
            action="{{ route('admin.spmb.index') }}"
            id="spmbFilterForm">

            <div class="row g-3">

                <div class="col-lg-4 col-md-6">

                    <label for="spmbSearch" class="form-label">
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
                            autocomplete="off">

                    </div>

                </div>

                <div class="col-lg-3 col-md-6">

                    <label for="spmbJurusan" class="form-label">
                        Jurusan
                    </label>

                    <div class="select-wrapper">

                        <select
                            name="jurusan_id"
                            id="spmbJurusan"
                            class="form-select custom-input">

                            <option value="">
                                Semua Jurusan
                            </option>

                            @foreach($jurusan as $item)

                                <option
                                    value="{{ $item->id }}"
                                    @selected(request('jurusan_id') == $item->id)>
                                    {{ $item->kode_jurusan }} - {{ $item->nama_jurusan }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

                <div class="col-lg-2 col-md-6">

                    <label for="spmbJalur" class="form-label">
                        Jalur
                    </label>

                    <div class="select-wrapper">

                        <select
                            name="jalur_pendaftaran"
                            id="spmbJalur"
                            class="form-select custom-input">

                            <option value="">
                                Semua
                            </option>

                            @foreach(['Domisili', 'Prestasi', 'Afirmasi', 'Mutasi'] as $jalur)

                                <option
                                    value="{{ $jalur }}"
                                    @selected(request('jalur_pendaftaran') == $jalur)>
                                    {{ $jalur }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

                <div class="col-lg-3 col-md-6">

                    <label for="spmbStatus" class="form-label">
                        Status Daftar Ulang
                    </label>

                    <div class="select-wrapper">

                        <select
                            name="status_daftar_ulang"
                            id="spmbStatus"
                            class="form-select custom-input">

                            <option value="">
                                Semua Status
                            </option>

                            <option
                                value="belum_daftar_ulang"
                                @selected(request('status_daftar_ulang') == 'belum_daftar_ulang')>
                                Belum Daftar Ulang
                            </option>

                            <option
                                value="menunggu_verifikasi"
                                @selected(request('status_daftar_ulang') == 'menunggu_verifikasi')>
                                Menunggu Verifikasi
                            </option>

                            <option
                                value="revisi"
                                @selected(request('status_daftar_ulang') == 'revisi')>
                                Revisi
                            </option>

                            <option
                                value="terverifikasi"
                                @selected(request('status_daftar_ulang') == 'terverifikasi')>
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
                                        title="Lihat Detail">

                                        <i class="bi bi-eye-fill"></i>

                                        Detail

                                    </a>

                                    <a
                                        href="{{ route('admin.spmb.edit', $item->id) }}"
                                        class="action-btn edit-btn"
                                        title="Edit Data">

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
                                        class="empty-action">

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

@endsection


@push('styles')

<style>

    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .page-title h4 {
        margin: 0 0 6px;
        font-size: 22px;
        font-weight: 700;
        color: #1f2937;
    }

    .page-title p {
        margin: 0;
        font-size: 14px;
        color: #6b7280;
    }

    .btn-add {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 42px;
        padding: 0 18px;
        border: 0;
        border-radius: 10px;
        background: #2563eb;
        color: #ffffff;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: 0.2s ease;
    }

    .btn-add:hover {
        background: #1d4ed8;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .filter-card {
        margin-bottom: 24px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        background: #ffffff;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.05);
    }

    .filter-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 18px 20px;
        border-bottom: 1px solid #eef0f3;
    }

    .filter-title {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .filter-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 17px;
    }

    .filter-title h5 {
        margin: 0 0 3px;
        font-size: 15px;
        font-weight: 700;
        color: #1f2937;
    }

    .filter-title span {
        font-size: 12px;
        color: #6b7280;
    }

    .btn-reset {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 36px;
        padding: 0 13px;
        border: 1px solid #dbe2ea;
        border-radius: 9px;
        background: #ffffff;
        color: #475569;
        font-size: 13px;
        font-weight: 500;
        transition: 0.2s ease;
    }

    .btn-reset:hover {
        border-color: #2563eb;
        background: #eff6ff;
        color: #2563eb;
    }

    .filter-body {
        padding: 20px;
    }

    .form-label {
        display: block;
        margin-bottom: 7px;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
    }

    .input-wrapper,
    .select-wrapper {
        position: relative;
    }

    .input-wrapper > i {
        position: absolute;
        top: 50%;
        left: 13px;
        z-index: 2;
        color: #94a3b8;
        font-size: 14px;
        transform: translateY(-50%);
        pointer-events: none;
    }

    .custom-input {
        min-height: 42px;
        border: 1px solid #dbe2ea;
        border-radius: 9px;
        background: #ffffff;
        color: #374151;
        font-size: 13px;
        box-shadow: none;
        transition: 0.2s ease;
    }

    .input-wrapper .custom-input {
        padding-left: 38px;
    }

    .custom-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.08);
    }

    .select-wrapper::after {
        position: absolute;
        top: 50%;
        right: 13px;
        color: #94a3b8;
        font-family: "bootstrap-icons";
        font-size: 12px;
        content: "\f282";
        transform: translateY(-50%);
        pointer-events: none;
    }

    .select-wrapper .custom-input {
        padding-right: 35px;
        appearance: none;
    }

    .data-card {
        overflow: hidden;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        background: #ffffff;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.05);
    }

    .data-card-header {
        padding: 18px 20px;
        border-bottom: 1px solid #eef0f3;
    }

    .data-card-header h5 {
        margin: 0 0 4px;
        font-size: 15px;
        font-weight: 700;
        color: #1f2937;
    }

    .data-card-header span {
        font-size: 12px;
        color: #6b7280;
    }

    .table-container {
        width: 100%;
        overflow: hidden;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .custom-table {
        width: 100%;
        min-width: 1050px;
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .custom-table thead th {
        padding: 13px 14px;
        border-bottom: 1px solid #e5e7eb;
        background: #f8fafc;
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .custom-table tbody td {
        padding: 14px;
        border-bottom: 1px solid #f1f5f9;
        color: #475569;
        font-size: 13px;
        vertical-align: middle;
    }

    .custom-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .custom-table tbody tr {
        transition: 0.15s ease;
    }

    .custom-table tbody tr:hover {
        background: #f8fafc;
    }

    .number-cell {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 25px;
        color: #64748b;
        font-size: 12px;
        font-weight: 600;
    }

    .registration-number {
        color: #2563eb;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .student-name {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 190px;
        color: #1f2937;
        font-weight: 600;
    }

    .student-avatar {
        display: inline-flex;
        flex: 0 0 auto;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 9px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 12px;
        font-weight: 700;
    }

    .nisn-text {
        color: #64748b;
        font-size: 12px;
        white-space: nowrap;
    }

    .jurusan-cell {
        display: flex;
        flex-direction: column;
        gap: 3px;
        min-width: 140px;
    }

    .jurusan-code {
        width: fit-content;
        padding: 3px 7px;
        border-radius: 5px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 10px;
        font-weight: 700;
    }

    .jurusan-name {
        color: #475569;
        font-size: 11px;
    }

    .empty-text {
        color: #94a3b8;
        font-size: 12px;
    }

    .jalur-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 9px;
        border-radius: 7px;
        background: #f1f5f9;
        color: #475569;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 9px;
        border-radius: 7px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-verified {
        background: #ecfdf5;
        color: #047857;
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
        min-height: 32px;
        padding: 0 9px;
        border-radius: 7px;
        font-size: 11px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: 0.2s ease;
    }

    .detail-btn {
        border: 1px solid #dbeafe;
        background: #eff6ff;
        color: #2563eb;
    }

    .detail-btn:hover {
        border-color: #bfdbfe;
        background: #dbeafe;
        color: #1d4ed8;
    }

    .edit-btn {
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #475569;
    }

    .edit-btn:hover {
        border-color: #cbd5e1;
        background: #f1f5f9;
        color: #1e293b;
    }

    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 280px;
        padding: 40px 20px;
        text-align: center;
    }

    .empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 56px;
        height: 56px;
        margin-bottom: 14px;
        border-radius: 14px;
        background: #f1f5f9;
        color: #94a3b8;
        font-size: 24px;
    }

    .empty-state h6 {
        margin: 0 0 6px;
        color: #334155;
        font-size: 14px;
        font-weight: 700;
    }

    .empty-state p {
        margin: 0 0 16px;
        color: #94a3b8;
        font-size: 12px;
    }

    .empty-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 36px;
        padding: 0 13px;
        border-radius: 8px;
        background: #2563eb;
        color: #ffffff;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
    }

    .empty-action:hover {
        background: #1d4ed8;
        color: #ffffff;
    }

    .pagination-container {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding: 16px 20px;
        border-top: 1px solid #eef0f3;
    }

    .pagination-container .pagination {
        margin: 0;
    }

    @media (max-width: 768px) {

        .page-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .btn-add {
            width: 100%;
        }

        .filter-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .btn-reset {
            width: 100%;
        }

        .filter-body {
            padding: 16px;
        }

        .data-card-header {
            padding: 16px;
        }

        .pagination-container {
            justify-content: center;
            padding: 14px;
        }

    }

</style>

@endpush


@push('scripts')

<script>

    document.addEventListener('DOMContentLoaded', function () {

        const form = document.getElementById('spmbFilterForm');

        const searchInput = document.getElementById('spmbSearch');

        const jurusanSelect = document.getElementById('spmbJurusan');

        const jalurSelect = document.getElementById('spmbJalur');

        const statusSelect = document.getElementById('spmbStatus');

        const resetButton = document.getElementById('resetSpmb');

        const results = document.getElementById('spmb-search-results');

        let searchTimer;


        function loadData(url) {

            const params = new URLSearchParams(
                new URL(url, window.location.origin).search
            );

            const search = params.get('search') || '';

            const jurusanId = params.get('jurusan_id') || '';

            const jalur = params.get('jalur_pendaftaran') || '';

            const status = params.get('status_daftar_ulang') || '';


            if (searchInput) {
                searchInput.value = search;
            }

            if (jurusanSelect) {
                jurusanSelect.value = jurusanId;
            }

            if (jalurSelect) {
                jalurSelect.value = jalur;
            }

            if (statusSelect) {
                statusSelect.value = status;
            }


            results.style.opacity = '0.5';

            results.style.pointerEvents = 'none';


            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(function (response) {

                    if (!response.ok) {
                        throw new Error('Gagal mengambil data.');
                    }

                    return response.text();

                })
                .then(function (html) {

                    const parser = new DOMParser();

                    const doc = parser.parseFromString(
                        html,
                        'text/html'
                    );

                    const newResults = doc.getElementById(
                        'spmb-search-results'
                    );


                    if (newResults) {

                        results.innerHTML = newResults.innerHTML;

                        history.pushState(
                            {},
                            '',
                            url
                        );

                    }

                })
                .catch(function (error) {

                    console.error(error);

                })
                .finally(function () {

                    results.style.opacity = '1';

                    results.style.pointerEvents = 'auto';

                });

        }


        function applyFilter() {

            const formData = new FormData(form);

            const params = new URLSearchParams(formData);

            const url = form.action + '?' + params.toString();

            loadData(url);

        }


        if (searchInput) {

            searchInput.addEventListener(
                'input',
                function () {

                    clearTimeout(searchTimer);

                    searchTimer = setTimeout(
                        function () {

                            applyFilter();

                        },
                        400
                    );

                }
            );

        }


        if (jurusanSelect) {

            jurusanSelect.addEventListener(
                'change',
                function () {

                    applyFilter();

                }
            );

        }


        if (jalurSelect) {

            jalurSelect.addEventListener(
                'change',
                function () {

                    applyFilter();

                }
            );

        }


        if (statusSelect) {

            statusSelect.addEventListener(
                'change',
                function () {

                    applyFilter();

                }
            );

        }


        if (resetButton) {

            resetButton.addEventListener(
                'click',
                function () {

                    form.reset();

                    const url = form.action;

                    loadData(url);

                }
            );

        }


        document.addEventListener(
            'click',
            function (event) {

                const link = event.target.closest(
                    '#spmb-search-results .pagination a'
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

                loadData(window.location.href);

            }
        );

    });

</script>

@endpush