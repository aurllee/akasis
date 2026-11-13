@extends('layouts.app')

@section('title', 'Penilaian Harian ' . $mataPelajaran->nama_mapel)

@push('styles')
<style>
    .assessment-page {
        padding: 8px 0 30px;
    }

    .assessment-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, .04);
        margin-bottom: 20px;
        padding: 20px;
    }

    .assessment-header {
        align-items: center;
        display: flex;
        gap: 16px;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .assessment-header h1 {
        color: #1f2937;
        font-size: 24px;
        margin: 0 0 5px;
    }

    .assessment-header p {
        color: #64748b;
        font-size: 13px;
        margin: 0;
    }

    .assessment-back {
        color: #64748b;
        display: inline-block;
        margin-bottom: 16px;
        text-decoration: none;
    }

    .assessment-table-wrap {
        overflow-x: auto;
    }

    .assessment-table {
        border-collapse: collapse;
        min-width: 800px;
        width: 100%;
    }

    .assessment-table th,
    .assessment-table td {
        border: 1px solid #dbe3ef;
        padding: 10px 12px;
        vertical-align: middle;
    }

    .assessment-table th {
        background: #eff6ff;
        color: #2449a4;
        font-size: 12px;
        text-align: center;
    }

    .assessment-table td {
        font-size: 13px;
    }

    .assessment-actions {
        display: flex;
        gap: 6px;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .assessment-header {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
<div class="assessment-page">
    <a href="{{ route('admin.penilaian.mapel.mapel', ['kelasId' => $kelas->id, 'mapelId' => $mataPelajaran->id]) }}"
        class="assessment-back">
        <i class="bi bi-arrow-left"></i>
        Kembali ke Jenis Penilaian
    </a>

    <div class="assessment-header">
        <div>
            <h1>Penilaian Harian</h1>
            <p>
                {{ $mataPelajaran->nama_mapel }} — {{ $kelas->tingkat }} {{ $kelas->nama_kelas }}
                @if ($kelas->jurusan)
                    — {{ $kelas->jurusan->nama_jurusan }}
                @endif
            </p>
        </div>
        <a href="{{ route('admin.penilaian.mapel.create', ['kelasId' => $kelas->id, 'mapelId' => $mataPelajaran->id, 'jenis_nilai' => 'harian']) }}"
            class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Penilaian
        </a>
    </div>

    <div class="assessment-card">
        <label for="searchHarian" class="form-label fw-semibold text-secondary">Cari Siswa</label>
        <input type="search" id="searchHarian" class="form-control" placeholder="Nama, NIS, atau NISN"
            autocomplete="off">
    </div>

    <div class="assessment-card p-0">
        <div class="assessment-table-wrap">
            <table class="assessment-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        @foreach ($jenisPenilaian as $assessment)
                            <th>
                                {{ $assessment->judul_tugas ?: 'Penilaian ' . $loop->iteration }}
                                <br>
                                <small>{{ $assessment->tanggal_penilaian?->format('d-m-Y') ?? '-' }}</small>
                            </th>
                        @endforeach
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="harianTableBody">
                    @forelse ($siswa as $student)
                        <tr class="assessment-row"
                            data-search="{{ strtolower(($student->nama ?? '') . ' ' . ($student->nis ?? '') . ' ' . ($student->nisn ?? '')) }}">
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $student->nis ?? '-' }}</td>
                            <td>{{ $student->nama ?? '-' }}</td>
                            @foreach ($jenisPenilaian as $assessment)
                                @php($score = $assessment->records->firstWhere('siswa_id', $student->id))
                                <td class="text-center">{{ $score?->nilai ?? '-' }}</td>
                            @endforeach
                            <td>
                                <div class="assessment-actions">
                                    <a href="{{ route('admin.penilaian.mapel.edit', [
                                        'kelasId' => $kelas->id,
                                        'mapelId' => $mataPelajaran->id,
                                        'id' => $student->id,
                                        'bulk' => 1,
                                        'jenis_nilai' => 'harian',
                                        'return_to' => request()->getRequestUri()
                                    ]) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.penilaian.mapel.destroy', [
                                        'kelasId' => $kelas->id,
                                        'mapelId' => $mataPelajaran->id,
                                        'id' => $student->id
                                    ]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="bulk" value="1">
                                        <input type="hidden" name="jenis_nilai" value="harian">
                                        <input type="hidden" name="return_to" value="{{ request()->getRequestUri() }}">
                                        <button type="submit" class="btn btn-sm btn-outline-secondary"
                                            onclick="return confirm('Yakin ingin menghapus semua nilai harian siswa ini?')">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ 4 + $jenisPenilaian->count() }}" class="text-center py-5">
                                Belum ada siswa di kelas ini.
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
        const searchInput = document.getElementById('searchHarian');
        const tableBody = document.getElementById('harianTableBody');

        if (!searchInput || !tableBody) {
            return;
        }

        searchInput.addEventListener('input', function () {
            const keyword = searchInput.value.trim().toLowerCase();

            tableBody.querySelectorAll('.assessment-row').forEach(function (row) {
                row.style.display = !keyword || (row.dataset.search || '').includes(keyword) ? '' : 'none';
            });
        });
    });
</script>
@endpush
