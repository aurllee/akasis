@extends('layouts.app')

@section('title', 'Penilaian Harian ' . $mataPelajaran->nama_mapel)

@push('styles')
<style>
    body {
        font-family: 'Poppins', sans-serif;
        color: #1f2937;
        background: #f4f7fb;
    }

    .page-wrap {
        width: 100%;
    }

    .page-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(15, 23, 42, 0.04);
        padding: 24px;
    }

    .page-title {
        margin: 0 0 8px;
        font-size: 25px;
        font-weight: 600;
        color: #111827;
    }

    .page-subtitle {
        margin: 0;
        color: #64748b;
        font-size: 13px;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 20px;
        color: #64748b;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
    }

    .btn-back:hover {
        color: #2449a4;
    }

    .card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
        overflow: hidden;
    }

    .card-body {
        padding: 20px;
    }

    .card-body.p-0 {
        padding: 0;
    }

    .mb-3 {
        margin-bottom: 16px;
    }

    .mb-4 {
        margin-bottom: 24px;
    }

    .d-flex {
        display: flex;
    }

    .justify-content-between {
        justify-content: space-between;
    }

    .align-items-center {
        align-items: center;
    }

    .fw-bold {
        font-weight: 700;
    }

    .fw-semibold {
        font-weight: 600;
    }

    .text-muted {
        color: #64748b;
    }

    .text-center {
        text-align: center;
    }

    .text-start {
        text-align: left;
    }

    .text-end {
        text-align: right;
    }

    .row {
        display: flex;
        gap: 24px;
    }

    .col-md-4 {
        flex: 1;
    }

    .info-label {
        display: block;
        margin-bottom: 6px;
        font-size: 12px;
        color: #64748b;
    }

    .info-value {
        font-size: 14px;
        font-weight: 600;
        color: #111827;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 9px 14px;
        border-radius: 8px;
        text-decoration: none;
        cursor: pointer;
        font-size: 13px;
        font-weight: 500;
        border: 1px solid transparent;
        font-family: 'Poppins', sans-serif;
    }

    .btn-primary {
        background: #2449a4;
        color: #ffffff;
        border-color: #2449a4;
    }

    .btn-primary:hover {
        background: #1a3679;
        color: #ffffff;
    }

    .btn-action-edit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 7px 11px;
        border-radius: 8px;
        background: #2449a4;
        color: #ffffff;
        border: 1px solid #2449a4;
        text-decoration: none;
        font-size: 12px;
        font-weight: 500;
    }

    .btn-action-edit:hover {
        background: #1a3679;
        color: #ffffff;
    }

    .btn-action-delete {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 7px 11px;
        border-radius: 8px;
        background: #ffffff;
        color: #475569;
        border: 1px solid #cbd5e1;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
    }

    .btn-action-delete:hover {
        background: #f8fafc;
    }

    .action-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .search-card {
        margin-bottom: 20px;
    }

    .search-label {
        display: block;
        margin-bottom: 7px;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
    }

    .search-wrapper {
        display: flex;
        align-items: center;
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        background: #ffffff;
        overflow: hidden;
    }

    .search-icon {
        padding: 10px 12px;
        color: #64748b;
    }

    .search-input {
        width: 100%;
        padding: 10px 12px 10px 0;
        border: 0;
        outline: none;
        font-family: 'Poppins', sans-serif;
        font-size: 13px;
        color: #1f2937;
    }

    .search-input:focus {
        outline: none;
        box-shadow: none;
    }

    .badge-blue {
        display: inline-block;
        background: #eff6ff;
        color: #2449a4;
        border: 1px solid #bfdbfe;
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .table {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
        margin: 0;
    }

    .table th,
    .table td {
        border: 1px solid #dbe3ef;
        padding: 10px 12px;
        vertical-align: middle;
    }

    .table th {
        background: #eff6ff;
        color: #2449a4;
        font-size: 12px;
        font-weight: 600;
        text-align: center;
        white-space: nowrap;
    }

    .table td {
        font-size: 13px;
        color: #1f2937;
        background: #ffffff;
    }

    .table tbody tr:hover td {
        background: #f8fafc;
    }

    .table .student-name {
        font-weight: 600;
        color: #111827;
        white-space: nowrap;
    }

    .assessment-header {
        line-height: 1.4;
    }

    .assessment-header-title {
        display: block;
        font-size: 12px;
        font-weight: 600;
    }

    .assessment-header-date {
        display: block;
        margin-top: 3px;
        font-size: 11px;
        color: #64748b;
        font-weight: 500;
    }

    .nilai {
        text-align: center;
        font-weight: 500;
    }

    .empty-data {
        padding: 50px 20px !important;
        text-align: center;
        color: #64748b;
    }

    .empty-data i {
        font-size: 36px;
    }

    .empty-data h6 {
        margin: 12px 0 6px;
        font-size: 14px;
        color: #334155;
    }

    .empty-data p {
        margin: 0 0 16px;
        font-size: 13px;
    }

    @media (max-width: 768px) {
        .page-card {
            padding: 18px;
        }

        .row {
            flex-direction: column;
            gap: 14px;
        }

        .d-flex {
            align-items: flex-start;
            flex-direction: column;
            gap: 12px;
        }

        .table {
            min-width: 850px;
        }
    }
</style>
@endpush

@section('content')

@php
    $siswa = $penilaian
        ->filter(fn ($item) => $item->siswa)
        ->groupBy('siswa_id')
        ->map(fn ($items) => $items->first()->siswa)
        ->values();

    $jenisPenilaian = $penilaian
        ->groupBy(function ($item) {
            return implode('|', [
                $item->jenis_nilai,
                $item->tanggal_penilaian,
                $item->judul_tugas,
                $item->penilaian_ke
            ]);
        })
        ->map(fn ($items) => $items->first())
        ->values();
@endphp

<div class="page-wrap">

    <div class="page-card">

    <a
        href="{{ route('admin.penilaian.mapel.mapel', [
            'kelasId' => $kelas->id,
            'mapelId' => $mataPelajaran->id
        ]) }}"
        class="btn-back-link"
    >
        <i class="bi bi-arrow-left"></i>
        Kembali ke Jenis Penilaian
    </a>

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h1 class="page-title">
                    Penilaian Harian
                </h1>

                <p class="page-subtitle">
                    {{ $mataPelajaran->nama_mapel }}
                    —
                    {{ $kelas->tingkat }}
                    {{ $kelas->nama_kelas }}

                @if($kelas->jurusan)
                    — {{ $kelas->jurusan->nama_jurusan }}
                @endif
            </p>

            </div>

        <a
            href="{{ route('admin.penilaian.mapel.create', [
                'kelasId' => $kelas->id,
                'mapelId' => $mataPelajaran->id,
                'jenis_nilai' => 'harian'
            ]) }}"
            class="btn-action-primary"
        >
            <i class="bi bi-plus-lg"></i>
            Tambah Penilaian
        </a>

        </div>

    <div class="academic-card">
        <label for="searchHarian" class="form-label fw-semibold text-secondary">
            Cari Siswa
        </label>
        <div class="input-group">
            <span class="input-group-text bg-white">
                <i class="bi bi-search text-muted"></i>
            </span>
            <input
                type="search"
                id="searchHarian"
                class="form-control"
                placeholder="Nama, NIS, atau NISN"
                autocomplete="off"
            >
        </div>
    </div>

        <div class="d-flex justify-content-between align-items-center mb-3">

            <h5 class="fw-bold mb-0">
                Daftar Nilai Siswa
            </h5>

            <span class="badge-blue">
                Penilaian Harian
            </span>

        </div>

        <div class="card">

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table">

                        <thead>

                            <tr>

                <thead class="bg-light">

                    <tr>

                        <th class="ps-4">No</th>
                        <th>NIS</th>
                        <th>Siswa</th>
                        <th>Nilai</th>
                        <th>Tanggal</th>
                        <th class="text-end pe-4">Aksi</th>

                            </tr>

                        </thead>

                        <tbody id="harianTableBody">

                    @forelse($penilaian as $item)

                        <tr class="assessment-row" data-search="{{ strtolower(($item->siswa?->nama ?? '') . ' ' . ($item->siswa?->nis ?? '') . ' ' . ($item->siswa?->nisn ?? '')) }}">

                            <td class="ps-4">
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $item->siswa?->nis ?? '-' }}
                            </td>

                            <td class="fw-semibold">
                                {{ $item->siswa?->nama ?? '-' }}
                            </td>

                            <td>
                                <strong>
                                    {{ $item->nilai }}
                                </strong>
                            </td>

                            <td>

                                {{
                                    $item->tanggal_penilaian?->format('d/m/Y')
                                    ?? $item->created_at?->format('d/m/Y')
                                    ?? '-'
                                }}

                            </td>

                            <td class="text-end pe-4">

                                <div class="d-inline-flex gap-2">

                                    <a
                                        href="{{ route('admin.penilaian.mapel.edit', [
                                            'kelasId' => $kelas->id,
                                            'mapelId' => $mataPelajaran->id,
                                            'id' => $item->id
                                        ]) }}"
                                        class="btn-action-edit"
                                    >
                                        <i class="bi bi-pencil"></i>
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.penilaian.mapel.destroy', [
                                            'kelasId' => $kelas->id,
                                            'mapelId' => $mataPelajaran->id,
                                            'id' => $item->id
                                        ]) }}"
                                        method="POST"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn-action-delete"
                                            onclick="return confirm('Yakin ingin menghapus nilai ini?')"
                                        >
                                            <i class="bi bi-trash"></i>
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="text-center py-5">

                                <i class="bi bi-clipboard-x fs-1 text-muted"></i>

                                <h6 class="mt-3">
                                    Belum ada penilaian harian
                                </h6>

                                <p class="text-muted small">
                                    Belum ada data nilai harian.
                                </p>

                                <a
                                    href="{{ route('admin.penilaian.mapel.create', [
                                        'kelasId' => $kelas->id,
                                        'mapelId' => $mataPelajaran->id,
                                        'jenis_nilai' => 'harian'
                                    ]) }}"
                                    class="btn-action-primary"
                                >
                                    <i class="bi bi-plus-lg"></i>
                                    Tambah Penilaian
                                </a>

                            </td>

                        </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchHarian');
        const tableBody = document.getElementById('harianTableBody');

        if (!searchInput || !tableBody) {
            return;
        }

        searchInput.addEventListener('input', function () {
            const keyword = searchInput.value.trim().toLowerCase();

            const rows = tableBody.querySelectorAll('.student-row');

            let visibleCount = 0;

            rows.forEach(function (row) {
                const matches = !keyword || (row.dataset.search || '').includes(keyword);
                row.style.display = matches ? '' : 'none';

                if (matches) {
                    visibleCount++;
                }

            });

            const oldEmpty =
                tableBody.querySelector('.live-search-empty');

            if (oldEmpty) {
                oldEmpty.remove();
            }

            if (rows.length > 0 && visibleCount === 0) {

                const emptyRow = document.createElement('tr');

                emptyRow.className = 'live-search-empty';
                emptyRow.innerHTML = '<td colspan="6" class="text-center py-5"><i class="bi bi-search fs-1 text-muted"></i><h6 class="mt-3">Siswa tidak ditemukan</h6><p class="text-muted small mb-0">Coba kata kunci lain.</p></td>';
                tableBody.appendChild(emptyRow);
            }

        });

    });
</script>
@endpush