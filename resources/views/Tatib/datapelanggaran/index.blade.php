@extends('layouts.app')

@section('title', 'Data pelanggaran')

@push('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #1f2937;
            background: #f4f7fb;
        }

        .page-wrap {
            width: 100%;
        }

        .page-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(15, 23, 42, 0.04);
            padding: 24px;
        }

        .page-title {
            margin: 0 0 8px;
            font-size: 25px;
            font-weight: 500;
        }

        .page-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 20px;
        }

        .page-subtitle {
            margin: 0;
            color: #64748b;
        }

        .academic-btn {
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

        .academic-btn:hover {
            background: #1d3f8c;
            color: #ffffff;
        }

        @media (max-width: 576px) {
            .page-heading {
                align-items: flex-start;
                flex-direction: column;
            }
        }

        .table th {
            background: #eff6ff;
            color: #1e40af;
            font-size: 0.82rem;
            vertical-align: middle;
        }

        .table td {
            vertical-align: middle;
        }

        .btn-primary {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 8px;
            background: #2449a4;
            border: none;
            color: #ffffff;
            text-decoration: none;
            font-weight: 500;
        }

        .btn-primary:hover {
            opacity: 0.95;
            color: #ffffff;
            text-decoration: none;
        }

        .empty-state {
            padding: 20px;
            border-radius: 10px;
            background: #f8fafc;
            color: #64748b;
            text-align: center;
        }

        .fs-12 {
            font-size: 13px;
        }
    </style>
@endpush

@section('content')
    <div class="page-wrap">
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