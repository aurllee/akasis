@extends('layouts.app')

@section('title', 'Penilaian PJBL ' . $kelas->tingkat . ' ' . $kelas->nama_kelas)

@push('styles')
<style>
    body {
        font-family: 'Poppins', sans-serif;
    }

    .academic-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        margin-bottom: 24px;
    }

    .academic-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f1f5f9;
        flex-wrap: wrap;
        gap: 12px;
    }

    .academic-header h1 {
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 4px 0;
    }

    .academic-header p {
        font-size: 13px;
        color: #64748b;
        margin: 0;
    }

    .btn-back-link {
        color: #64748b;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 12px;
        transition: color 0.2s;
    }

    .btn-back-link:hover {
        color: #2563eb;
    }

    .btn-action-primary {
        background: #2563eb;
        color: #ffffff;
        border: none;
        padding: 9px 16px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s;
    }

    .btn-action-primary:hover {
        background: #1d4ed8;
        color: #ffffff;
    }

    .btn-action-edit {
        background: #2563eb;
        color: #ffffff;
        border: 1px solid #2563eb;
        padding: 7px 11px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s;
    }

    .btn-action-edit:hover {
        background: #1d4ed8;
        border-color: #1d4ed8;
        color: #ffffff;
    }

    .btn-action-delete {
        background: #ffffff;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 7px 11px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-action-delete:hover {
        background: #f8fafc;
        border-color: #94a3b8;
    }

    .action-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .filter-section {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 20px;
    }

    .filter-field label {
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
        display: block;
    }

    .filter-field input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        background-color: #ffffff;
        font-size: 14px;
        color: #1e293b;
        outline: none;
        transition: all 0.2s;
    }

    .filter-field input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .sub-card {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 20px;
        background-color: #ffffff;
    }

    .sub-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .sub-card-title {
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .academic-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 13px;
    }

    .academic-table th {
        background-color: #f8fafc;
        color: #475569;
        font-weight: 600;
        padding: 10px 12px;
        border-bottom: 1px solid #e2e8f0;
        border-top: 1px solid #e2e8f0;
    }

    .academic-table td {
        padding: 12px;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
    }

    .academic-table tr:hover td {
        background-color: #f8fafc;
    }

    .badge-blue {
        background-color: rgba(37, 99, 235, 0.1);
        color: #2563eb;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-value {
        padding: 2px 8px;
        font-weight: 600;
        font-size: 14px;
    }

    .total-nilai-value {
        display: inline-block;
        min-width: 52px;
        padding: 2px 0;
        color: #1e293b;
        font-size: 14px;
        font-weight: 600;
        line-height: 1.4;
    }

    .nilai-kosong {
        color: #94a3b8;
    }

    @media (max-width: 768px) {
        .academic-card {
            padding: 18px;
        }

        .academic-header {
            flex-direction: column;
        }

        .academic-header .btn-action-primary {
            width: 100%;
            justify-content: center;
        }

        .academic-table {
            min-width: 850px;
        }
    }
</style>
@endpush


@section('content')

