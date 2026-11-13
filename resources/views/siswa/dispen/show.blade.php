@extends('layouts.app')

@section('title', 'Detail Dispensasi')

@push('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #1f2937;
        }

        .dispen-detail-page {
            color: #1f2937;
        }

        .dispen-detail-page .card {
            border: 1px solid #e5e7eb !important;
            border-top: 4px solid #2449a4 !important;
            border-radius: 12px;
        }

        .dispen-detail-page .detail-reason {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            color: #1e3a8a;
            line-height: 1.6;
        }

        .dispen-detail-page .status-icon {
            align-items: center;
            box-sizing: border-box;
            display: inline-flex;
            border-radius: 50%;
            justify-content: center;
            height: 72px;
            padding: 0;
            width: 72px;
        }
    </style>
@endpush

@section('content')

    <div class="container-fluid py-4 dispen-detail-page">

        <div class="d-flex justify-content-between align-items-center gap-3 mb-4">

            <div>
                <h3 class="fw-bold mt-3 mb-1">

                    Detail Dispensasi

                </h3>


                <p class="text-muted mb-0">

                    Informasi pengajuan dispensasi kamu.

                </p>
            </div>

            <a href="{{ route('siswa.dispen.index') }}" class="btn btn-secondary flex-shrink-0">
                Kembali

            </a>

        </div>


        <div class="row g-4">



            <div class="col-lg-8">

                <div class="card border-0 shadow-sm">

                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-4">
                            Informasi Pengajuan
                        </h5>


                        <div class="row g-4">

                            <div class="col-md-6">

                                <div class="text-muted small mb-1">
                                    Nama Siswa
                                </div>

                                <div class="fw-semibold">
                                    {{ $siswa->nama }}
                                </div>

                            </div>


                            <div class="col-md-6">

                                <div class="text-muted small mb-1">
                                    NIS
                                </div>

                                <div class="fw-semibold">
                                    {{ $siswa->nis }}
                                </div>

                            </div>


                            <div class="col-md-6">

                                <div class="text-muted small mb-1">
                                    Tanggal Mulai
                                </div>

                                <div class="fw-semibold">

                                    {{ $dispen->tanggal_mulai->format('d F Y') }}

                                </div>

                            </div>


                            <div class="col-md-6">

                                <div class="text-muted small mb-1">
                                    Tanggal Selesai
                                </div>

                                <div class="fw-semibold">

                                    {{ $dispen->tanggal_selesai->format('d F Y') }}

                                </div>

                            </div>


                            <div class="col-12">

                                <div class="text-muted small mb-1">
                                    Kegiatan
                                </div>

                                <div class="fw-semibold">
                                    {{ $dispen->kegiatan ?? '-' }}
                                </div>

                            </div>


                            <div class="col-12">

                                <div class="text-muted small mb-1">
                                    Alasan
                                </div>

                                <div class="detail-reason p-3">

                                    {{ $dispen->alasan }}

                                </div>

                            </div>


                            <div class="col-12">

                                <div class="text-muted small mb-2">
                                    Surat Pendukung
                                </div>


                                @if($dispen->surat)

                                    <a href="{{ asset('storage/' . $dispen->surat) }}" target="_blank"
                                        class="btn btn-outline-primary">

                                        <i class="bi bi-file-earmark-text me-1"></i>

                                        Lihat Surat

                                    </a>

                                @else

                                    <span class="text-muted">
                                        Tidak ada surat pendukung.
                                    </span>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>




            <div class="col-lg-4">

                <div class="card border-0 shadow-sm">

                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-4">
                            Status Pengajuan
                        </h5>


                        <div class="text-center py-3">

                            @if($dispen->status === 'menunggu')

                                <div class="status-icon rounded-circle
                                                                               bg-warning
                                                                               bg-opacity-10
                                                                               text-warning
                                                                               d-inline-flex
                                                                               p-4
                                                                               mb-3">

                                    <i class="bi bi-clock-history fs-2"></i>

                                </div>

                                <h5 class="fw-bold">
                                    Menunggu
                                </h5>

                                <p class="text-muted mb-0">

                                    Pengajuan sedang menunggu
                                    verifikasi kesiswaan.

                                </p>


                            @elseif($dispen->status === 'disetujui')

                                <div class="status-icon rounded-circle
                                                                               bg-success
                                                                               bg-opacity-10
                                                                               text-success
                                                                               d-inline-flex
                                                                               p-4
                                                                               mb-3">

                                    <i class="bi bi-check-circle fs-2"></i>

                                </div>

                                <h5 class="fw-bold text-success">
                                    Disetujui
                                </h5>

                                <p class="text-muted mb-0">

                                    Pengajuan dispensasi kamu telah disetujui.

                                </p>


                            @elseif($dispen->status === 'ditolak')

                                <div class="status-icon rounded-circle
                                                                               bg-danger
                                                                               bg-opacity-10
                                                                               text-danger
                                                                               d-inline-flex
                                                                               p-4
                                                                               mb-3">

                                    <i class="bi bi-x-circle fs-2"></i>

                                </div>

                                <h5 class="fw-bold text-danger">
                                    Ditolak
                                </h5>

                                <p class="text-muted mb-0">

                                    Pengajuan dispensasi kamu ditolak.

                                </p>

                            @endif

                        </div>


                        @if($dispen->waktu_verifikasi)

                            <hr>

                            <div class="text-muted small">
                                Waktu Verifikasi
                            </div>

                            <div class="fw-semibold">

                                {{ $dispen->waktu_verifikasi->format('d/m/Y H:i') }}

                            </div>

                        @endif


                        @if($dispen->catatan)

                            <hr>

                            <div class="text-muted small mb-2">
                                Catatan Kesiswaan
                            </div>

                            <div class="alert alert-secondary mb-0">

                                {{ $dispen->catatan }}

                            </div>

                        @endif


                    </div>

                </div>

            </div>
        </div>

    </div>

@endsection