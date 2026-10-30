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
        font-weight: 600;
        color: #374151;
    }

    .input-wrapper,
    .select-wrapper {
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
        color: #475569;
        font-size: 12px;
        font-weight: 600;
    }

    .input-wrapper {
        position: relative;
    }

    .input-wrapper>i {
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
}   

    .custom-table thead th {
        padding: 13px 14px;
        background: #f8fafc;
        border-bottom: 1px solid #e7ecf3;
        color: #64748b;
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
<<<<<<< Updated upstream
        background: #eff6ff;
=======
        background: #eaf2ff;
        font-weight: 700;

    .jurusan-name {
<<<<<<< Updated upstream
        color: #475569;
=======
        color: #64748b;
>>>>>>> Stashed changes
        font-size: 11px;
    }

    .empty-text {
        color: #94a3b8;
<<<<<<< Updated upstream
        font-size: 12px;
=======
        font-size: 11px;
>>>>>>> Stashed changes
    }

    .jalur-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 9px;
<<<<<<< Updated upstream
        border-radius: 7px;
        background: #f1f5f9;
        color: #475569;
        font-size: 11px;
=======
        border-radius: 6px;
        background: #f1f5f9;
        color: #475569;
        font-size: 10px;
>>>>>>> Stashed changes
        font-weight: 600;
        white-space: nowrap;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 9px;
<<<<<<< Updated upstream
        border-radius: 7px;
        font-size: 11px;
=======
        border-radius: 6px;
        font-size: 10px;
>>>>>>> Stashed changes
        font-weight: 600;
        white-space: nowrap;
    }

<<<<<<< Updated upstream
    .status-verified {
        background: #ecfdf5;
        color: #047857;
=======
    .status-badge i {
        font-size: 10px;
    }

    .status-verified {
        background: #ecfdf3;
        color: #15803d;
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
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
=======
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
>>>>>>> Stashed changes
        background: #dbeafe;
        color: #1d4ed8;
    }

    .edit-btn {
<<<<<<< Updated upstream
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #475569;
    }

    .edit-btn:hover {
        border-color: #cbd5e1;
        background: #f1f5f9;
        color: #1e293b;
=======
        background: #fff7ed;
        color: #c2410c;
        border: 1px solid #fed7aa;
    }

    .edit-btn:hover {
        background: #ffedd5;
        color: #9a3412;
>>>>>>> Stashed changes
    }

    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
<<<<<<< Updated upstream
        min-height: 280px;
        padding: 40px 20px;
=======
        min-height: 300px;
        padding: 35px 20px;
>>>>>>> Stashed changes
        text-align: center;
    }

    .empty-icon {
<<<<<<< Updated upstream
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
=======
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
>>>>>>> Stashed changes
        font-size: 14px;
        font-weight: 700;
    }

    .empty-state p {
<<<<<<< Updated upstream
        margin: 0 0 16px;
=======
        margin: 0 0 15px;
>>>>>>> Stashed changes
        color: #94a3b8;
        font-size: 12px;
    }

    .empty-action {
        display: inline-flex;
        align-items: center;
<<<<<<< Updated upstream
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
=======
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
>>>>>>> Stashed changes
    }

    .pagination-container .pagination {
        margin: 0;
<<<<<<< Updated upstream
=======
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

>>>>>>> Stashed changes
    }

    @media (max-width: 768px) {

<<<<<<< Updated upstream
        .page-header {
            align-items: flex-start;
            flex-direction: column;
=======
        .spmb-page {
            padding-top: 2px;
        }

        .page-header {
            flex-direction: column;
            align-items: stretch;
>>>>>>> Stashed changes
        }

        .btn-add {
            width: 100%;
        }

<<<<<<< Updated upstream
        .filter-header {
            align-items: flex-start;
=======
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
>>>>>>> Stashed changes
            flex-direction: column;
        }

        .btn-reset {
            width: 100%;
<<<<<<< Updated upstream
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

=======
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
>>>>>>> Stashed changes
</style>

@endpush

<<<<<<< Updated upstream

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
=======
@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {

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
>>>>>>> Stashed changes
                    }

                    return response.text();

                })
<<<<<<< Updated upstream
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
=======
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

                        history.pushState({},
                            '',
                            targetUrl
>>>>>>> Stashed changes
                        );

                    }

                })
<<<<<<< Updated upstream
                .catch(function (error) {

                    console.error(error);

                })
                .finally(function () {

                    results.style.opacity = '1';

                    results.style.pointerEvents = 'auto';
=======
                .catch(error => {

                    console.error(
                        'Gagal mengambil data:',
                        error
                    );

                })
                .finally(() => {

                    results.classList.remove('loading');
>>>>>>> Stashed changes

                });

        }

<<<<<<< Updated upstream

        function applyFilter() {

            const formData = new FormData(form);

            const params = new URLSearchParams(formData);

            const url = form.action + '?' + params.toString();

            loadData(url);

        }


=======
>>>>>>> Stashed changes
        if (searchInput) {

            searchInput.addEventListener(
                'input',
<<<<<<< Updated upstream
                function () {

                    clearTimeout(searchTimer);

                    searchTimer = setTimeout(
                        function () {

                            applyFilter();

=======
                function() {

                    clearTimeout(searchTimeout);

                    searchTimeout = setTimeout(
                        function() {
                            loadData();
>>>>>>> Stashed changes
                        },
                        400
                    );

                }
            );

        }

<<<<<<< Updated upstream

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

=======
        form.querySelectorAll('select').forEach(
            function(input) {

                input.addEventListener(
                    'change',
                    function() {
                        loadData();
                    }
                );

            }
        );
>>>>>>> Stashed changes

        if (resetButton) {

            resetButton.addEventListener(
                'click',
<<<<<<< Updated upstream
                function () {

                    form.reset();

                    const url = form.action;

                    loadData(url);
=======
                function() {

                    form.reset();

                    if (searchInput) {
                        searchInput.value = '';
                    }

                    loadData();
>>>>>>> Stashed changes

                }
            );

        }

<<<<<<< Updated upstream

        document.addEventListener(
            'click',
            function (event) {

                const link = event.target.closest(
                    '#spmb-search-results .pagination a'
                );

=======
        results.addEventListener(
            'click',
            function(event) {

                const link =
                    event.target.closest(
                        '.pagination a'
                    );
>>>>>>> Stashed changes

                if (!link) {
                    return;
                }

<<<<<<< Updated upstream

=======
>>>>>>> Stashed changes
                event.preventDefault();

                loadData(link.href);

            }
        );

<<<<<<< Updated upstream

        window.addEventListener(
            'popstate',
            function () {

                loadData(window.location.href);
=======
        window.addEventListener(
            'popstate',
            function() {

                loadData(
                    window.location.href
                );

            }
        );

        form.addEventListener(
            'submit',
            function(event) {

                event.preventDefault();

                loadData();
>>>>>>> Stashed changes

            }
        );

    });
<<<<<<< Updated upstream

=======
>>>>>>> Stashed changes
</script>

@endpush