<div class="academic-container">

    {{-- KEMBALI --}}
    <a
        href="{{ route('admin.penilaian.pjbl.kelas', $kelas->id) }}"
        class="btn-back-link"
    >
        <i class="bi bi-arrow-left"></i>
        Kembali ke List PJBL
    </a>


    <div class="academic-card">

        {{-- HEADER --}}
        <div class="academic-header">

            <div>

                <h1>
                    Penilaian PJBL
                </h1>

                <p>
                    {{ $kelas->tingkat }}
                    {{ $kelas->nama_kelas }}

                    <span class="mx-1">—</span>

                    {{ $pjbl->nama_periode ?? 'PJBL' }}

                    <span class="mx-1">—</span>

                    {{ $pjbl->tanggal
                        ? \Carbon\Carbon::parse($pjbl->tanggal)->format('d/m/Y')
                        : '-'
                    }}
                </p>

            </div>


            <a
                href="{{ route('admin.penilaian.pjbl.create', [
                    'kelasId' => $kelas->id,
                    'pjblId' => $pjbl->id
                ]) }}"
                class="btn-action-primary"
            >
                <i class="bi bi-plus-lg"></i>
                Tambah Penilaian
            </a>

        </div>


        {{-- PENGUJI --}}
        <div class="sub-card">

            <div class="sub-card-header">

                <div>

                    <div class="sub-card-title">
                        Penguji PJBL
                    </div>

                    <small class="text-muted">
                        Penguji yang memberikan penilaian pada PJBL ini
                    </small>

                </div>

                <span class="badge-blue">
                    {{ $penguji->count() }} Penguji
                </span>

            </div>


            <div class="table-responsive">

                <table class="academic-table align-middle">

                    <thead>

                        <tr>
                            <th width="60">No</th>
                            <th>Nama Penguji</th>
                            <th>NIP</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($penguji as $p)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td class="fw-semibold">
                                    {{ $p->guru?->nama ?? '-' }}
                                </td>

                                <td>
                                    {{ $p->guru?->nip ?? '-' }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="3"
                                    class="text-center text-muted py-3"
                                >
                                    Belum ada data penguji PJBL.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- SEARCH --}}
        <div class="filter-section">

            <div class="row g-3 align-items-end">

                <div class="col-md-10 filter-field">

                    <label for="liveSearchSiswa">
                        Cari Siswa
                    </label>

                    <div class="input-group">

                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search"></i>
                        </span>

                        <input
                            type="text"
                            id="liveSearchSiswa"
                            class="form-control border-start-0 ps-0"
                            placeholder="Cari nama, NIS, atau NISN..."
                            autocomplete="off"
                        >

                    </div>

                </div>


                <div class="col-md-2">

                    <button
                        type="button"
                        id="resetSearch"
                        class="btn btn-outline-secondary w-100 py-2"
                        style="font-size: 13px; font-weight: 600;"
                    >
                        Reset
                    </button>

                </div>

            </div>

        </div>


        {{-- DATA PENILAIAN --}}
        <div class="sub-card">

            <div class="sub-card-header">

                <div>

                    <div class="sub-card-title">
                        Data Penilaian
                    </div>

                    <small class="text-muted">
                        Nilai berdasarkan masing-masing penguji PJBL
                    </small>

                </div>

                {{-- JUMLAH SEMUA SISWA --}}
                <span class="badge-blue">
                    {{ $kelas->siswaKelas->count() }} Siswa
                </span>

            </div>


            <div class="table-responsive">

                <table class="academic-table align-middle">

                    <thead>

                        <tr>

                            <th width="50">
                                No
                            </th>

                            <th style="min-width: 200px;">
                                Siswa
                            </th>

                            @foreach($penguji as $p)

                                <th
                                    class="text-center"
                                    style="min-width: 110px;"
                                >

                                    <div class="fw-semibold">
                                        Guru {{ $loop->iteration }}
                                    </div>

                                    <small
                                        class="text-muted"
                                        style="font-size: 11px;"
                                    >
                                        Nilai
                                    </small>

                                </th>

                            @endforeach

                            <th
                                class="text-center"
                                style="min-width: 100px;"
                            >
                                Total Nilai
                            </th>

                            <th
                                width="180"
                                class="text-center"
                            >
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody id="pjblTableBody">

                        @forelse($kelas->siswaKelas as $siswaKelas)

                            @php

                                /*
                                 * Ambil object siswa.
                                 * Sesuaikan jika relasi project memakai
                                 * nama yang berbeda.
                                 */
                                $siswa = $siswaKelas->siswa;

                                /*
                                 * Ambil seluruh nilai siswa.
                                 */
                                $nilaiSiswa = $penilaianPerSiswa
                                    ->get($siswa?->id, collect());

                                $totalNilai = 0;

                                /*
                                 * Ambil record pertama jika ada.
                                 */
                                $nilaiPertama = $nilaiSiswa->first();

                            @endphp


                            <tr
                                class="siswa-row"
                                data-search="{{ strtolower(
                                    ($siswa?->nama ?? '') . ' ' .
                                    ($siswa?->nis ?? '') . ' ' .
                                    ($siswa?->nisn ?? '')
                                ) }}"
                            >

                                {{-- NO --}}
                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                {{-- SISWA --}}
                                <td>

                                    <div class="fw-semibold">
                                        {{ $siswa?->nama ?? '-' }}
                                    </div>

                                    <small class="text-muted">
                                        NIS:
                                        {{ $siswa?->nis ?? '-' }}
                                    </small>

                                </td>


                                {{-- NILAI MASING-MASING PENGUJI --}}
                                @foreach($penguji as $p)

                                    @php

                                        $nilaiPenguji = $nilaiSiswa
                                            ->firstWhere(
                                                'pjbl_penguji_id',
                                                $p->id
                                            );

                                        $nilai = $nilaiPenguji?->nilai;

                                        if ($nilai !== null) {
                                            $totalNilai += (float) $nilai;
                                        }

                                    @endphp


                                    <td class="text-center">

                                        @if($nilaiPenguji)

                                            <span class="badge-value">
                                                {{ $nilaiPenguji->nilai }}
                                            </span>

                                        @else

                                            <span class="nilai-kosong">
                                                -
                                            </span>

                                        @endif

                                    </td>

                                @endforeach


                                {{-- TOTAL --}}
                                <td class="text-center">

                                    <span class="total-nilai-value">
                                        {{ $nilaiSiswa->isNotEmpty() ? $totalNilai : '--' }}
                                    </span>

                                </td>


                                {{-- AKSI --}}
                                <td class="text-center">

                                    <div class="action-wrapper">

                                        @if($nilaiPertama)
                                            <a
                                                href="{{ route('admin.penilaian.pjbl.edit', [
                                                    'kelasId' => $kelas->id,
                                                    'pjblId' => $pjbl->id,
                                                    'id' => $nilaiPertama->id
                                                ]) }}"
                                                class="btn-action-edit"
                                                title="Edit penilaian {{ $siswa?->nama }}"
                                            >
                                                <i class="bi bi-pencil"></i>
                                                Edit
                                            </a>
                                        @else
                                            <a
                                                href="{{ route('admin.penilaian.pjbl.create', [
                                                    'kelasId' => $kelas->id,
                                                    'pjblId' => $pjbl->id,
                                                    'siswa_id' => $siswa?->id
                                                ]) }}"
                                                class="btn-action-edit"
                                                title="Tambah penilaian {{ $siswa?->nama }}"
                                            >
                                                <i class="bi bi-plus-lg"></i>
                                                Tambah
                                            </a>
                                        @endif


                                        @if($nilaiPertama)
                                            <form
                                                action="{{ route('admin.penilaian.pjbl.destroy', [
                                                    'kelasId' => $kelas->id,
                                                    'pjblId' => $pjbl->id,
                                                    'id' => $nilaiPertama->id
                                                ]) }}"
                                                method="POST"
                                                style="display: inline;"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <input
                                                    type="hidden"
                                                    name="siswa_id"
                                                    value="{{ $siswa?->id }}"
                                                >
                                                <button
                                                    type="submit"
                                                    class="btn-action-delete"
                                                    title="Hapus penilaian {{ $siswa?->nama }}"
                                                    onclick="return confirm('Yakin ingin menghapus semua nilai PJBL siswa ini?')"
                                                >
                                                    <i class="bi bi-trash"></i>
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="{{ 4 + $penguji->count() }}"
                                    class="text-center text-muted py-4"
                                >

                                    <i class="bi bi-people fs-1"></i>

                                    <div class="mt-2">
                                        Belum ada siswa pada kelas ini.
                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection


