@extends('layouts.app')

@section('title', 'Perizinan Sakit')

@push('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #1f2937;
        }

        .sick-leave-page {
            width: 100%;
        }

        .sick-leave-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .sick-leave-header h1 {
            color: #1e293b;
            font-size: 25px;
            font-weight: 500;
            margin-bottom: .35rem;
        }

        .sick-leave-card {
            border: 1px solid #e5e7eb;
            border-top: 4px solid #2449a4;
            border-radius: 12px;
        }

        .sick-leave-table th {
            background: #eff6ff;
            color: #1e40af;
            font-size: .82rem;
            white-space: nowrap;
        }

        .sick-leave-table td {
            vertical-align: middle;
            font-size: .88rem;
        }

        .status .badge {
            font-size: 12px;
            border-radius: 10px;
            padding: 7px;
            font-weight: 500;

        }

        @media (max-width: 575px) {
            .sick-leave-header {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
@endpush

@section('content')
    <div class="sick-leave-page">
        <div class="sick-leave-header">
            <div>
                <h1>Perizinan Sakit</h1>
                <p class="text-muted mb-0">Riwayat pengajuan izin sakit kamu.</p>
            </div>

            <a href="{{ route('siswa.perizinan.sakit.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Ajukan Perizinan
            </a>
        </div>


        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card sick-leave-card shadow-sm">
            <div class="card-body p-3 p-md-4">
                <div class="table-responsive">
                    <table class="table table-hover sick-leave-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Alasan</th>
                                <th>Dokumen</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dataSakit as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-nowrap">{{ $item->tanggal?->format('d M Y') ?? '-' }}</td>
                                    <td>{{ $item->alasan }}</td>
                                    <td>
                                        @if ($item->dokumen)
                                            <a href="{{ asset('storage/' . $item->dokumen) }}" target="_blank"
                                                class="btn btn-sm btn-outline-secondary">
                                                <i class="bi bi-file-earmark me-1"></i>Lihat
                                            </a>
                                        @else
                                            <span class="text-muted">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="status">
                                            @if ($item->status === 'menunggu_walikelas')
                                                <span class="badge bg-warning text-dark">Menunggu Wali Kelas</span>
                                            @elseif ($item->status === 'disetujui_walikelas')
                                                <span class="badge bg-success">Disetujui</span>
                                            @elseif ($item->status === 'ditolak_walikelas')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $item->status }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if ($item->status === 'menunggu_walikelas')
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('siswa.perizinan.sakit.edit', $item->id) }}"
                                                    class="btn btn-sm btn-outline-primary" title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="{{ route('siswa.perizinan.sakit.destroy', $item->id) }}" method="POST"
                                                    onsubmit="return confirm('Hapus pengajuan sakit ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-5">Belum ada pengajuan sakit.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection