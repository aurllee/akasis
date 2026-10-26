@extends('layouts.app')

@section('title', 'Rekap Pelanggaran Siswa')

@push('styles')
<style>
    .tatib-page {
        color: #0f172a;
        font-family: 'Poppins', sans-serif;
    }

    .tatib-page .page-header {
        margin-bottom: 24px;
    }

    .tatib-page .page-title {
        margin: 0 0 8px;
        font-size: 24px;
        font-weight: 700;
    }

    .tatib-page .page-subtitle {
        margin: 0;
        color: #64748b;
        font-size: 14px;
    }

    .tatib-page .data-card {
        overflow: hidden;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .08);
    }

    .tatib-page .data-card-header {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 18px 22px;
        border-bottom: 1px solid #e2e8f0;
    }

    .tatib-page .data-card-title {
        margin: 0;
        color: #0f172a;
        font-size: 15px;
        font-weight: 700;
    }

    .tatib-page .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .tatib-page .custom-table {
        width: 100%;
        min-width: 640px;
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
        background: #fff;
    }

    .tatib-page .custom-table th {
        padding: 13px 16px;
        border-bottom: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #475569;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .04em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .tatib-page .custom-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #475569;
        font-size: 13px;
        vertical-align: middle;
    }

    .tatib-page .custom-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .tatib-page .custom-table tbody tr:hover {
        background: #f8fafc;
    }

    .tatib-page .number-cell {
        width: 64px;
        color: #64748b;
        font-weight: 600;
        text-align: center;
    }

    .tatib-page .student-name {
        color: #0f172a;
        font-weight: 600;
    }

    .tatib-page .points-badge {
        display: inline-flex;
        min-width: 36px;
        justify-content: center;
        padding: 5px 10px;
        border-radius: 999px;
        background: #eff6ff;
        color: #1d4ed8;
        font-weight: 700;
    }

    .tatib-page .detail-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 11px;
        border: 1px solid #bfdbfe;
        border-radius: 8px;
        background: #eff6ff;
        color: #1d4ed8;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
    }

    .tatib-page .detail-btn:hover {
        border-color: #93c5fd;
        background: #dbeafe;
        color: #1e40af;
    }

    .tatib-page .empty-state {
        padding: 32px 16px !important;
        color: #64748b;
        text-align: center;
    }

    @media (max-width: 576px) {
        .tatib-page .page-title {
            font-size: 20px;
        }

        .tatib-page .data-card-header {
            padding: 16px;
        }
    }
</style>
@endpush

@section('content')
    <div class="container-fluid py-4 tatib-page">
        <div class="page-header">
            <h1 class="page-title">Riwayat Pelanggaran Siswa</h1>
            <p class="page-subtitle">Rekap pelanggaran siswa di kelas Anda.</p>
        </div>

        <div class="data-card">
            <div class="data-card-header">
                <h2 class="data-card-title">Rekap Poin Pelanggaran</h2>
            </div>

            <div class="table-wrapper">
                <table class="custom-table">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Nama</th>
                        <th>NIS</th>
                        <th class="text-center">Total Poin</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayat as $item)
                        <tr>
                            <td class="number-cell">{{ $riwayat->firstItem() + $loop->index }}</td>
                            <td><span class="student-name">{{ $item->nama }}</span></td>
                            <td>{{ $item->nis ?? '-' }}</td>
                            <td class="text-center">
                                <span class="points-badge">{{ $item->total_poin ?? 0 }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('tatib.riwayat.detail', $item->siswa_id) }}"
                                    class="detail-btn">
                                    <i class="bi bi-eye" aria-hidden="true"></i>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-state">
                                <i class="bi bi-inbox d-block mb-2 fs-4" aria-hidden="true"></i>
                                Belum ada riwayat pelanggaran siswa di kelas Anda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                </table>
            </div>

            @if ($riwayat->hasPages())
                <div class="px-3 py-3 border-top">
                    {{ $riwayat->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection