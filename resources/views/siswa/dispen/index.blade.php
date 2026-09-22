@extends('layouts.app')

@section('title', 'Dispensasi')

@push('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #1f2937;
        }

        .dispen-page {
            width: 100%;
        }

        .dispen-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .dispen-header h1 {
            color: #1e293b;
            font-size: 25px;
            font-weight: 500;
            margin-bottom: .35rem;
        }

        .dispen-card {
            border: 1px solid #e5e7eb;
            border-top: 4px solid #2449a4;
            border-radius: 12px;
        }

        .dispen-table th {
            background: #eff6ff;
            color: #1e40af;
            font-size: .82rem;
            white-space: nowrap;
        }

        .dispen-table td {
            vertical-align: middle;
            font-size: .88rem;
        }

        .dispen-table .reason-cell {
            max-width: 350px;
        }

        @media (max-width: 575px) {
            .dispen-header {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
@endpush

@section('content')

    <div class="dispen-page">
        <div class="dispen-header">

            <div>

                <h1>Dispensasi</h1>

                <p class="text-muted mb-0">
                    Kelola pengajuan dispensasi kamu.
                </p>

            </div>


            <a href="{{ route('siswa.dispen.create') }}" class="btn btn-primary">

                <i class="bi bi-plus-lg me-1"></i>

                Ajukan Dispensasi

            </a>

        </div>

        <div id="dispenContent">

            <div class="card dispen-card shadow-sm">
                <div class="card-body p-3 p-md-4">
                    <div class="table-responsive">

                        <table class="table table-hover dispen-table align-middle mb-0">

                            <thead class="table-light">

                                <tr>

                                    <th width="70" class="text-center">
                                        No
                                    </th>

                                    <th>
                                        Tanggal Dispensasi
                                    </th>

                                    <th>
                                        Kegiatan
                                    </th>

                                    <th>
                                        Alasan
                                    </th>

                                    <th class="text-center">
                                        Status
                                    </th>

                                    <th width="130" class="text-center">
                                        Surat
                                    </th>

                                    <th width="110" class="text-center">
                                        Aksi
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse($dispensasi as $index => $item)

                                                            <tr>


                                                                <td class="text-center">

                                                                    {{ $dispensasi->firstItem() + $index }}

                                                                </td>



                                                                <td>{{ $item->kegiatan ?? '-' }}</td>

                                                                <td>

                                                                    <div class="fw-semibold">

                                                                        {{ $item->tanggal_mulai->format('d/m/Y') }}

                                                                        @if(
                                                                                $item->tanggal_mulai->format('Y-m-d')
                                                                                !=
                                                                                $item->tanggal_selesai->format('Y-m-d')
                                                                            )

                                                                            -

                                                                            {{ $item->tanggal_selesai->format('d/m/Y') }}

                                                                        @endif

                                                                    </div>

                                                                </td>



                                                                <td>

                                                                    <div class="reason-cell">

                                                                        {{ \Illuminate\Support\Str::limit(
                                        $item->alasan,
                                        80
                                    ) }}

                                                                    </div>

                                                                </td>



                                                                <td class="text-center">
                                                                    @if ($item->status === 'disetujui')
                                                                        <span class="badge bg-success">Disetujui</span>
                                                                    @elseif ($item->status === 'ditolak')
                                                                        <span class="badge bg-danger">Ditolak</span>
                                                                    @elseif ($item->status === 'menunggu')
                                                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                                                    @else
                                                                        <span class="badge bg-secondary">{{ $item->status ?? '-' }}</span>
                                                                    @endif
                                                                </td>


                                                                <td class="text-center">

                                                                    @if($item->surat)

                                                                        <a href="{{ asset('storage/' . $item->surat) }}" target="_blank"
                                                                            class="btn btn-sm btn-outline-success" title="Lihat Surat">

                                                                            <i class="bi bi-file-earmark-text me-1"></i>

                                                                            Lihat

                                                                        </a>

                                                                    @else

                                                                        <span class="badge bg-secondary">

                                                                            Tidak Ada

                                                                        </span>

                                                                    @endif

                                                                </td>



                                                                <td class="text-center">

                                                                    <a href="{{ route(
                                        'siswa.dispen.show',
                                        $item->id
                                    ) }}" class="btn btn-sm btn-outline-success" title="Lihat Detail">

                                                                        <i class="bi bi-eye"></i>

                                                                    </a>

                                                                </td>

                                                            </tr>

                                @empty

                                    <tr>

                                        <td colspan="7" class="text-center py-5">

                                            <h5 class="mt-3">
                                                Belum Ada Pengajuan
                                            </h5>

                                            <p class="text-muted mb-3">
                                                Kamu belum memiliki pengajuan dispensasi.
                                            </p>

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>






                    @if($dispensasi->hasPages())

                        <div class="d-flex
                                                       justify-content-between
                                                       align-items-center
                                                       flex-wrap
                                                       gap-3
                                                       p-4
                                                       border-top">

                            <div class="text-muted small">

                                Menampilkan

                                <strong>
                                    {{ $dispensasi->firstItem() }}
                                </strong>

                                sampai

                                <strong>
                                    {{ $dispensasi->lastItem() }}
                                </strong>

                                dari

                                <strong>
                                    {{ $dispensasi->total() }}
                                </strong>

                                pengajuan

                            </div>


                            <div>

                                {{ $dispensasi->links() }}

                            </div>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

@endsection