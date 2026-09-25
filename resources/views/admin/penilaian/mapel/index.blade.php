@extends('layouts.app')

@section('title', 'Penilaian Mata Pelajaran')

@push('styles')
    <style>
        body {
            background-color: #f5f6fa;
            font-family: 'Poppins', sans-serif;
            color: #212529;
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
            padding-bottom: 12px;
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

        .academic-field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .academic-field label {
            font-size: 13px;
            font-weight: 600;
            color: #334155;
        }

        .academic-field input {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background-color: #ffffff;
            font-size: 14px;
            color: #1e293b;
            outline: none;
            transition: all 0.2s;
        }

        .academic-field input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .kelas-link {
            color: inherit;
            display: block;
            height: 100%;
            text-decoration: none;
        }

        .kelas-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            height: 100%;
            transition: all 0.2s ease-in-out;
        }

        .kelas-link:hover .kelas-card {
            border-color: #2563eb;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.12) !important;
            transform: translateY(-2px);
        }

        .kelas-card .card-footer {
            border-top: 1px solid #f1f5f9 !important;
        }

        .kelas-icon {
            background-color: #eff6ff !important;
            color: #2563eb !important;
        }

        .kelas-link .text-success {
            color: #2563eb !important;
        }

        .kelas-empty {
            grid-column: 1 / -1;
        }

        .kelas-empty .card {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
        }


        .kelas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 16px;
            margin-top: 16px;
        }

        .kelas-item-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 18px;
            transition: all 0.2s ease-in-out;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            text-decoration: none;
            color: inherit;
        }

        .kelas-item-card:hover {
            border-color: #2563eb;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.08);
            transform: translateY(-2px);
        }

        .kelas-icon-box {
            width: 44px;
            height: 44px;
            background-color: #eff6ff;
            color: #2563eb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .kelas-footer-link {
            color: #2563eb;
            font-weight: 600;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 4px;
            margin-top: 16px;
            padding-top: 12px;
            border-top: 1px solid #f1f5f9;
        }

        .kelas-empty-box {
            text-align: center;
            padding: 40px 20px;
            color: #64748b;
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 8px;
            grid-column: 1 / -1;
        }

        .pagination {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .pagination .page-item {
            display: inline-flex;
        }

        .pagination .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            height: 38px;
            padding: 0 12px;
            border: 1px solid #dbe2ea;
            border-radius: 8px;
            background: #fff;
            color: #475569;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .pagination .page-link:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            color: #0f172a;
        }

        .pagination .page-item.active .page-link {
            background: #2563eb;
            border-color: #2563eb;
            color: #fff;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.2);
        }

        .pagination .page-item.disabled .page-link {
            background: #f8fafc;
            color: #a8adb8;
            pointer-events: none;
        }
    </style>
@endpush