@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput =
        document.getElementById('liveSearchSiswa');

    const resetButton =
        document.getElementById('resetSearch');

    const tableBody =
        document.getElementById('pjblTableBody');


    if (!searchInput || !tableBody) {
        return;
    }


    function filterSiswa() {

        const keyword =
            searchInput.value
                .toLowerCase()
                .trim();


        const rows =
            tableBody.querySelectorAll('.siswa-row');


        let visibleCount = 0;


        rows.forEach(function (row) {

            const searchData =
                (row.getAttribute('data-search') || '')
                    .toLowerCase();


            const cocok =
                keyword === '' ||
                searchData.includes(keyword);


            row.style.display =
                cocok ? '' : 'none';


            if (cocok) {
                visibleCount++;
            }

        });


        const oldEmpty =
            tableBody.querySelector('.live-search-empty');


        if (oldEmpty) {
            oldEmpty.remove();
        }


        if (rows.length > 0 && visibleCount === 0) {

            const emptyRow =
                document.createElement('tr');


            emptyRow.className =
                'live-search-empty';


            const jumlahKolom =
                tableBody
                    .querySelector('.siswa-row')
                    ?.querySelectorAll('td')
                    .length || 4;


            emptyRow.innerHTML = `
                <td colspan="${jumlahKolom}"
                    class="text-center text-muted py-4">

                    <i class="bi bi-search fs-1"></i>

                    <div class="mt-2">
                        Siswa tidak ditemukan.
                    </div>

                    <small>
                        Coba gunakan nama, NIS, atau NISN lain.
                    </small>

                </td>
            `;


            tableBody.appendChild(emptyRow);

        }

    }


    searchInput.addEventListener(
        'input',
        filterSiswa
    );


    if (resetButton) {

        resetButton.addEventListener(
            'click',
            function () {

                searchInput.value = '';

                filterSiswa();

                searchInput.focus();

            }
        );

    }

});
</script>

@endpush