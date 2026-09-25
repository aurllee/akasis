@extends('layouts.app')

@section('title', 'Perizinan')

@section('content')

    @push('styles')
        <style>
            body {
                font-family: 'Poppins', sans-serif;
                background: #f4f7fb;
                color: #1f2937;
            }

            .perizinan-page {
                width: 100%;
            }

            .perizinan-header {
                align-items: center;
                display: flex;
                gap: 1rem;
                justify-content: space-between;
                margin-bottom: 1.5rem;
            }

            .perizinan-header h1 {
                font-size: 1.5rem;
                font-weight: 600;
                margin-bottom: 0.25rem;
            }

            .perizinan-card {
                overflow: hidden;
                border: 1px solid #e5e7eb;
                border-top: 4px solid #0d6efd;
                border-radius: 0.75rem;
            }

            .perizinan-table th {
                background-color: #f8f9fa;
                border-bottom: 2px solid #dee2e6;
                color: #495057;
                font-size: 0.85rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                white-space: nowrap;
            }

            .perizinan-table td {
                font-size: 0.875rem;
                vertical-align: middle;
            }

            .perizinan-table tbody tr:hover {
                background-color: #f8fafc;
            }

            .perizinan-table .reason-cell {
                max-width: 300px;
                word-wrap: break-word;
            }

            .action-buttons {
                display: inline-flex;
                align-items: center;
                gap: 0.35rem;
            }

            .action-buttons form {
                display: inline-flex;
                margin: 0;
            }

            .action-buttons .btn {
                align-items: center;
                display: inline-flex;
                height: 32px;
                justify-content: center;
                padding: 0;
                width: 32px;
                border-radius: 0.375rem;
            }

            @media (max-width: 575.98px) {
                .perizinan-header {
                    align-items: flex-start;
                    flex-direction: column;
                }

                .perizinan-header .btn {
                    width: 100%;
                }

                .perizinan-table {
                    min-width: 900px;
                }
            }
        </style>
    @endpush

    <div class="perizinan-page">

        <div class="perizinan-header">
            <div>
                <h1 class="h3 mb-1 text-gray-800">Perizinan</h1>
                <p class="text-muted mb-0">Riwayat pengajuan perizinan kamu.</p>
            </div>

            <a href="{{ route('siswa.perizinan.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Ajukan Izin
            </a>
        </div>

        <div class="card perizinan-card shadow-sm">
            <div class="card-body p-3 p-md-4">

                @if($data->count())

                    <div class="table-responsive">
                        <table class="table table-hover perizinan-table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Jenis</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Alasan</th>
                                    <th class="text-center">Dokumen</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                    <tr>
                                        <td class="text-center fw-bold">{{ $loop->iteration }}</td>
                                        <td>
                                            {{ ucfirst($item->jenis) }}
                                        </td>
                                        <td>{{ $item->tanggal?->format('d M Y') }}</td>
                                        <td>
                                            @if(in_array($item->jenis, ['sakit', 'izin'], true))
                                                <span class="text-muted">-</span>

                                            @elseif($item->jenis === 'keluar')
                                                {{ $item->jam_mulai }} - {{ $item->jam_selesai }}
                                            @elseif($item->jenis === 'pulang')
                                                {{ $item->jam_mulai }} - <span class="text-muted">pulang</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="reason-cell">
                                                {{ \Illuminate\Support\Str::limit($item->alasan, 80) }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if($item->dokumen)
                                                <a href="{{ asset('storage/' . $item->dokumen) }}" target="_blank"
                                                    class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-file-alt me-1"></i> Lihat
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if(in_array($item->jenis, ['sakit', 'izin'], true))
                                                @if($item->status === 'menunggu')
                                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                                @elseif($item->status === 'disetujui')
                                                    <span class="badge bg-success">Disetujui</span>
                                                @elseif($item->status === 'ditolak')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @endif
                                            @else
                                                <span class="badge bg-success">Disetujui</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if(in_array($item->jenis, ['sakit', 'izin'], true) && $item->status === 'menunggu')
                                                <div class="action-buttons">
                                                    <a href="{{ route('siswa.perizinan.edit', $item->id) }}"
                                                        class="btn btn-sm btn-outline-primary" title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('siswa.perizinan.destroy', $item->id) }}" method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus pengajuan ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                            <i class="bi bi-trash3"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
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
                        <h5>Belum ada pengajuan perizinan</h5>
                        <p class="text-muted">Kamu belum memiliki riwayat izin.</p>
                        <a href="{{ route('siswa.perizinan.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Ajukan Izin
                        </a>
                    </div>

                @endif

            </div>
        </div>

    </div>

@endsection