@section('content')
    <div class="academic-container">
        <div class="academic-card">
            <div class="academic-header">
                <h1>Penilaian Mata Pelajaran</h1>
                <p>Pilih kelas untuk melihat mata pelajaran dan data penilaian.</p>
            </div>

            <div class="row g-3 align-items-end mb-3">
                <div class="col-md-8">
                    <div class="academic-field">
                        <label for="searchKelas">Cari Kelas</label>
                        <input type="text" id="searchKelas" placeholder="Cari tingkat, nama kelas, atau jurusan..."
                            autocomplete="off">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="academic-field">
                        <label for="filterTingkat">Jenjang</label>
                        <select id="filterTingkat" class="form-select">
                            <option value="">Semua Jenjang</option>
                            @foreach($kelas->pluck('tingkat')->filter()->unique()->sort() as $tingkat)
                                <option value="{{ $tingkat }}">{{ $tingkat }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div id="kelasContent">
                <div class="kelas-grid" id="kelasList">

                    @forelse($kelas as $k)


                                    <div class="kelas-item" data-search="{{ strtolower(
                            $k->tingkat . ' ' .
                            $k->nama_kelas . ' ' .
                            ($k->jurusan?->nama_jurusan ?? 'Umum')
                        ) }}" data-tingkat="{{ $k->tingkat }}">


                                        <a href="{{ route(
                            'admin.penilaian.mapel.kelas',
                            $k->id
                        ) }}" class="kelas-link">


                                            <div class="card border-0 shadow-sm kelas-card">



                                                <div class="card-body p-4">


                                                    <div class="d-flex justify-content-between align-items-start">


                                                        <div>

                                                            <div class="text-muted small mb-1">
                                                                Kelas
                                                            </div>


                                                            <h4 class="fw-bold text-dark mb-1">

                                                                {{ $k->tingkat }}
                                                                {{ $k->nama_kelas }}

                                                            </h4>


                                                            <div class="text-muted">

                                                                {{ $k->jurusan?->nama_jurusan ?? 'Umum' }}

                                                            </div>

                                                        </div>



                                                        <div class="rounded-circle
                                                                   bg-success
                                                                   bg-opacity-10
                                                                   p-3
                                                                   text-success
                                                                   kelas-icon">

                                                            <i class="bi bi-mortarboard-fill fs-4"></i>

                                                        </div>


                                                    </div>


                                                    <hr class="my-4">



                                                    <div class="d-flex
                                                               justify-content-between
                                                               align-items-center">

                                                        <span class="text-muted">

                                                            <i class="bi bi-people me-1"></i>

                                                            Siswa

                                                        </span>


                                                        <strong class="text-dark">

                                                            {{ $k->siswa_kelas_count }}

                                                        </strong>

                                                    </div>


                                                </div>



                                                <div class="card-footer
                                                           bg-white
                                                           border-0
                                                           px-4
                                                           pb-4
                                                           pt-0">

                                                    <div class="text-success fw-semibold">

                                                        Lihat Mata Pelajaran

                                                        <i class="bi bi-arrow-right ms-1"></i>

                                                    </div>

                                                </div>


                                            </div>


                                        </a>


                                    </div>


                    @empty
                        <div class="kelas-empty-box">
                            <i class="bi bi-mortarboard fs-1 text-muted"></i>
                            <h5 class="mt-2 mb-1">Kelas tidak ditemukan</h5>
                            <p class="text-muted mb-0 small">Belum ada kelas yang sesuai.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            @if($kelas->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    <div class="w-100">
                        {{ $kelas->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const searchInput = document.getElementById('searchKelas');
                const filterTingkat = document.getElementById('filterTingkat');
                const kelasItems = document.querySelectorAll('.kelas-item');
                const kelasList = document.getElementById('kelasList');

                if (!searchInput || !kelasList) {
                    return;
                }

                function escapeHtml(text) {
                    const div = document.createElement('div');
                    div.textContent = text;
                    return div.innerHTML;
                }

                function filterKelas() {
                    const keyword = searchInput.value.toLowerCase().trim();
                    const tingkat = (filterTingkat ? filterTingkat.value : '').trim().toLowerCase();
                    let jumlahHasil = 0;

                    kelasItems.forEach(function (item) {
                        const dataSearch = (item.dataset.search || '').toLowerCase();
                        const itemTingkat = (item.dataset.tingkat || '').toLowerCase();

                        const cocokKeyword = keyword === '' || dataSearch.includes(keyword);
                        const cocokTingkat = tingkat === '' || itemTingkat === tingkat;

                        if (cocokKeyword && cocokTingkat) {
                            item.style.display = '';
                            jumlahHasil++;
                        } else {
                            item.style.display = 'none';
                        }
                    });

                    const oldMessage = document.getElementById('liveSearchEmpty');
                    if (oldMessage) {
                        oldMessage.remove();
                    }

                    if (jumlahHasil === 0) {
                        const empty = document.createElement('div');
                        empty.id = 'liveSearchEmpty';
                        empty.className = 'kelas-empty-box';
                        empty.innerHTML = `
                            <i class="bi bi-search fs-1 text-muted"></i>
                            <h5 class="mt-2 mb-1">Kelas tidak ditemukan</h5>
                            <p class="text-muted mb-0 small">
                                Tidak ada kelas yang sesuai dengan pencarian
                                "<strong>${escapeHtml(keyword || 'semua data')}</strong>".
                            </p>
                        `;
                        kelasList.appendChild(empty);
                    }
                }

                searchInput.addEventListener('input', filterKelas);
                if (filterTingkat) {
                    filterTingkat.addEventListener('change', filterKelas);
                }

                filterKelas();
            });
        </script>
    @endpush
@endsection