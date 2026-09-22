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
    </style>
@endpush

@section('content')
    <div class="academic-container">
        <a href="{{ route('admin.penilaian.pjbl.kelas', $kelas->id) }}" class="btn-back-link">
            <i class="bi bi-arrow-left"></i> Kembali ke List PJBL
        </a>

        <div class="academic-card">

            <div class="academic-header">
                <div>
                    <h1>Penilaian PJBL</h1>
                    <p>
                        {{ $kelas->tingkat }} {{ $kelas->nama_kelas }}
                        <span class="mx-1">—</span>
                        {{ $pjbl->nama_periode ?? 'PJBL' }}
                        <span class="mx-1">—</span>
                        {{ $pjbl->tanggal ? \Carbon\Carbon::parse($pjbl->tanggal)->format('d/m/Y') : '-' }}
                    </p>
                </div>
                <a href="{{ route('admin.penilaian.pjbl.create', ['kelasId' => $kelas->id, 'pjblId' => $pjbl->id]) }}"
                    class="btn-action-primary">
                    Tambah Penilaian
                </a>
            </div>

            <div class="sub-card">
                <div class="sub-card-header">
                    <div>
                        <div class="sub-card-title">
                            <i class="bi bi-people-fill text-primary"></i> Penguji PJBL
                        </div>
                        <small class="text-muted">Penguji yang memberikan penilaian pada PJBL ini</small>
                    </div>
                    <span class="badge-blue">{{ $penguji->count() }} Penguji</span>
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
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-semibold">{{ $p->guru?->nama ?? '-' }}</td>
                                    <td>{{ $p->guru?->nip ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">
                                        Belum ada data penguji PJBL.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="filter-section">
                <div class="row g-3 align-items-end">
                    <div class="col-md-10 filter-field">
                        <label for="liveSearchSiswa">Cari Siswa</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" id="liveSearchSiswa" class="border-start-0 ps-0"
                                placeholder="Cari nama, NIS, atau NISN..." autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="button" id="resetSearch" class="btn btn-outline-secondary w-100 py-2"
                            style="font-size: 13px; font-weight: 600;">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                        </button>
                    </div>
                </div>
            </div>

            <div class="sub-card">
                <div class="sub-card-header">
                    <div>
                        <div class="sub-card-title">
                            <i class="bi bi-clipboard-data text-primary"></i> Data Penilaian
                        </div>
                        <small class="text-muted">Nilai berdasarkan masing-masing penguji PJBL</small>
                    </div>
                    <span class="badge-blue">{{ $penilaianPerSiswa->count() }} Siswa</span>
                </div>

                <div class="table-responsive">
                    <table class="academic-table align-middle">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th style="min-width: 200px;">Siswa</th>
                                @foreach($penguji as $p)
                                    <th class="text-center" style="min-width: 110px;">
                                        <div class="fw-semibold">Guru {{ $loop->iteration }}</div>
                                        <small class="text-muted" style="font-size: 11px;">Nilai</small>
                                    </th>
                                @endforeach
                                <th class="text-center" style="min-width: 100px;">Total Nilai</th>
                                <th width="140" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penilaianPerSiswa as $siswaId => $nilaiSiswa)
                                @php
                                    $siswa = $nilaiSiswa->first()->siswa;
                                    $totalNilai = 0;
                                @endphp
                                <tr class="siswa-row"
                                    data-search="{{ strtolower(($siswa?->nama ?? '') . ' ' . ($siswa?->nis ?? '') . ' ' . ($siswa?->nisn ?? '')) }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $siswa?->nama ?? '-' }}</div>
                                        <small class="text-muted">NIS: {{ $siswa?->nis ?? '-' }}</small>
                                    </td>

                                    @foreach($penguji as $p)
                                        @php
                                            $nilaiPenguji = $nilaiSiswa->firstWhere('pjbl_penguji_id', $p->id);
                                            $nilai = $nilaiPenguji?->nilai ?? 0;
                                            $totalNilai += $nilai;
                                        @endphp
                                        <td class="text-center">
                                            @if($nilaiPenguji)
                                                <span class="badge-value">{{ $nilai }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    @endforeach

                                    <td class="text-center">
                                        <span class="badge bg-success fs-6">
                                            {{ $totalNilai }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $nilaiPertama = $nilaiSiswa->first();
                                        @endphp
                                        @if($nilaiPertama)
                                            <a href="{{ route('admin.penilaian.pjbl.edit', ['kelasId' => $kelas->id, 'pjblId' => $pjbl->id, 'id' => $nilaiPertama->id]) }}"
                                                class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="bi bi-pencil me-1"></i> Edit
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ 4 + $penguji->count() }}" class="text-center text-muted py-4">
                                        Belum ada data penilaian PJBL untuk siswa.
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
            const searchInput = document.getElementById('liveSearchSiswa');
            const resetButton = document.getElementById('resetSearch');
            const rows = document.querySelectorAll('.siswa-row');

            function filterSiswa() {
                const keyword = searchInput.value.toLowerCase().trim();

                rows.forEach(function (row) {
                    const searchData = (row.getAttribute('data-search') || '').toLowerCase();
                    row.style.display = searchData.includes(keyword) ? '' : 'none';
                });
            }

            if (searchInput) {
                searchInput.addEventListener('input', filterSiswa);
            }

            if (resetButton) {
                resetButton.addEventListener('click', function () {
                    searchInput.value = '';
                    filterSiswa();
                    searchInput.focus();
                });
            }
        });
    </script>
@endpush