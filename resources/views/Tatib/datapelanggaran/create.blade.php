@extends('layouts.app')

@section('title', 'Pencatatan Tatib')

@section('content')
<div class="container-fluid tatib-page py-3">

    {{-- HEADER --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">Pencatatan Tatib</h4>
            <p class="text-secondary mb-0">
                Catat beberapa pelanggaran siswa dalam satu kali pengisian.
            </p>
        </div>

        <a href="{{ route('tatib.riwayat') }}" class="btn btn-outline-secondary">
            <i class="bi bi-clock-history me-1"></i> Riwayat
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Periksa kembali form:</strong>
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tatib.datapelanggaran.store') }}"
          method="POST"
          id="formTatib">
        @csrf

        {{-- INFORMASI PENCATATAN --}}
        <div class="card tatib-card mb-4">
            <div class="card-body p-4">
                <div class="section-title mb-4">
                    <span class="number">1</span>
                    <div>
                        <h5 class="fw-bold mb-1">Informasi Pencatatan</h5>
                        <p class="text-secondary small mb-0">
                            Tentukan tanggal dan pelanggaran awal untuk siswa baru.
                        </p>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="tanggal" class="form-label fw-semibold">
                            Tanggal <span class="text-danger">*</span>
                        </label>
                        <input type="date"
                               id="tanggal"
                               name="tanggal"
                               class="form-control"
                               required
                               value="{{ old('tanggal', now()->format('Y-m-d')) }}">
                    </div>

                    <div class="col-md-4">
                        <label for="kategori" class="form-label fw-semibold">
                            Kategori Pelanggaran
                        </label>
                        <select id="kategori" class="form-select">
                            <option value="">-- Semua kategori --</option>
                            @foreach ($jenisPelanggaran->map(fn ($jenis) => $jenis->kategori ?: 'Lainnya')->unique()->sort()->values() as $kategori)
                                <option value="{{ $kategori }}">{{ $kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="pelanggaranUtama" class="form-label fw-semibold">
                            Pelanggaran Awal
                        </label>
                        <select id="pelanggaranUtama"
                                name="pelanggaran_utama"
                                class="form-select"
                                disabled>
                            <option value="">-- Pilih kategori dahulu --</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- DAFTAR SISWA --}}
        <div class="card tatib-card mb-4">
            <div class="card-body p-4">

                <div class="section-title mb-4">
                    <span class="number">2</span>
                    <div>
                        <h5 class="fw-bold mb-1">Daftar Siswa</h5>
                        <p class="text-secondary small mb-0">
                            Tambahkan siswa, lalu pilih satu atau lebih pelanggaran.
                        </p>
                    </div>
                </div>

                <label for="cariSiswa" class="form-label fw-semibold">
                    Cari nama atau NIS
                </label>

                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="search"
                           id="cariSiswa"
                           class="form-control"
                           placeholder="Ketik minimal 2 karakter..."
                           autocomplete="off"
                           data-url="{{ route('tatib.siswa.search') }}">
                </div>

                <div id="hasilSiswa"
                     class="search-results d-none"
                     aria-live="polite"></div>

                <div class="d-flex justify-content-between align-items-center gap-2 mt-4 mb-3">
                    <h6 class="fw-bold mb-0">Siswa yang dicatat</h6>
                    <span class="badge text-bg-primary" id="jumlahSiswa">
                        {{ $selectedSiswa->count() }} siswa
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table tatib-table align-middle">
                        <thead>
                            <tr>
                                <th>Nama / NIS</th>
                                <th>Kategori</th>
                                <th>Pelanggaran</th>
                                <th class="text-center">Total Poin</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody id="daftarSiswa">
                            @foreach ($selectedSiswa as $index => $siswa)
                                @php
                                    $oldRow = collect($oldSiswa ?? [])
                                        ->first(fn ($row) =>
                                            (string) ($row['id'] ?? '') === (string) $siswa->id
                                        );

                                    $chosenIds = collect($oldRow['pelanggaran'] ?? [])
                                        ->map(fn ($id) => (string) $id)
                                        ->all();
                                @endphp

                                <tr data-student-id="{{ $siswa->id }}"
                                    data-index="{{ $index }}">

                                    <td class="student-identity">
                                        <div class="fw-bold student-name">
                                            {{ $siswa->nama }}
                                        </div>
                                        <small class="text-secondary">
                                            NIS: {{ $siswa->nis }}
                                        </small>

                                        <input type="hidden"
                                               name="siswa[{{ $index }}][id]"
                                               value="{{ $siswa->id }}">
                                    </td>

                                    <td>
                                        <div data-selected-categories>
                                            <span class="text-secondary small">Belum dipilih</span>
                                        </div>
                                    </td>

                                    <td class="violation-cell">
                                        <div data-selected-violations>
                                            <span class="text-secondary small">Belum dipilih</span>
                                        </div>

                                        {{-- Penyimpanan checkbox untuk form --}}
                                        <div class="d-none" data-violation-store>
                                            @foreach ($chosenIds as $chosenId)
                                                <input type="checkbox"
                                                       name="siswa[{{ $index }}][pelanggaran][]"
                                                       value="{{ $chosenId }}"
                                                       checked>
                                            @endforeach
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <span class="total-points" data-total-points>0</span>
                                        <small class="d-block text-secondary">poin</small>
                                    </td>

                                    <td class="text-center action-cell">
                                        <div class="d-flex justify-content-center gap-1 flex-wrap">
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-primary"
                                                    data-add-violation>
                                                <i class="bi bi-plus-circle"></i>
                                                <span>Tambah</span>
                                            </button>

                                            <button type="button"
                                                    class="btn btn-sm btn-outline-danger"
                                                    data-remove-student
                                                    title="Hapus siswa">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>

                                        <div class="small text-danger mt-2 d-none"
                                             data-no-violation>
                                            Pilih minimal satu pelanggaran.
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div id="pesanKosong"
                     class="empty-state {{ $selectedSiswa->isNotEmpty() ? 'd-none' : '' }}">
                    <i class="bi bi-person-plus fs-3 d-block mb-2"></i>
                    Belum ada siswa. Cari dan pilih siswa di atas.
                </div>
            </div>
        </div>

        {{-- RINGKASAN --}}
        <div class="card tatib-card">
            <div class="card-body p-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div>
                        <div class="text-secondary small">Ringkasan</div>
                        <div class="fw-bold" id="ringkasanSiswa">
                            {{ $selectedSiswa->count() }} siswa dipilih
                        </div>
                        <div class="text-secondary small" id="ringkasanPelanggaran">
                            0 catatan pelanggaran dipilih
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('tatib.datapelanggaran') }}"
                           class="btn btn-light border">
                            Batal
                        </a>
                        <button type="submit"
                                id="tombolSimpan"
                                class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i> Simpan Semua
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- MODAL TAMBAH PELANGGARAN --}}
<div class="modal fade"
     id="modalTambahPelanggaran"
     tabindex="-1"
     aria-labelledby="judulModalPelanggaran"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title fw-bold" id="judulModalPelanggaran">
                        Tambah Pelanggaran
                    </h5>
                    <small class="text-secondary" id="namaSiswaModal"></small>
                </div>
                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Tutup"></button>
            </div>

            <div class="modal-body">
                <label for="kategoriModal" class="form-label fw-semibold">
                    Pilih kategori
                </label>
                <select id="kategoriModal" class="form-select mb-3">
                    <option value="">-- Semua kategori --</option>
                </select>

                <div id="daftarPilihanModal" class="row g-2"></div>

                <div id="modalPilihanKosong"
                     class="text-center text-secondary py-4 d-none">
                    Semua pelanggaran dalam kategori ini sudah dipilih.
                </div>
            </div>

            <div class="modal-footer">
                <button type="button"
                        class="btn btn-primary"
                        data-bs-dismiss="modal">
                    Selesai
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .tatib-page {
        color: #1f2937;
        font-family: 'Poppins', sans-serif;
    }

    .tatib-card {
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        box-shadow: 0 3px 12px rgba(15, 23, 42, .035);
    }

    .section-title {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .number {
        width: 34px;
        height: 34px;
        flex: 0 0 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: #edf2ff;
        color: #2449a4;
        font-weight: 700;
    }

    .tatib-page .form-control,
    .tatib-page .form-select,
    .tatib-page .input-group-text {
        min-height: 44px;
        border-color: #dbe1ea;
    }

    .tatib-page .form-control:focus,
    .tatib-page .form-select:focus {
        border-color: #7896e8;
        box-shadow: 0 0 0 .2rem rgba(36, 73, 164, .10);
    }

    .search-results {
        margin-top: 8px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        overflow-y: auto;
        max-height: 280px;
        background: #fff;
    }

    .search-result {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding: 12px 14px;
        border-bottom: 1px solid #f0f2f5;
    }

    .search-result:last-child {
        border-bottom: 0;
    }

    .search-result:hover {
        background: #f8faff;
    }

    .tatib-table {
        min-width: 850px;
        margin-bottom: 0;
    }

    .tatib-table thead th {
        padding: 14px 12px;
        background: #f7f9fc;
        color: #475569;
        font-size: 13px;
        white-space: nowrap;
        border-bottom: 1px solid #e2e8f0;
    }

    .tatib-table tbody td {
        padding: 16px 12px;
        border-bottom: 1px solid #edf0f4;
        vertical-align: top;
    }

    .tatib-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .student-identity {
        min-width: 160px;
    }

    .student-name {
        overflow-wrap: anywhere;
    }

    .violation-cell {
        min-width: 250px;
    }

    .selected-category {
        display: block;
        width: fit-content;
        max-width: 160px;
        margin-bottom: 6px;
        padding: 4px 9px;
        border-radius: 6px;
        background: #eef2ff;
        color: #344a9a;
        font-size: 12px;
        overflow-wrap: anywhere;
    }

    .selected-violation {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 8px;
        margin-bottom: 8px;
        padding: 9px 10px;
        border: 1px solid #e2e8f0;
        border-radius: 7px;
        background: #fff;
    }

    .selected-violation:last-child {
        margin-bottom: 0;
    }

    .selected-violation-name {
        font-size: 13px;
        font-weight: 500;
        overflow-wrap: anywhere;
    }

    .selected-violation-points {
        margin-top: 3px;
        color: #64748b;
        font-size: 11px;
    }

    .selected-violation .btn {
        flex: 0 0 auto;
    }

    .total-points {
        display: inline-block;
        min-width: 34px;
        padding: 5px 8px;
        border-radius: 7px;
        background: #f1f5f9;
        font-weight: 700;
    }

    .action-cell {
        min-width: 150px;
    }

    .modal-violation-option {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        width: 100%;
        height: 100%;
        padding: 12px;
        border: 1px solid #e2e7ee;
        border-radius: 8px;
        cursor: pointer;
    }

    .modal-violation-option:hover {
        background: #f8faff;
        border-color: #9bb3f4;
    }

    .modal-violation-option input {
        margin-top: 4px;
        flex: 0 0 auto;
        accent-color: #2449a4;
    }

    .empty-state {
        text-align: center;
        padding: 28px 12px;
        color: #6b7280;
        border: 1px dashed #d1d5db;
        border-radius: 10px;
    }

    @media (max-width: 576px) {
        .tatib-page .card-body {
            padding: 18px !important;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('cariSiswa');
    const resultsBox = document.getElementById('hasilSiswa');
    const studentsBox = document.getElementById('daftarSiswa');
    const emptyBox = document.getElementById('pesanKosong');
    const categorySelect = document.getElementById('kategori');
    const mainViolation = document.getElementById('pelanggaranUtama');
    const countBox = document.getElementById('jumlahSiswa');
    const studentSummary = document.getElementById('ringkasanSiswa');
    const violationSummary = document.getElementById('ringkasanPelanggaran');
    const form = document.getElementById('formTatib');
    const saveButton = document.getElementById('tombolSimpan');

    const modalElement = document.getElementById('modalTambahPelanggaran');
    const modalKategori = document.getElementById('kategoriModal');
    const modalOptions = document.getElementById('daftarPilihanModal');
    const modalEmpty = document.getElementById('modalPilihanKosong');
    const modalStudentName = document.getElementById('namaSiswaModal');

    const violations = {{ Illuminate\Support\Js::from($violations) }};
    const oldMainViolation = @json(old('pelanggaran_utama', ''));

    const modalInstance = bootstrap.Modal.getOrCreateInstance(modalElement);

    
const modalCategories = [
    ...new Set(
        violations.map(item => item.kategori || 'Lainnya')
    )
].sort((a, b) => a.localeCompare(b, 'id'));

modalCategories.forEach(category => {
    const option = document.createElement('option');
    option.value = category;
    option.textContent = category;

    modalKategori.appendChild(option);
});


    const existingIds = new Set(
        Array.from(studentsBox.querySelectorAll('[data-student-id]'))
            .map(row => String(row.dataset.studentId))
    );

    const usedIndexes = new Set(
        Array.from(studentsBox.querySelectorAll('[data-student-id]'))
            .map(row => Number(row.dataset.index))
            .filter(Number.isInteger)
    );

    let activeRow = null;
    let searchTimer = null;
    let currentResults = [];
    let searchRequestId = 0;

    function escapeHtml(value) {
        return String(value ?? '').replace(/[&<>"']/g, function (char) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[char];
        });
    }

    function getNextIndex() {
        let index = 0;

        while (usedIndexes.has(index)) {
            index++;
        }

        usedIndexes.add(index);
        return index;
    }

    function getStore(row) {
        return row.querySelector('[data-violation-store]');
    }

    function getSelectedIds(row) {
        return Array.from(
            getStore(row).querySelectorAll('input[type="checkbox"]:checked')
        ).map(input => String(input.value));
    }

    function getViolation(id) {
        return violations.find(item => String(item.id) === String(id));
    }

    function setViolation(row, id, checked) {
        const store = getStore(row);
        let input = Array.from(store.querySelectorAll('input[type="checkbox"]'))
            .find(item => String(item.value) === String(id));

        if (checked && !input) {
            input = document.createElement('input');
            input.type = 'checkbox';
            input.name = `siswa[${row.dataset.index}][pelanggaran][]`;
            input.value = String(id);
            input.checked = true;
            store.appendChild(input);
        } else if (input) {
            input.checked = checked;
        }

        // Hapus input yang tidak dipilih agar form tetap ringkas.
        if (input && !checked) {
            input.remove();
        }

        renderStudentRow(row);
        updateSummary();
    }

    function renderStudentRow(row) {
        const ids = getSelectedIds(row);
        const selected = ids.map(getViolation).filter(Boolean);

        const categoriesBox = row.querySelector('[data-selected-categories]');
        const violationsBox = row.querySelector('[data-selected-violations]');
        const totalBox = row.querySelector('[data-total-points]');
        const warning = row.querySelector('[data-no-violation]');

        const categories = [...new Set(
            selected.map(item => item.kategori || 'Lainnya')
        )];

        categoriesBox.innerHTML = categories.length
            ? categories.map(category => `
                <span class="selected-category">${escapeHtml(category)}</span>
              `).join('')
            : '<span class="text-secondary small">Belum dipilih</span>';

        violationsBox.innerHTML = selected.length
            ? selected.map(item => `
                <div class="selected-violation">
                    <div>
                        <div class="selected-violation-name">
                            ${escapeHtml(item.nama)}
                        </div>
                        <div class="selected-violation-points">
                            ${escapeHtml(item.poin)} poin
                        </div>
                    </div>

                    <button type="button"
                            class="btn btn-sm btn-light border text-danger"
                            data-remove-violation="${escapeHtml(item.id)}"
                            title="Hapus pelanggaran"
                            aria-label="Hapus ${escapeHtml(item.nama)}">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
              `).join('')
            : '<span class="text-secondary small">Belum ada pelanggaran.</span>';

        const total = selected.reduce(
            (sum, item) => sum + (Number(item.poin) || 0),
            0
        );

        totalBox.textContent = total;

        if (warning) {
            warning.classList.toggle('d-none', selected.length > 0);
        }
    }

    function updateSummary() {
        const rows = Array.from(
            studentsBox.querySelectorAll('[data-student-id]')
        );

       const count = rows.reduce(
    (sum, row) => sum + getSelectedIds(row).filter(
        id => getViolation(id)
    ).length,
    0
);

        countBox.textContent = `${rows.length} siswa`;
        studentSummary.textContent = `${rows.length} siswa dipilih`;
        violationSummary.textContent = `${count} catatan pelanggaran dipilih`;

        emptyBox.classList.toggle('d-none', rows.length > 0);
    }

    function filterMainViolations() {
        const selectedCategory = categorySelect.value;
        const previousValue = mainViolation.value || oldMainViolation;

        mainViolation.innerHTML = '';

        if (!selectedCategory) {
            mainViolation.disabled = true;
            mainViolation.innerHTML =
                '<option value="">-- Pilih kategori dahulu --</option>';
            return;
        }

        mainViolation.disabled = false;
        mainViolation.innerHTML =
            '<option value="">-- Pilih pelanggaran awal --</option>';

        violations
            .filter(item => (item.kategori || 'Lainnya') === selectedCategory)
            .forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = `${item.nama} (${item.poin} poin)`;

                if (String(item.id) === String(previousValue)) {
                    option.selected = true;
                }

                mainViolation.appendChild(option);
            });
    }

    function renderModalOptions() {
        if (!activeRow) return;

        const category = modalKategori.value;
        const selectedIds = new Set(getSelectedIds(activeRow));

        const available = violations.filter(item => {
            const itemCategory = item.kategori || 'Lainnya';

            return !selectedIds.has(String(item.id)) &&
                (!category || itemCategory === category);
        });

        modalOptions.innerHTML = available.map(item => `
            <div class="col-md-6">
                <label class="modal-violation-option">
                    <input type="checkbox"
                           data-modal-violation="${escapeHtml(item.id)}">

                    <span>
                        <span class="d-block fw-semibold">
                            ${escapeHtml(item.nama)}
                        </span>
                        <small class="text-secondary">
                            ${escapeHtml(item.kategori || 'Lainnya')}
                            · ${escapeHtml(item.poin)} poin
                        </small>
                    </span>
                </label>
            </div>
        `).join('');

        modalEmpty.classList.toggle('d-none', available.length > 0);
    }

    function openViolationModal(row) {
        activeRow = row;

        const name = row.querySelector('.student-name')?.textContent.trim() || '';
        const nis = row.querySelector('.student-identity small')?.textContent.trim() || '';

        modalStudentName.textContent = `${name} — ${nis}`;
        modalKategori.value = '';

        renderModalOptions();
        modalInstance.show();
    }

    function addStudent(siswa) {
        const id = String(siswa.id);

        if (existingIds.has(id)) return;

        const index = getNextIndex();
        const defaultViolation = String(mainViolation.value || '');
        const row = document.createElement('tr');

        row.dataset.studentId = id;
        row.dataset.index = index;

        row.innerHTML = `
            <td class="student-identity">
                <div class="fw-bold student-name">${escapeHtml(siswa.nama)}</div>
                <small class="text-secondary">NIS: ${escapeHtml(siswa.nis)}</small>
                <input type="hidden"
                       name="siswa[${index}][id]"
                       value="${escapeHtml(id)}">
            </td>

            <td>
                <div data-selected-categories></div>
            </td>

            <td class="violation-cell">
                <div data-selected-violations></div>
                <div class="d-none" data-violation-store></div>
            </td>

            <td class="text-center">
                <span class="total-points" data-total-points>0</span>
                <small class="d-block text-secondary">poin</small>
            </td>

            <td class="text-center action-cell">
                <div class="d-flex justify-content-center gap-1 flex-wrap">
                    <button type="button"
                            class="btn btn-sm btn-outline-primary"
                            data-add-violation>
                        <i class="bi bi-plus-circle"></i>
                        <span>Tambah</span>
                    </button>

                    <button type="button"
                            class="btn btn-sm btn-outline-danger"
                            data-remove-student
                            title="Hapus siswa">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>

                <div class="small text-danger mt-2 d-none" data-no-violation>
                    Pilih minimal satu pelanggaran.
                </div>
            </td>
        `;

        studentsBox.appendChild(row);
        existingIds.add(id);

        if (defaultViolation) {
            setViolation(row, defaultViolation, true);
        } else {
            renderStudentRow(row);
        }

        updateSummary();
        renderResults(currentResults);
    }

    function renderResults(items) {
        currentResults = items;

        if (!items.length) {
            resultsBox.innerHTML =
                '<div class="p-3 text-secondary small">Siswa tidak ditemukan.</div>';
            resultsBox.classList.remove('d-none');
            return;
        }

        resultsBox.innerHTML = items.map(siswa => {
            const alreadyAdded = existingIds.has(String(siswa.id));

            return `
                <div class="search-result">
                    <div>
                        <div class="fw-semibold">${escapeHtml(siswa.nama)}</div>
                        <small class="text-secondary">
                            NIS: ${escapeHtml(siswa.nis)}
                        </small>
                    </div>

                    <button type="button"
                            class="btn btn-sm ${
                                alreadyAdded
                                    ? 'btn-light border'
                                    : 'btn-outline-primary'
                            }"
                            data-add-student="${escapeHtml(siswa.id)}"
                            ${alreadyAdded ? 'disabled' : ''}>
                        ${alreadyAdded ? 'Sudah dipilih' : 'Pilih'}
                    </button>
                </div>
            `;
        }).join('');

        resultsBox.classList.remove('d-none');
    }

    // Filter pelanggaran awal.
    categorySelect.addEventListener('change', filterMainViolations);

    // Klik tombol pada tabel siswa.
    studentsBox.addEventListener('click', function (event) {
        const row = event.target.closest('[data-student-id]');
        if (!row) return;

        const addButton = event.target.closest('[data-add-violation]');

        if (addButton) {
            openViolationModal(row);
            return;
        }

        const removeViolation = event.target.closest('[data-remove-violation]');

        if (removeViolation) {
            setViolation(row, removeViolation.dataset.removeViolation, false);
            return;
        }

        if (event.target.closest('[data-remove-student]')) {
            existingIds.delete(String(row.dataset.studentId));
            usedIndexes.delete(Number(row.dataset.index));
            row.remove();

            updateSummary();
            renderResults(currentResults);
        }
    });

    // Pilih kategori di modal.
    modalKategori.addEventListener('change', renderModalOptions);

    // Tambah pelanggaran dari modal.
    modalOptions.addEventListener('change', function (event) {
        const checkbox = event.target.closest('[data-modal-violation]');
        if (!checkbox || !activeRow) return;

        if (checkbox.checked) {
            setViolation(activeRow, checkbox.dataset.modalViolation, true);
            renderModalOptions();
        }
    });

    // Pencarian siswa.
    searchInput.addEventListener('input', function () {
        clearTimeout(searchTimer);

        const term = this.value.trim();
        const requestId = ++searchRequestId;

        if (term.length < 2) {
            resultsBox.classList.add('d-none');
            resultsBox.innerHTML = '';
            currentResults = [];
            return;
        }

        resultsBox.classList.remove('d-none');
        resultsBox.innerHTML =
            '<div class="p-3 text-secondary small">Mencari siswa...</div>';

        searchTimer = setTimeout(async function () {
            try {
                const url = new URL(
                    searchInput.dataset.url,
                    window.location.origin
                );

                url.searchParams.set('q', term);

                const response = await fetch(url, {
                    headers: { 'Accept': 'application/json' }
                });

                if (!response.ok) throw new Error('Pencarian gagal');
                

                const data = await response.json();

if (requestId !== searchRequestId) return;

const siswaList = Array.isArray(data)
    ? data
    : Array.isArray(data.data)
        ? data.data
        : null;

if (!siswaList) {
    throw new Error('Format respons pencarian siswa tidak valid.');
}

renderResults(siswaList);
            } catch (error) {
                if (requestId !== searchRequestId) return;

                resultsBox.innerHTML =
                    '<div class="p-3 text-danger small">Pencarian gagal. Coba lagi.</div>';
                resultsBox.classList.remove('d-none');
            }
        }, 250);
    });

    // Pilih siswa dari hasil pencarian.
    resultsBox.addEventListener('click', function (event) {
        const button = event.target.closest('[data-add-student]');
        if (!button || button.disabled) return;

        const siswa = currentResults.find(
            item => String(item.id) === String(button.dataset.addStudent)
        );

        if (siswa) addStudent(siswa);
    });

    // Validasi sebelum simpan.
    form.addEventListener('submit', function (event) {
        const rows = Array.from(
            studentsBox.querySelectorAll('[data-student-id]')
        );

        let invalidRow = null;

        rows.forEach(row => {
            const hasViolation = getSelectedIds(row).length > 0;
            const warning = row.querySelector('[data-no-violation]');

            if (!hasViolation) {
                warning?.classList.remove('d-none');
                invalidRow ??= row;
            } else {
                warning?.classList.add('d-none');
            }
        });

        if (rows.length === 0) {
            event.preventDefault();
            alert('Tambahkan minimal satu siswa.');
            searchInput.focus();
            return;
        }

        if (invalidRow) {
            event.preventDefault();
            invalidRow.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
            return;
        }

        saveButton.disabled = true;
        saveButton.innerHTML =
            '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';
    });

    // Inisialisasi siswa yang sudah dirender oleh Blade.
    studentsBox.querySelectorAll('[data-student-id]').forEach(row => {
        renderStudentRow(row);
    });

// Pulihkan kategori pelanggaran awal setelah validasi gagal.
if (oldMainViolation) {
    const oldViolation = violations.find(
        item => String(item.id) === String(oldMainViolation)
    );

    if (oldViolation) {
        const oldCategory = oldViolation.kategori || 'Lainnya';

        categorySelect.value = Array.from(categorySelect.options)
            .some(option => option.value === oldCategory)
                ? oldCategory
                : '';
    }
}

filterMainViolations();
updateSummary();
});
</script>
@endsection
