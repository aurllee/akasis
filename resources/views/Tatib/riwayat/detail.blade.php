@extends('layouts.app')

@section('title', 'Detail Riwayat Pelanggaran')

@push('styles')
    <style>
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

        .student-info {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }

        .student-info-card {
            padding: 16px 20px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            background: #f8fafc;
        }

        .student-info-label {
            margin-bottom: 4px;
            color: #64748b;
            font-size: 0.82rem;
        }

        .student-info-value {
            color: #1f2937;
            font-weight: 600;
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

        .table th {
            background: #eff6ff;
            color: #1e40af;
            font-size: 0.82rem;
            vertical-align: middle;
        }

        .table td {
            vertical-align: middle;
        }

        .empty-state {
            padding: 20px;
            border-radius: 10px;
            background: #f8fafc;
            color: #64748b;
            text-align: center;
        }

        @media (max-width: 576px) {
            .page-card {
                padding: 16px;
            }

            .page-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .student-info {
                gap: 10px;
            }

            .student-info-card {
                padding: 14px 12px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="page-wrap">
        <div class="page-card">
            <div class="page-heading">
                <div>
                    <h1 class="page-title">Detail Riwayat Pelanggaran</h1>
                    <p class="page-subtitle">Daftar pelanggaran yang pernah dicatat.</p>
                </div>
                <a href="{{ route('tatib.riwayat') }}" class="academic-btn">
                    <i class="bi bi-arrow-left me-1"></i>
                    Kembali
                </a>
            </div>

            <div class="student-info">
                <div class="student-info-card">
                    <div class="student-info-label">Nama Siswa</div>
                    <div class="student-info-value">{{ $siswa->nama ?? 'Nama tidak tersedia' }}</div>
                </div>
                <div class="student-info-card">
                    <div class="student-info-label">NIS</div>
                    <div class="student-info-value">{{ $siswa->nis ?? '-' }}</div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>Tanggal</th>
                            <th>Jenis Pelanggaran</th>
                            <th style="width: 100px;">Poin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($riwayat as $item)
                            <tr>
                                <td>{{ $riwayat->firstItem() + $loop->index }}</td>
                                <td>{{ $item->tanggal ?? '-' }}</td>
                                <td>{{ $item->tatib?->jenis_pelanggaran ?? 'Pelanggaran tidak ditemukan' }}</td>
                                <td>{{ $item->tatib?->poin_pelanggaran ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state mb-0">
                                        Belum ada riwayat pelanggaran siswa. smkn 4 malang 
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $riwayat->links() }}
            </div>
        </div>
    </div>
@endsection
