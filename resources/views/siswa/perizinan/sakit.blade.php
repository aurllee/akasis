@extends('layouts.app')

@section('content')

@push('styles')
<style>
    body {
        font-family: 'Poppins', sans-serif;
        color: #1f2937;
    }

    .container-fluid > .card {
        border: 1px solid #e5e7eb !important;
        border-top: 4px solid #2449a4 !important;
        border-radius: 12px;
    }

    .container-fluid > .d-flex h4 {
        color: #1e293b;
        font-size: 25px;
    }

    .table th {
        background: #eff6ff;
        color: #1e40af;
        font-size: .82rem;
        white-space: nowrap;
    }

    .table td {
        vertical-align: middle;
        font-size: .88rem;
    }

    .jenis-badge {
        font-size: 0.8rem;
        padding: 6px 10px;
        border-radius: 8px;
    }

    .action-buttons {
        display: inline-flex;
        gap: .35rem;
    }

    .action-buttons .btn {
        align-items: center;
        display: inline-flex;
        height: 34px;
        justify-content: center;
        padding: 0;
        width: 34px;
    }

    @media (max-width: 575px) {
        .container-fluid > .d-flex {
            align-items: flex-start !important;
            flex-direction: column;
        }
    }
</style>
@endpush

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-500 mb-1">
                Perizinan
            </h4>

            <p class="text-muted mb-0">
                Riwayat pengajuan perizinan kamu.
            </p>
        </div>

        <a
            href="{{ route('siswa.perizinan.create') }}"
            class="btn btn-primary">

            <i class="fas fa-plus me-1"></i>
            Ajukan Izin

        </a>

    </div>


    <div class="card border-0 shadow-sm">

        <div class="card-body">

            @if($data->count())

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead>

                            <tr>
                                <th>No</th>
                                <th>Jenis</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Alasan</th>
                                <th>Dokumen</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($data as $item)

                                <tr>

                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>

                                        @if($item->jenis === 'sakit')

                                            <span class="badge bg-warning text-dark jenis-badge">
                                                Sakit
                                            </span>

                                        @elseif($item->jenis === 'keluar')

                                            <span class="badge bg-info text-dark jenis-badge">
                                                Keluar
                                            </span>

                                        @elseif($item->jenis === 'pulang')

                                            <span class="badge bg-secondary jenis-badge">
                                                Pulang
                                            </span>

                                        @endif

                                    </td>
                                    <td>
                                        {{ $item->tanggal?->format('d M Y') }}
                                    </td>


                                    <td>

                                        @if($item->jenis === 'sakit')

                                            <span class="text-muted">
                                                -
                                            </span>

                                        @elseif($item->jenis === 'keluar')

                                            {{ $item->jam_mulai }}
                                            -
                                            {{ $item->jam_selesai }}

                                        @elseif($item->jenis === 'pulang')

                                            {{ $item->jam_mulai }}
                                            -
                                            <span class="text-muted">
                                                selesai
                                            </span>

                                        @endif

                                    </td>


                                    <td>
                                        {{ $item->alasan }}
                                    </td>

                                    <td>

                                        @if($item->dokumen)

                                            <a
                                                href="{{ asset('storage/' . $item->dokumen) }}"
                                                target="_blank"
                                                class="btn btn-sm btn-outline-secondary">

                                                <i class="fas fa-file-alt me-1"></i>
                                                Lihat

                                            </a>

                                        @else

                                            <span class="text-muted">
                                                -
                                            </span>

                                        @endif

                                    </td>
                                    <td>

                                        @if($item->jenis === 'sakit')

                                            @if($item->status === 'menunggu')

                                                <span class="badge bg-warning text-dark">
                                                    Menunggu Wali Kelas
                                                </span>

                                            @elseif($item->status === 'disetujui')

                                                <span class="badge bg-success">
                                                    Disetujui
                                                </span>

                                            @elseif($item->status === 'ditolak')

                                                <span class="badge bg-danger">
                                                    Ditolak
                                                </span>

                                            @endif

                                        @else
                                            <span class="badge bg-success">
                                                Disetujui
                                            </span>

                                        @endif

                                    </td>


                                    <td class="text-center">

                                        @if(
                                            $item->jenis === 'sakit' &&
                                            $item->status === 'menunggu'
                                        )

                                            <div class="action-buttons">

                                                <a
                                                    href="{{ route('siswa.perizinan.edit', $item->id) }}"
                                                    class="btn btn-sm btn-outline-primary"
                                                    title="Edit">

                                                    <i class="bi bi-pencil"></i>

                                                </a>


                                                <form
                                                    action="{{ route('siswa.perizinan.destroy', $item->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus pengajuan ini?')">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="btn btn-sm btn-outline-danger"
                                                        title="Hapus">

                                                        <i class="bi bi-trash3"></i>

                                                    </button>

                                                </form>

                                            </div>

                                        @else

                                            <span class="text-muted">
                                                -
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="text-center py-5">

                    <i class="fas fa-file-signature fa-3x text-muted mb-3"></i>

                    <h5>
                        Belum ada pengajuan perizinan
                    </h5>

                    <p class="text-muted">
                        Kamu belum memiliki riwayat izin.
                    </p>

                    <a
                        href="{{ route('siswa.perizinan.create') }}"
                        class="btn btn-primary">

                        <i class="fas fa-plus me-1"></i>
                        Ajukan Izin

                    </a>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection