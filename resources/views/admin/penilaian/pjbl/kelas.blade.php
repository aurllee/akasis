@extends('layouts.app')

@section('title', 'PJBL ' . $kelas->tingkat . ' ' . $kelas->nama_kelas)

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
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f1f5f9;
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

        .filter-field select,
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

        .filter-field select:focus,
        .filter-field input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .item-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 20px;
            text-decoration: none;
            display: block;
            transition: all 0.2s ease-in-out;
            height: 100%;
        }

        .item-card:hover {
            border-color: #2563eb;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.08);
            transform: translateY(-2px);
        }

        .item-icon {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            background-color: rgba(37, 99, 235, 0.1);
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .item-title {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .item-subtitle {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 12px;
        }

        .item-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: #64748b;
            padding-top: 12px;
            border-top: 1px solid #f1f5f9;
        }

        .badge-academic {
            background-color: #f1f5f9;
            color: #334155;
            border: 1px solid #e2e8f0;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }
    </style>
@endpush

@section('content')
    <div class="academic-container">
        <a href="{{ route('admin.penilaian.pjbl.index') }}" class="btn-back-link">
            <i class="bi bi-arrow-left"></i> Kembali ke Kelas
        </a>

        <div class="academic-card">
            <div class="academic-header">
                <h1>PJBL {{ $kelas->tingkat }} {{ $kelas->nama_kelas }}</h1>
                <p>{{ $kelas->jurusan?->nama_jurusan ?? 'Umum' }} — Pilih periode PJBL</p>
            </div>

            <div class="filter-section">
                <div class="row g-3 align-items-end">
                    <div class="col-md-5 filter-field">
                        <label for="searchPjbl">Cari Periode PJBL</label>
                        <div class="input-group">
                            <input type="text" id="searchPjbl" class="border-start-0 ps-0"
                                placeholder="Cari Ganjil, Genap, SMT 1, SMT 2..." autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-3 filter-field">
                        <label for="filterTanggal">Tanggal PJBL</label>
                        <input type="date" id="filterTanggal">
                    </div>

                    <div class="col-md-2 filter-field">
                        <label for="filterTahun">Tahun Ajaran</label>
                        <select id="filterTahun">
                            <option value="">Semua Tahun</option>
                            @foreach($pjbl->pluck('tahunAjaran')->filter()->unique('id') as $tahun)
                                <option value="{{ $tahun->id }}">
                                    {{ $tahun->tahun_ajaran ?? $tahun->tahun ?? $tahun->nama ?? $tahun->nama_tahun ?? $tahun->id }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="button" id="resetFilter" class="btn btn-outline-secondary w-100 py-2"
                            style="font-size: 13px; font-weight: 600;">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                        </button>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <small class="text-muted">
                    Menampilkan <span id="jumlahPjbl" class="fw-semibold text-dark">{{ $pjbl->count() }}</span> periode PJBL
                </small>
            </div>

            <div class="row g-4" id="pjblContainer">
                @forelse($pjbl as $p)
                    @php
                        $namaPeriode = strtolower(trim($p->nama_periode ?? ''));

                        if (str_contains($namaPeriode, 'ganjil') || str_contains($namaPeriode, 'semester 1') || str_contains($namaPeriode, 'smt 1')) {
                            $semester = 'Ganjil';
                        } elseif (str_contains($namaPeriode, 'genap') || str_contains($namaPeriode, 'semester 2') || str_contains($namaPeriode, 'smt 2')) {
                            $semester = 'Genap';
                        } else {
                            $semester = 'Ganjil';
                        }

                        if (str_contains($namaPeriode, 'smt 2') || str_contains($namaPeriode, 'semester 2')) {
                            $smt = 'SMT 2';
                        } else {
                            $smt = 'SMT 1';
                        }

                        $periodeDisplay = 'PJBL ' . $semester . ' ' . $smt;

                        $searchText = strtolower(
                            $periodeDisplay . ' ' .
                            ($p->nama_periode ?? '') . ' ' .
                            ($p->tanggal ?? '')
                        );

                        $tanggalDisplay = $p->tanggal
                            ? \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y')
                            : '-';

                        $tanggalFilter = $p->tanggal
                            ? \Carbon\Carbon::parse($p->tanggal)->format('Y-m-d')
                            : '';
                    @endphp

                    <div class="col-xl-3 col-lg-4 col-md-6 pjbl-card" data-search="{{ $searchText }}"
                        data-tahun="{{ $p->tahunAjaran?->id ?? '' }}" data-tanggal="{{ $tanggalFilter }}">
                        <a href="{{ route('admin.penilaian.pjbl.penilaian', ['kelasId' => $kelas->id, 'pjblId' => $p->id]) }}"
                            class="item-card">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="item-icon">
                                    <i class="bi bi-kanban-fill"></i>
                                </div>
                                <i class="bi bi-arrow-right text-muted"></i>
                            </div>

                            <div class="item-title">
                                {{ $periodeDisplay }}
                            </div>

                            <div class="item-subtitle">
                                <i class="bi bi-calendar3 me-1"></i> {{ $tanggalDisplay }}
                            </div>

                            <div class="mb-3">
                                <span class="badge-academic">
                                    <i class="bi bi-calendar-range me-1"></i>
                                    {{ $p->tahunAjaran?->tahun_ajaran ?? $p->tahunAjaran?->tahun ?? $p->tahunAjaran?->nama ?? $p->tahunAjaran?->nama_tahun ?? '-' }}
                                </span>
                            </div>

                            <div class="item-footer">
                                <span>
                                    <i class="bi bi-person-badge me-1"></i> {{ $p->penguji->count() }} Penguji
                                </span>
                                <span class="fw-semibold text-primary">Lihat Detail</span>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5 border rounded bg-light">
                            <i class="bi bi-kanban fs-1 text-muted"></i>
                            <h5 class="mt-3 text-dark">Belum ada PJBL</h5>
                            <p class="text-muted mb-0">Belum ada data PJBL untuk kelas ini.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div id="pjblEmpty" class="card border-0 shadow-sm mt-4" style="display: none;">
                <div class="card-body text-center py-5">
                    <i class="bi bi-search fs-1 text-muted"></i>
                    <h5 class="mt-3 text-dark">PJBL tidak ditemukan</h5>
                    <p class="text-muted mb-0">Coba ubah kata pencarian, tanggal, atau tahun ajaran.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchPjbl');
            const filterTanggal = document.getElementById('filterTanggal');
            const filterTahun = document.getElementById('filterTahun');
            const resetButton = document.getElementById('resetFilter');
            const cards = document.querySelectorAll('.pjbl-card');
            const emptyMessage = document.getElementById('pjblEmpty');
            const jumlahPjbl = document.getElementById('jumlahPjbl');

            function filterPjbl() {
                const keyword = searchInput.value.trim().toLowerCase();
                const tanggal = filterTanggal.value.trim();
                const tahun = filterTahun.value.trim();
                let jumlahTampil = 0;

                cards.forEach(function (card) {
                    const searchText = (card.dataset.search || '').toLowerCase();
                    const cardTanggal = card.dataset.tanggal || '';
                    const cardTahun = card.dataset.tahun || '';

                    const cocokSearch = keyword === '' || searchText.includes(keyword);
                    const cocokTanggal = tanggal === '' || cardTanggal === tanggal;
                    const cocokTahun = tahun === '' || cardTahun === tahun;

                    if (cocokSearch && cocokTanggal && cocokTahun) {
                        card.style.display = '';
                        jumlahTampil++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                if (jumlahPjbl) {
                    jumlahPjbl.textContent = jumlahTampil;
                }

                if (emptyMessage) {
                    emptyMessage.style.display = jumlahTampil === 0 ? 'block' : 'none';
                }
            }

            if (searchInput) searchInput.addEventListener('input', filterPjbl);
            if (filterTanggal) filterTanggal.addEventListener('change', filterPjbl);
            if (filterTahun) filterTahun.addEventListener('change', filterPjbl);

            if (resetButton) {
                resetButton.addEventListener('click', function () {
                    searchInput.value = '';
                    filterTanggal.value = '';
                    filterTahun.value = '';
                    filterPjbl();
                    searchInput.focus();
                });
            }

            filterPjbl();
        });
    </script>
@endpush