@extends('layouts.app')

@section('title', 'Detail Dispensasi')

@push('styles')
    <style>
        .dispen-detail-page {
            color: #1f2937;
        }

        .dispen-detail-page .card {
            border: 1px solid #e5e7eb !important;
            border-radius: 14px;
        }

        .dispen-detail-page .detail-reason {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            color: #334155;
            line-height: 1.6;
        }

        .dispen-detail-page .status-icon {
            align-items: center;
            display: inline-flex;
            justify-content: center;
            width: 72px;
            height: 72px;
        }
    </style>
@endpush

@section('content')

    <div class="container-fluid py-4 dispen-detail-page">

        <div class="mb-4">

            <a href="{{ route('siswa.dispen.index') }}" class="text-decoration-none text-muted">

                <i class="bi bi-arrow-left me-1"></i>

                Kembali ke Dispensasi

            </a>


            <h3 class="fw-bold mt-3 mb-1">

                Detail Dispensasi

            </h3>


            <p class="text-muted mb-0">

                Informasi pengajuan dispensasi kamu.

            </p>

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
                                        class="btn btn-outline-success">

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

                                <div class="rounded-circle
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

                                <div class="rounded-circle
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

                                <div class="rounded-circle
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