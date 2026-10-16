
@extends('layouts.app')

@section('title', 'Pencatatan Tatib')

@section('content')
    <div class="container-fluid tatib-page py-3">

        {{-- HEADER --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h4 class="fw-bold mb-1">Pencatatan Tatib</h4>
                <p class="text-secondary mb-0">
                    Catat pelanggaran beberapa siswa dalam satu kali pengisian.
                </p>
            </div>

            <a href="{{ route('tatib.riwayat') }}" class="btn btn-outline-secondary">
                <i class="bi bi-clock-history me-1"></i> Riwayat
            </a>
        </div>

        {{-- ERROR VALIDASI --}}
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
                                Isi tanggal sekali. Pelanggaran utama menjadi pilihan awal
                                untuk siswa yang baru ditambahkan.
                            </p>
                        </div>
                    </div>

                    <div class="row g-3 align-items-start">
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
                                Kategori
                            </label>

                            <select id="kategori" class="form-select">
                                <option value="">-- Semua kategori --</option>

                                @foreach (($jenisPelanggaran->map(fn ($jenis) => $jenis->kategori ?: 'Lainnya')->unique()->sort()->values()) as $kategori)
                                    <option value="{{ $kategori }}">{{ $kategori }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="pelanggaranUtama" class="form-label fw-semibold">
                                Pelanggaran Utama
                            </label>

                            <select id="pelanggaranUtama"
                                    name="pelanggaran_utama"
                                    class="form-select">
                                <option value="">-- Tidak menggunakan pelanggaran utama --</option>

                                @foreach ($jenisPelanggaran as $jenis)
                                    <option value="{{ $jenis->id }}"
                                        @selected((string) old('pelanggaran_utama') === (string) $jenis->id)>
                                        {{ $jenis->jenis_pelanggaran }}
                                        ({{ $jenis->poin_pelanggaran }} poin)
                                    </option>
                                @endforeach
                            </select>

                            <div class="form-text">
                                Hanya siswa yang baru ditambahkan yang otomatis mendapat
                                pilihan ini. Siswa yang sudah ada tidak berubah.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- PENCARIAN DAN DAFTAR SISWA --}}
            <div class="card tatib-card mb-4">
                <div class="card-body p-4">

                    <div class="section-title mb-4">
                        <span class="number">2</span>
                        <div>
                            <h5 class="fw-bold mb-1">Pilih Siswa</h5>
                            <p class="text-secondary small mb-0">
                                Cari siswa berdasarkan nama atau NIS, lalu tekan Pilih.
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

                    <div class="d-flex justify-content-between align-items-center gap-2 mt-4 mb-2">
                        <h6 class="fw-bold mb-0">Daftar siswa yang dicatat</h6>

                        <span class="badge text-bg-primary" id="jumlahSiswa">
                            {{ $selectedSiswa->count() }} siswa
                        </span>
                    </div>

                    <div id="daftarSiswa">
                        @foreach ($selectedSiswa as $index => $siswa)
                            @php
                                $oldRow = collect($oldSiswa ?? [])
                                    ->first(fn($row) =>
                                        (string) ($row['id'] ?? '') === (string) $siswa->id
                                    );

                                $chosenIds = collect($oldRow['pelanggaran'] ?? [])
                                    ->map(fn($id) => (string) $id)
                                    ->all();
                            @endphp

                            <div class="student-card mb-3"
                                 data-student-id="{{ $siswa->id }}"
                                 data-index="{{ $index }}">

                                <div class="student-heading">
                                    <div>
                                        <div class="fw-bold">{{ $siswa->nama }}</div>
                                        <small class="text-secondary">
                                            NIS: {{ $siswa->nis }}
                                        </small>
                                    </div>

                                    <button type="button"
                                            class="btn btn-sm btn-outline-danger"
                                            data-remove-student>
                                        <i class="bi bi-trash me-1"></i> Hapus siswa
                                    </button>
                                </div>

                                <input type="hidden"
                                       name="siswa[{{ $index }}][id]"
                                       value="{{ $siswa->id }}">

                                <div class="student-violations">
                                    <div class="small fw-semibold mb-2">
                                        Pelanggaran siswa ini
                                    </div>

                                    <div class="row g-2">
                                        @foreach ($jenisPelanggaran->groupBy(fn($item) => $item->kategori ?: 'Lainnya') as $kategori => $items)
                                            <div class="col-12">
                                                <h6 class="fw-bold mt-3 mb-2">
                                                    {{ $kategori }}
                                                </h6>

                                                <div class="row g-2">
                                                    @foreach ($items as $jenis)
                                                        <div class="col-md-6">
                                                            <label class="violation-option">
                                                                <input type="checkbox"
                                                                       name="siswa[{{ $index }}][pelanggaran][]"
                                                                       value="{{ $jenis->id }}"
                                                                       @checked(in_array((string) $jenis->id, $chosenIds, true))>

                                                                <span>
                                                                    <span class="d-block fw-medium">
                                                                        {{ $jenis->jenis_pelanggaran }}
                                                                    </span>
                                                                    <small class="text-secondary">
                                                                        {{ $jenis->poin_pelanggaran }} poin
                                                                    </small>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="small text-danger mt-2 d-none"
                                         data-no-violation>
                                        Pilih minimal satu pelanggaran untuk siswa ini.
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div id="pesanKosong"
                         class="empty-state {{ $selectedSiswa->isNotEmpty() ? 'd-none' : '' }}">
                        <i class="bi bi-person-plus fs-3 d-block mb-2"></i>
                        Belum ada siswa. Cari dan pilih siswa di atas.
                    </div>
                </div>
            </div>

            {{-- RINGKASAN DAN TOMBOL --}}
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
                                <i class="bi bi-check2-circle me-1"></i>
                                Simpan Semua
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- CSS --}}
    <style>
        .tatib-page {
            color: #1f2937;
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

        .student-card {
            border: 1px solid #dfe5ef;
            border-radius: 12px;
            overflow: hidden;
        }

        .student-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            padding: 14px;
            background: #f8faff;
            border-bottom: 1px solid #e5eaf2;
        }

        .student-violations {
            padding: 14px;
        }

        .violation-option {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            width: 100%;
            height: 100%;
            padding: 12px;
            border: 1px solid #e5e7eb;
            border-radius: 9px;
            cursor: pointer;
            transition: background .15s, border-color .15s;
        }

        .violation-option:has(input:checked) {
            background: #f1f5ff;
            border-color: #9bb3f4;
        }

        .violation-option input {
            margin-top: 4px;
            accent-color: #2449a4;
            flex: 0 0 auto;
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

            .student-heading {
                align-items: flex-start;
            }
        }
    </style>

    {{-- JAVASCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('cariSiswa');
            const resultsBox = document.getElementById('hasilSiswa');
            const studentsBox = document.getElementById('daftarSiswa');
            const emptyBox = document.getElementById('pesanKosong');
            const mainViolation = document.getElementById('pelanggaranUtama');
            const categorySelect = document.getElementById('kategori');
            const countBox = document.getElementById('jumlahSiswa');
            const studentSummary = document.getElementById('ringkasanSiswa');
            const violationSummary = document.getElementById('ringkasanPelanggaran');
            const form = document.getElementById('formTatib');
            const saveButton = document.getElementById('tombolSimpan');

            // Data pelanggaran sudah disiapkan oleh controller.
            // Js::from mengubah data PHP menjadi ekspresi JavaScript yang aman.
            const violations = {{ Illuminate\Support\Js::from($violations) }};

            const existingIds = new Set(
                Array.from(studentsBox.querySelectorAll('[data-student-id]'))
                    .map(row => String(row.dataset.studentId))
            );

            const usedIndexes = new Set(
                Array.from(studentsBox.querySelectorAll('[data-student-id]'))
                    .map(row => Number(row.dataset.index))
                    .filter(Number.isInteger)
            );

            function getNextIndex() {
                let index = 0;

                while (usedIndexes.has(index)) {
                    index++;
                }

                usedIndexes.add(index);
                return index;
            }

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

            function filterMainViolations() {
                const selectedCategory = categorySelect.value;

                mainViolation.innerHTML =
                    '<option value="">-- Tidak menggunakan pelanggaran utama --</option>';

                const filtered = selectedCategory
                    ? violations.filter(function (item) {
                        return (item.kategori || 'Lainnya') === selectedCategory;
                    })
                    : violations;

                filtered.forEach(function (item) {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.nama + ' (' + item.poin + ' poin)';
                    mainViolation.appendChild(option);
                });
            }

            categorySelect.addEventListener('change', filterMainViolations);

            function updateSummary() {
                const rows = Array.from(
                    studentsBox.querySelectorAll('[data-student-id]')
                );

                const checkedCount = studentsBox.querySelectorAll(
                    'input[type="checkbox"][name*="[pelanggaran]"]:checked'
                ).length;

                countBox.textContent = rows.length + ' siswa';
                studentSummary.textContent = rows.length + ' siswa dipilih';
                violationSummary.textContent =
                    checkedCount + ' catatan pelanggaran dipilih';

                emptyBox.classList.toggle('d-none', rows.length > 0);
            }

            function renderResults(items) {
                currentResults = items;

                if (!items.length) {
                    resultsBox.innerHTML =
                        '<div class="p-3 text-secondary small">Siswa tidak ditemukan.</div>';

                    resultsBox.classList.remove('d-none');
                    return;
                }

                resultsBox.innerHTML = items.map(function (siswa) {
                    const alreadyAdded = existingIds.has(String(siswa.id));

                    return `
                        <div class="search-result">
                            <div>
                                <div class="fw-semibold">
                                    ${escapeHtml(siswa.nama)}
                                </div>
                                <small class="text-secondary">
                                    NIS: ${escapeHtml(siswa.nis)}
                                </small>
                            </div>

                            <button type="button"
                                    class="btn btn-sm ${alreadyAdded ? 'btn-light border' : 'btn-outline-primary'}"
                                    data-add-student="${escapeHtml(siswa.id)}"
                                    ${alreadyAdded ? 'disabled' : ''}>
                                ${alreadyAdded ? 'Sudah dipilih' : 'Pilih'}
                            </button>
                        </div>
                    `;
                }).join('');

                resultsBox.classList.remove('d-none');
            }

            function addStudent(siswa) {
                const id = String(siswa.id);

                if (existingIds.has(id)) {
                    return;
                }

                const index = getNextIndex();
                const defaultViolation = String(mainViolation.value || '');

                const groupedViolations = {};

                violations.forEach(function (item) {
                    const category = item.kategori || 'Lainnya';

                    if (!groupedViolations[category]) {
                        groupedViolations[category] = [];
                    }

                    groupedViolations[category].push(item);
                });

                const checkboxes = Object.entries(groupedViolations)
                    .sort(([a], [b]) => a.localeCompare(b))
                    .map(function ([category, items]) {
                        const options = items.map(function (item) {
                            const checked =
                                defaultViolation === String(item.id) ? 'checked' : '';

                            return `
                                <div class="col-md-6">
                                    <label class="violation-option">
                                        <input type="checkbox"
                                               name="siswa[${index}][pelanggaran][]"
                                               value="${escapeHtml(item.id)}"
                                               ${checked}>

                                        <span>
                                            <span class="d-block fw-medium">
                                                ${escapeHtml(item.nama)}
                                            </span>
                                            <small class="text-secondary">
                                                ${escapeHtml(item.poin)} poin
                                            </small>
                                        </span>
                                    </label>
                                </div>
                            `;
                        }).join('');

                        return `
                            <div class="col-12">
                                <h6 class="fw-bold mt-3 mb-2">
                                    ${escapeHtml(category)}
                                </h6>
                                <div class="row g-2">${options}</div>
                            </div>
                        `;
                    }).join('');

                const row = document.createElement('div');

                row.className = 'student-card mb-3';
                row.dataset.studentId = id;
                row.dataset.index = index;

                row.innerHTML = `
                    <div class="student-heading">
                        <div>
                            <div class="fw-bold">
                                ${escapeHtml(siswa.nama)}
                            </div>
                            <small class="text-secondary">
                                NIS: ${escapeHtml(siswa.nis)}
                            </small>
                        </div>

                        <button type="button"
                                class="btn btn-sm btn-outline-danger"
                                data-remove-student>
                            <i class="bi bi-trash me-1"></i> Hapus siswa
                        </button>
                    </div>

                    <input type="hidden"
                           name="siswa[${index}][id]"
                           value="${escapeHtml(id)}">

                    <div class="student-violations">
                        <div class="small fw-semibold mb-2">
                            Pelanggaran siswa ini
                        </div>

                        <div class="row g-2">
                            ${checkboxes}
                        </div>

                        <div class="small text-danger mt-2 d-none"
                             data-no-violation>
                            Pilih minimal satu pelanggaran untuk siswa ini.
                        </div>
                    </div>
                `;

                studentsBox.appendChild(row);
                existingIds.add(id);

                updateSummary();
                renderResults(currentResults);
            }

            // PENCARIAN SISWA
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
                            headers: {
                                'Accept': 'application/json'
                            }
                        });

                        if (!response.ok) {
                            throw new Error('Pencarian gagal');
                        }

                        const data = await response.json();

                        if (requestId !== searchRequestId) {
                            return;
                        }

                        renderResults(data);
                    } catch (error) {
                        if (requestId !== searchRequestId) {
                            return;
                        }

                        resultsBox.innerHTML =
                            '<div class="p-3 text-danger small">Pencarian gagal. Coba lagi.</div>';

                        resultsBox.classList.remove('d-none');
                    }
                }, 250);
            });

            // TAMBAH SISWA DARI HASIL PENCARIAN
            resultsBox.addEventListener('click', function (event) {
                const button = event.target.closest('[data-add-student]');

                if (!button || button.disabled) {
                    return;
                }

                const siswa = currentResults.find(
                    item => String(item.id) === String(button.dataset.addStudent)
                );

                if (!siswa) {
                    return;
                }

                addStudent(siswa);
            });

            // HAPUS SISWA
            studentsBox.addEventListener('click', function (event) {
                const button = event.target.closest('[data-remove-student]');

                if (!button) {
                    return;
                }

                const row = button.closest('[data-student-id]');

                if (!row) {
                    return;
                }

                existingIds.delete(String(row.dataset.studentId));
                row.remove();

                updateSummary();
                renderResults(currentResults);
            });

            // PERUBAHAN CHECKBOX
            studentsBox.addEventListener('change', function (event) {
                if (!event.target.matches('input[type="checkbox"]')) {
                    return;
                }

                const row = event.target.closest('[data-student-id]');
                const warning = row?.querySelector('[data-no-violation]');

                if (warning) {
                    const hasChecked = row.querySelector(
                        'input[name*="[pelanggaran]"]:checked'
                    );

                    warning.classList.toggle('d-none', Boolean(hasChecked));
                }

                updateSummary();
            });

            // VALIDASI SEBELUM SIMPAN
            form.addEventListener('submit', function (event) {
                const rows = Array.from(
                    studentsBox.querySelectorAll('[data-student-id]')
                );

                let invalidRow = null;

                rows.forEach(function (row) {
                    const hasViolation = row.querySelector(
                        'input[name*="[pelanggaran]"]:checked'
                    );

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

            filterMainViolations();

            // RINGKASAN AWAL
            updateSummary();
        });
    </script>
@endsection
