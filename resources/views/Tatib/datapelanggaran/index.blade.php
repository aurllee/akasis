@extends('layouts.app')

@section('title', 'Data pelanggaran')

@push('styles')
    <style>
        .tatib-list-page {
            color: #1f2937;
            width: 100%;
        }

        .tatib-list-page .page-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(15, 23, 42, 0.04);
            padding: 24px;
        }

        .tatib-list-page .page-title {
            margin: 0 0 8px;
            font-size: 25px;
            font-weight: 600;
            color: #2449a4;
        }

        .tatib-list-page .page-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 20px;
        }

        .tatib-list-page .page-subtitle {
            margin: 0;
            color: #64748b;
        }

        .tatib-list-page .academic-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 9px 15px;
            border: 1px solid transparent;
            border-radius: 6px;
            background: #2449a4;
            color: #ffffff;
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.2s ease;
        }

        .tatib-list-page .academic-btn:hover {
            background: #1d3f8c;
            color: #ffffff;
        }

        .tatib-list-page .table-responsive {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
        }

        .tatib-list-page .table {
            margin-bottom: 0;
            min-width: 620px;
        }

        .tatib-list-page .table th {
            background: #eff6ff;
            color: #1e40af;
            font-size: 0.82rem;
            vertical-align: middle;
            white-space: nowrap;
        }

        .tatib-list-page .table td {
            vertical-align: middle;
        }

        .tatib-list-page .table tbody tr:last-child td {
            border-bottom: 0;
        }

        .tatib-list-page .empty-state {
            padding: 20px;
            border-radius: 10px;
            background: #f8fafc;
            color: #64748b;
            text-align: center;
        }

        .tatib-list-page .pagination {
            margin-bottom: 0;
        }

        @media (max-width: 576px) {
            .tatib-list-page .page-card {
                padding: 18px 14px;
            }

            .tatib-list-page .page-heading {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
@endpush

@section('content')
    <div class="page-wrap tatib-list-page">
        <div class="page-card">
            <div class="page-heading">
                <div>
                    <h1 class="page-title">Daftar Pelanggaran</h1>
                    <p class="page-subtitle">Jenis pelanggaran dan poin yang berlaku.</p>
                </div>
                <div class="academic-header-actions">
                    <a href="{{ route('tatib.datapelanggaran.create') }}" class="academic-btn academic-btn-primary">
                        Tambah Pelanggaran
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead>
                        <tr>
                            <th width="60">No</th>
                            <th>Jenis Pelanggaran</th>
                            <th>Poin</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pelanggaran as $item)
                            <tr>
                                <td>{{ $pelanggaran->firstItem() + $loop->index }}</td>
                                <td>{{ $item->jenis_pelanggaran }}</td>
                                <td>{{ $item->poin_pelanggaran }}</td>
                                <td>{{ $item->keterangan ?: '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state mb-0">
                                        Belum ada data pelanggaran.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $pelanggaran->links() }}
            </div>
        </div>
    </div>
@endsection