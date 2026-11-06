@extends('layouts.app')

@section('title', 'Data Calon Siswa')

@push('styles')
<style>
    .spmb-page {
        color: #1e293b;
        padding: 6px 0 30px;
    }

    .spmb-header {
        align-items: center;
        display: flex;
        gap: 20px;
        justify-content: space-between;
        margin-bottom: 24px;
    }

    .spmb-header h1 {
        color: #172033;
        font-size: 23px;
        font-weight: 700;
        margin: 0 0 5px;
    }

    .spmb-header p {
        color: #718096;
        font-size: 13px;
        margin: 0;
    }

    .spmb-add-button {
        align-items: center;
        background: #2563eb;
        border: 1px solid #2563eb;
        border-radius: 9px;
        color: #fff;
        display: inline-flex;
        font-size: 13px;
        font-weight: 600;
        gap: 8px;
        justify-content: center;
        padding: 11px 17px;
        text-decoration: none;
        white-space: nowrap;
    }

    .spmb-add-button:hover {
        background: #1d4ed8;
        color: #fff;
    }

    .spmb-card {
        background: #fff;
        border: 1px solid #e8edf5;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(15, 23, 42, .04);
        margin-bottom: 20px;
        overflow: hidden;
    }

    .spmb-card-header {
        align-items: center;
        background: #fbfcfe;
        border-bottom: 1px solid #edf1f6;
        display: flex;
        justify-content: space-between;
        padding: 17px 20px;
    }

    .spmb-card-header h2 {
        color: #263247;
        font-size: 15px;
        font-weight: 700;
        margin: 0 0 3px;
    }

    .spmb-card-header p {
        color: #8792a5;
        font-size: 11px;
        margin: 0;
    }

    .spmb-card-body {
        padding: 19px 20px 20px;
    }

    .spmb-label {
        color: #475569;
        display: block;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .spmb-control {
        background-color: #fff;
        border: 1px solid #dfe5ed;
        border-radius: 8px;
        color: #334155;
        font-size: 12px;
        min-height: 40px;
        width: 100%;
    }

    .spmb-control:focus {
        border-color: #7aa2ef;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .08);
        outline: 0;
    }

    .spmb-reset {
        background: #fff;
        border: 1px solid #dfe5ed;
        border-radius: 7px;
        color: #64748b;
        font-size: 12px;
        font-weight: 600;
        min-height: 40px;
        padding: 7px 12px;
        width: 100%;
    }

    .spmb-reset:hover {
        border-color: #2563eb;
        color: #2563eb;
    }

    .spmb-table-wrap {
        overflow-x: auto;
        width: 100%;
    }

    .spmb-table {
        border-collapse: collapse;
        min-width: 1000px;
        width: 100%;
    }

    .spmb-table th {
        background: #f8fafc;
        border-bottom: 1px solid #e7ecf3;
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .2px;
        padding: 13px 14px;
        text-align: left;
        white-space: nowrap;
    }

    .spmb-table td {
        border-bottom: 1px solid #edf1f5;
        color: #475569;
        font-size: 12px;
        padding: 13px 14px;
        vertical-align: middle;
    }

    .spmb-table tbody tr:hover {
        background: #fbfdff;
    }

    .spmb-number {
        align-items: center;
        background: #f1f5f9;
        border-radius: 6px;
        color: #64748b;
        display: inline-flex;
        font-size: 11px;
        font-weight: 600;
        height: 26px;
        justify-content: center;
        min-width: 26px;
        padding: 0 6px;
    }

    .spmb-registration {
        color: #2563eb;
        font-weight: 700;
        white-space: nowrap;
    }

    .spmb-student {
        align-items: center;
        display: flex;
        gap: 9px;
        min-width: 190px;
    }

    .spmb-avatar {
        align-items: center;
        background: #eaf2ff;
        border-radius: 8px;
        color: #2563eb;
        display: inline-flex;
        flex: 0 0 32px;
        font-size: 12px;
        font-weight: 700;
        height: 32px;
        justify-content: center;
    }

    .spmb-student-name {
        color: #263247;
        font-weight: 600;
    }

    .spmb-secondary {
        color: #64748b;
        display: block;
        font-size: 11px;
        margin-top: 3px;
    }

    .spmb-badge {
        border-radius: 6px;
        display: inline-flex;
        font-size: 10px;
        font-weight: 600;
        padding: 5px 9px;
        white-space: nowrap;
    }

    .spmb-status-verified {
        background: #ecfdf3;
        color: #15803d;
    }

    .spmb-status-revision {
        background: #fef2f2;
        color: #dc2626;
    }

    .spmb-status-waiting {
        background: #fffbeb;
        color: #b45309;
    }

    .spmb-status-unregistered {
        background: #f1f5f9;
        color: #64748b;
    }

    .spmb-actions {
        display: flex;
        gap: 6px;
        white-space: nowrap;
    }

    .spmb-action {
        align-items: center;
        border-radius: 6px;
        display: inline-flex;
        font-size: 11px;
        font-weight: 600;
        gap: 5px;
        justify-content: center;
        min-height: 32px;
        padding: 0 9px;
        text-decoration: none;
    }

    .spmb-action-detail {
        background: #eff6ff;
        border: 1px solid #dbeafe;
        color: #2563eb;
    }

    .spmb-action-detail:hover {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .spmb-action-edit {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #475569;
    }

    .spmb-action-edit:hover {
        background: #f1f5f9;
        color: #1e293b;
    }

    .spmb-empty {
        color: #64748b;
        padding: 48px 20px !important;
        text-align: center;
    }

    .spmb-empty i {
        color: #94a3b8;
        display: block;
        font-size: 28px;
        margin-bottom: 10px;
    }

    .spmb-pagination {
        background: #fbfcfe;
        border-top: 1px solid #edf1f6;
        display: flex;
        justify-content: flex-end;
        padding: 14px 20px;
    }

    .spmb-pagination nav {
        max-width: 100%;
    }

    #spmb-search-results.loading {
        opacity: .55;
        pointer-events: none;
        transition: opacity .2s ease;
    }

    @media (max-width: 768px) {
        .spmb-page {
            padding-top: 2px;
        }

        .spmb-header {
            align-items: stretch;
            flex-direction: column;
        }

        .spmb-add-button {
            width: 100%;
        }

        .spmb-card-header,
        .spmb-card-body {
            padding: 16px;
        }

        .spmb-pagination {
            justify-content: center;
            padding: 13px 15px;
        }
    }
</style>
@endpush

@section('content')
<div class="spmb-page">
    <div class="spmb-header">
        <div>
            <h1>Data Calon Siswa</h1>
            <p>Pengelolaan data calon siswa SPMB berdasarkan jurusan.</p>
        </div>
        <a href="{{ route('admin.spmb.create') }}" class="spmb-add-button">
            <i class="bi bi-plus-lg" aria-hidden="true"></i>
            Tambah Calon Siswa
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    <form id="spmbFilterForm" action="{{ route('admin.spmb.index') }}" method="GET">
        <div class="spmb-card">
            <div class="spmb-card-header">
                <div>
                    <h2>Filter Data</h2>
                    <p>Cari dan saring calon siswa berdasarkan data pendaftaran.</p>
                </div>
                <i class="bi bi-funnel text-primary" aria-hidden="true"></i>
            </div>
            <div class="spmb-card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-4 col-md-6">
                        <label for="spmbSearch" class="spmb-label">Cari calon siswa</label>
                        <input
                            type="search"
                            id="spmbSearch"
                            name="search"
                            class="form-control spmb-control"
                            value="{{ request('search') }}"
                            placeholder="Nama, nomor pendaftaran, NISN, atau NIK"
                            autocomplete="off"
                        >
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label for="spmbJurusan" class="spmb-label">Jurusan</label>
                        <select id="spmbJurusan" name="jurusan_id" class="form-select spmb-control">
                            <option value="">Semua jurusan</option>
                            @foreach ($jurusan as $item)
                                <option value="{{ $item->id }}" @selected((string) request('jurusan_id') === (string) $item->id)>
                                    {{ $item->nama_jurusan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label for="spmbJalur" class="spmb-label">Jalur pendaftaran</label>
                        <select id="spmbJalur" name="jalur_pendaftaran" class="form-select spmb-control">
                            <option value="">Semua jalur</option>
                            @foreach (['Domisili', 'Prestasi', 'Afirmasi', 'Mutasi'] as $jalur)
                                <option value="{{ $jalur }}" @selected(request('jalur_pendaftaran') === $jalur)>
                                    {{ $jalur }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label for="spmbStatus" class="spmb-label">Status daftar ulang</label>
                        <select id="spmbStatus" name="status_daftar_ulang" class="form-select spmb-control">
                            <option value="">Semua status</option>
                            <option value="belum_daftar_ulang" @selected(request('status_daftar_ulang') === 'belum_daftar_ulang')>Belum daftar ulang</option>
                            <option value="menunggu_verifikasi" @selected(request('status_daftar_ulang') === 'menunggu_verifikasi')>Menunggu verifikasi</option>
                            <option value="revisi" @selected(request('status_daftar_ulang') === 'revisi')>Perlu revisi</option>
                            <option value="terverifikasi" @selected(request('status_daftar_ulang') === 'terverifikasi')>Terverifikasi</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <button type="button" id="resetSpmb" class="spmb-reset">
                            <i class="bi bi-arrow-counterclockwise" aria-hidden="true"></i>
                            Reset filter
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div id="spmb-search-results" aria-live="polite">
        <div class="spmb-card">
            <div class="spmb-card-header">
                <div>
                    <h2>Daftar Calon Siswa</h2>
                    <p>Menampilkan {{ $calonSiswa->count() }} dari {{ $calonSiswa->total() }} calon siswa.</p>
                </div>
                <span class="spmb-badge spmb-status-unregistered">
                    {{ $calonSiswa->total() }} data
                </span>
            </div>
            <div class="spmb-table-wrap">
                <table class="spmb-table">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Nomor pendaftaran</th>
                            <th scope="col">Nama calon siswa</th>
                            <th scope="col">Jurusan</th>
                            <th scope="col">Jalur</th>
                            <th scope="col">Status daftar ulang</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($calonSiswa as $calon)
                            @php
                                $statusDaftarUlang = $calon->status_daftar_ulang ?? 'belum_daftar_ulang';
                                $statusDaftarUlangText = match ($statusDaftarUlang) {
                                    'terverifikasi' => 'Terverifikasi',
                                    'menunggu_verifikasi' => 'Menunggu verifikasi',
                                    'revisi' => 'Perlu revisi',
                                    default => 'Belum daftar ulang',
                                };
                                $statusDaftarUlangClass = match ($statusDaftarUlang) {
                                    'terverifikasi' => 'spmb-status-verified',
                                    'menunggu_verifikasi' => 'spmb-status-waiting',
                                    'revisi' => 'spmb-status-revision',
                                    default => 'spmb-status-unregistered',
                                };
                            @endphp
                            <tr>
                                <td><span class="spmb-number">{{ $calonSiswa->firstItem() + $loop->index }}</span></td>
                                <td class="spmb-registration">{{ $calon->no_pendaftaran ?? '-' }}</td>
                                <td>
                                    <div class="spmb-student">
                                        <span class="spmb-avatar" aria-hidden="true">{{ strtoupper(substr($calon->nama_lengkap ?? '?', 0, 1)) }}</span>
                                        <span>
                                            <span class="spmb-student-name">{{ $calon->nama_lengkap }}</span>
                                            <span class="spmb-secondary">NISN: {{ $calon->nisn ?: '-' }}</span>
                                        </span>
                                    </div>
                                </td>
                                <td>{{ $calon->jurusan?->nama_jurusan ?? '-' }}</td>
                                <td><span class="spmb-badge spmb-status-unregistered">{{ $calon->jalur_pendaftaran ?: '-' }}</span></td>
                                <td>
                                    <span class="spmb-badge {{ $statusDaftarUlangClass }}">
                                        {{ $statusDaftarUlangText }}
                                    </span>
                                </td>
                                <td>
                                    <div class="spmb-actions">
                                        <a href="{{ route('admin.spmb.show', $calon->id) }}" class="spmb-action spmb-action-detail">
                                            <i class="bi bi-eye" aria-hidden="true"></i>
                                            Detail
                                        </a>
                                        <a href="{{ route('admin.spmb.edit', $calon->id) }}" class="spmb-action spmb-action-edit">
                                            <i class="bi bi-pencil" aria-hidden="true"></i>
                                            Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="spmb-empty">
                                    <i class="bi bi-people" aria-hidden="true"></i>
                                    Tidak ada calon siswa yang cocok dengan filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($calonSiswa->hasPages())
                <div class="spmb-pagination">
                    {{ $calonSiswa->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

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

        async function loadData(url, updateHistory = true) {
            const targetUrl = url || (() => {
                const params = new URLSearchParams(new FormData(form));
                return `${form.action}?${params.toString()}`;
            })();

            results.classList.add('loading');

            try {
                const response = await fetch(targetUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html'
                    }
                });

                if (!response.ok) {
                    throw new Error(`Permintaan gagal dengan status ${response.status}.`);
                }

                const html = await response.text();
                const documentFromResponse = new DOMParser().parseFromString(html, 'text/html');
                const updatedResults = documentFromResponse.querySelector('#spmb-search-results');

                if (!updatedResults) {
                    throw new Error('Bagian hasil calon siswa tidak ditemukan pada respons.');
                }

                results.innerHTML = updatedResults.innerHTML;

                const params = new URL(targetUrl, window.location.origin).searchParams;
                ['search', 'jurusan_id', 'jalur_pendaftaran', 'status_daftar_ulang'].forEach(function (name) {
                    const input = form.elements.namedItem(name);
                    if (input) {
                        input.value = params.get(name) || '';
                    }
                });

                if (updateHistory) {
                    window.history.pushState({}, '', targetUrl);
                }
            } catch (error) {
                console.error('Gagal memuat daftar calon siswa:', error);
                results.insertAdjacentHTML(
                    'afterbegin',
                    '<div class="alert alert-danger" role="alert">Data calon siswa gagal dimuat. Silakan coba lagi.</div>'
                );
            } finally {
                results.classList.remove('loading');
            }
        }

        if (searchInput) {
            searchInput.addEventListener('input', function () {
                window.clearTimeout(searchTimeout);
                searchTimeout = window.setTimeout(function () {
                    loadData();
                }, 400);
            });
        }

        form.querySelectorAll('select').forEach(function (select) {
            select.addEventListener('change', function () {
                loadData();
            });
        });

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            loadData();
        });

        if (resetButton) {
            resetButton.addEventListener('click', function () {
                form.reset();
                loadData();
            });
        }

        results.addEventListener('click', function (event) {
            const link = event.target.closest('.pagination a');

            if (!link || link.origin !== window.location.origin) {
                return;
            }

            event.preventDefault();
            loadData(link.href);
        });

        window.addEventListener('popstate', function () {
            loadData(window.location.href, false);
        });
    });
</script>
@endpush
