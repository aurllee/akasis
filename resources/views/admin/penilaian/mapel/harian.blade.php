@extends('layouts.app')

@section('title', 'Penilaian Harian ' . $mataPelajaran->nama_mapel)

@push('styles')
<style>
    .academic-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .1);
        margin-bottom: 24px;
    }

    .academic-header {
        margin-bottom: 20px;
    }

    .academic-header h1 {
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
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
        margin-bottom: 12px;
    }

    .btn-back-link:hover {
        color: #2563eb;
    }

    .btn-action-primary {
        background: #2563eb !important;
        color: #fff !important;
        border: 1px solid #2563eb !important;
        padding: 9px 18px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-action-secondary {
        background: #fff;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 9px 18px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-action-edit {
        color: #2563eb;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
    }

    .btn-action-delete {
        color: #dc2626;
        background: #fef2f2;
        border: 1px solid #fecaca;
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
    }

    .badge-blue {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }
</style>
@endpush

@section('content')

<div class="academic-container">

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

        <div class="academic-header border-0 mb-0 pb-0">

            <h1>Penilaian Harian</h1>

            <p>
                {{ $mataPelajaran->nama_mapel }}
                —
                {{ $kelas->tingkat }} {{ $kelas->nama_kelas }}

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

    <div class="academic-card p-0 overflow-hidden">

        <div class="p-4 border-bottom">

            <span class="badge-blue">
                Penilaian Harian
            </span>

        </div>

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

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

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchHarian');
        const tableBody = document.getElementById('harianTableBody');

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
                emptyRow.innerHTML = '<td colspan="6" class="text-center py-5"><i class="bi bi-search fs-1 text-muted"></i><h6 class="mt-3">Siswa tidak ditemukan</h6><p class="text-muted small mb-0">Coba kata kunci lain.</p></td>';
                tableBody.appendChild(emptyRow);
            }
        });
    });
</script>
@endpush