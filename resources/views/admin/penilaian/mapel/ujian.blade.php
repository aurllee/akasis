@extends('layouts.app')

@section('title', 'Penilaian Ujian ' . $mataPelajaran->nama_mapel)

@push('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #1f2937;
            background: #f4f7fb;
        }

        .academic-container {
            width: 100%;
            padding: 6px 2px 30px;
            color: #1e293b;
        }

        .academic-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
            margin-bottom: 20px;
        }

        .academic-card.p-0 {
            padding: 0;
        }

        .academic-header {
            margin-bottom: 20px;
        }

        .academic-header h1 {
            font-size: 25px;
            font-weight: 600;
            color: #111827;
            margin: 0 0 4px;
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
            margin-bottom: 20px;
        }

        .btn-back-link:hover {
            color: #2449a4;
        }

        .btn-action-primary {
            background: #2449a4;
            color: #ffffff;
            border: 1px solid #2449a4;
            padding: 9px 14px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
        }

        .btn-action-primary:hover {
            background: #1a3679;
            border-color: #1a3679;
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
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
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

        .badge-green {
            display: inline-block;
            background: #eff6ff;
            color: #2449a4;
            border: 1px solid #bfdbfe;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
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
            color: #64748b;
            font-size: 11px;
            font-weight: 500;
        }

        .assessment-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            white-space: nowrap;
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
            background: #ffffff;
            color: #1f2937;
            font-size: 13px;
        }

        .table tbody tr:hover td {
            background: #f8fafc;
        }

        @media (max-width: 768px) {
            .academic-card {
                padding: 18px;
            }

            .academic-card.p-0 {
                padding: 0;
            }

            .d-flex {
                align-items: flex-start;
                flex-direction: column;
                gap: 12px;
            }
        }
    </style>
@endpush

@section('content')

<div class="academic-container">

    <a href="{{ route('admin.penilaian.mapel.mapel', [
    'kelasId' => $kelas->id,
    'mapelId' => $mataPelajaran->id
]) }}" class="btn-back-link">
        <i class="bi bi-arrow-left"></i>
        Kembali ke Jenis Penilaian
    </a>

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div class="academic-header border-0 mb-0 pb-0">

            <h1>Penilaian Ujian</h1>

            <p>
                {{ $mataPelajaran->nama_mapel }}
                —
                {{ $kelas->tingkat }} {{ $kelas->nama_kelas }}

                @if($kelas->jurusan)
                    — {{ $kelas->jurusan->nama_jurusan }}
                @endif
            </p>

        </div>

    </div>

    <div class="academic-card">
        <label for="searchUjian" class="form-label fw-semibold text-secondary">
            Cari Siswa
        </label>
        <div class="input-group">
            <span class="input-group-text bg-white">
                <i class="bi bi-search text-muted"></i>
            </span>
            <input type="search" id="searchUjian" class="form-control" placeholder="Nama, NIS, atau NISN"
                autocomplete="off">
        </div>
    </div>

    <div class="academic-card p-0 overflow-hidden">

        <div class="p-4 border-bottom">

            <span class="badge-green">
                Penilaian Ujian
            </span>

        </div>

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="bg-light">

                    <tr>
                        <th class="ps-4">No</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        @foreach($jenisPenilaian as $assessment)
                            <th>
                                <div class="assessment-header">
                                    <span class="assessment-header-title">
                                        {{ $assessment->judul_tugas ?: 'Penilaian ' . $loop->iteration }}
                                    </span>
                                    <span class="assessment-header-date">
                                        {{ $assessment->tanggal_penilaian?->format('d-m-Y') ?? '-' }}
                                    </span>
                                </div>
                            </th>
                        @endforeach
                        <th class="text-end pe-4">Aksi</th>
                    </tr>

                </thead>

                @forelse($siswa as $student)
                <tr class="assessment-row"
                    data-search="{{ strtolower(($student->nama ?? '') . ' ' . ($student->nis ?? '') . ' ' . ($student->nisn ?? '')) }}">
                    <td class="ps-4">{{ $loop->iteration }}</td>
                    <td>{{ $student->nis ?? '-' }}</td>
                    <td class="fw-semibold">{{ $student->nama ?? '-' }}</td>

                    @foreach($jenisPenilaian as $assessment)
                    @php($score = $assessment->records->firstWhere('siswa_id', $student->id))
                    <td class="text-center">
                        {{ $score?->nilai ?? '-' }}
                    </td>
                    @endforeach

                    <td class="text-end pe-4">
                        <div class="assessment-actions">
                            @if($penilaian->where('siswa_id', $student->id)->isNotEmpty())
                                                    <a href="{{ route('admin.penilaian.mapel.edit', [
                                    'kelasId' => $kelas->id,
                                    'mapelId' => $mataPelajaran->id,
                                    'id' => $student->id,
                                    'bulk' => 1,
                                    'jenis_nilai' => 'ujian',
                                    'return_to' => request()->getRequestUri()
                                ]) }}" class="btn-action-edit">
                                                        <i class="bi bi-pencil"></i>
                                                        Edit
                                                    </a>
                            @endif
                            @if($penilaian->where('siswa_id', $student->id)->isNotEmpty())
                                                    <form action="{{ route('admin.penilaian.mapel.destroy', [
                                    'kelasId' => $kelas->id,
                                    'mapelId' => $mataPelajaran->id,
                                    'id' => $student->id
                                ]) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="bulk" value="1">
                                                        <input type="hidden" name="jenis_nilai" value="ujian">
                                                        <input type="hidden" name="return_to" value="{{ request()->getRequestUri() }}">
                                                        <button type="submit" class="btn-action-delete"
                                                            onclick="return confirm('Yakin ingin menghapus semua nilai ujian siswa ini?')">
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
                    <td colspan="{{ 4 + $jenisPenilaian->count() }}" class="text-center py-5">
                        <i class="bi bi-people fs-1 text-muted"></i>
                        <h6 class="mt-3">Belum ada siswa di kelas ini</h6>
                    </td>
                </tr>
                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchUjian');
            const tableBody = document.getElementById('ujianTableBody');

            if (!searchInput || !tableBody) return;

            searchInput.addEventListener('input', function () {
                const keyword = searchInput.value.trim().toLowerCase();
                const rows = tableBody.querySelectorAll('.assessment-row');
                let visibleCount = 0;

                rows.forEach(function (row) {
                    const matches = !keyword || (row.dataset.search || '').includes(keyword);
                    row.style.display = matches ? '' : 'none';
                    if (matches) visibleCount++;
                });

                const oldEmpty = tableBody.querySelector('.live-search-empty');
                if (oldEmpty) oldEmpty.remove();

                if (rows.length > 0 && visibleCount === 0) {
                    const emptyRow = document.createElement('tr');
                    emptyRow.className = 'live-search-empty';
                    const columnCount = tableBody.closest('table').querySelectorAll('thead th').length;
                    emptyRow.innerHTML = `<td colspan="${columnCount}" class="text-center py-5"><i class="bi bi-search fs-1 text-muted"></i><h6 class="mt-3">Siswa tidak ditemukan</h6><p class="text-muted small mb-0">Coba kata kunci lain.</p></td>`;
                    tableBody.appendChild(emptyRow);
                }
            });
        });
    </script>
@endpush