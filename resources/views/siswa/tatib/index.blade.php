@extends('layouts.app')

@section('title', 'Rekap Pelanggaran')

@push('styles')
    <style>
        .tatib-page {
            color: #1f2937;
        }

        .tatib-card,
        .tatib-summary {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
        }

        .tatib-summary {
            border-left: 4px solid #2449a4;
        }

        .tatib-title {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .tatib-table th {
            background: #f8fafc;
            color: #475569;
            font-size: 0.85rem;
            white-space: nowrap;
        }

        .tatib-table td {
            vertical-align: middle;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid py-4 tatib-page">
        <div class="mb-4">
            <h1 class="tatib-title mb-1">Rekap Pelanggaran</h1>
            <p class="text-muted mb-0">Riwayat pelanggaran yang pernah dicatat untuk kamu.</p>
        </div>

        <div class="tatib-summary shadow-sm p-3 p-md-4 mb-4">
            <div class="text-muted small">Total Poin Pelanggaran</div>
            <div class="fs-3 fw-semibold">{{ $totalPoin }}</div>
        </div>

        <div class="tatib-card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover tatib-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Tanggal</th>
                            <th>Jenis Pelanggaran</th>
                            <th class="text-center">Poin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($riwayat as $item)
                            <tr>
                                <td class="text-center">{{ $riwayat->firstItem() + $loop->index }}</td>
                                <td>{{ $item->tanggal ?? '-' }}</td>
                                <td>{{ $item->tatib?->jenis_pelanggaran ?? 'Pelanggaran tidak ditemukan' }}</td>
                                <td class="text-center">{{ $item->tatib?->poin_pelanggaran ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Belum ada riwayat pelanggaran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($riwayat->hasPages())
                <div class="p-3 border-top">
                    {{ $riwayat->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
