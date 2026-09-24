@extends('layouts.app')

@section('title', 'Ajukan Dispensasi')

@section('content')
    @push('styles')
        <style>
            body {
                font-family: 'Poppins', sans-serif;
                color: #1f2937;
            }

            h3 {
                color: #1e293b;
                font-size: 25px;
            }

            .card {
                border: 1px solid #e5e7eb !important;
                border-top: 4px solid #2449a4 !important;
                border-radius: 12px;
            }

            .form-control {
                border-color: #cbd5e1;
                border-radius: 8px;
            }

            .form-control:focus {
                border-color: #3c73fe;
                box-shadow: 0 0 0 3px rgba(60, 115, 254, 0.15);
            }
        </style>
    @endpush

    <div class="container-fluid py-4">

        <div class="mb-4">
            <h3 class="fw-500 mt-3 mb-3">

                {{ isset($dispen) ? 'Edit Dispensasi' : 'Ajukan Dispensasi' }}

            </h3>


            <p class="text-muted mb-0">

                Silakan isi data pengajuan dispensasi dengan lengkap.

            </p>

        </div>




        <div class="card border-0 shadow-sm">

            <div class="card-body p-4">

                <form
                    action="{{ isset($dispen) ? route('siswa.dispen.update', $dispen->id) : route('siswa.dispen.store') }}"
                    method="POST" enctype="multipart/form-data">

                    @csrf

                    @isset($dispen)
                        @method('PUT')
                    @endisset

                    <div class="mb-4">

                        <h5 class="fw-400 mb-4">
                            Data Siswa
                        </h5>


                        <div class="row g-3">

                            <div class="col-md-6">

                                <label class="form-label">
                                    Nama Siswa
                                </label>

                                <input type="text" class="form-control" value="{{ $siswa->nama }}" readonly>

                            </div>


                            <div class="col-md-6">

                                <label class="form-label">
                                    NIS
                                </label>

                                <input type="text" class="form-control" value="{{ $siswa->nis }}" readonly>

                            </div>

                        </div>

                    </div>


                    <hr class="mb-4">




                    <div class="mb-4">

                        <h5 class="fw-400 mb-4">
                            Periode Dispensasi
                        </h5>


                        <div class="row g-3">

                            <div class="col-md-6">

                                <label for="tanggal_mulai" class="form-label">
                                    Tanggal Mulai
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                                    class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                    value="{{ old('tanggal_mulai', isset($dispen) ? $dispen->tanggal_mulai->format('Y-m-d') : '') }}"
                                    required>

                                @error('tanggal_mulai')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            <div class="col-md-6">

                                <label for="tanggal_selesai" class="form-label">
                                    Tanggal Selesai
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                                    class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                    value="{{ old('tanggal_selesai', isset($dispen) ? $dispen->tanggal_selesai->format('Y-m-d') : '') }}"
                                    required>

                                @error('tanggal_selesai')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>

                    </div>




                    <div class="mb-4">
                        <label for="kegiatan" class="form-label fw-500">
                            Kegiatan Dispensasi
                            <span class="text-danger">*</span>
                        </label>

                        <input type="text" name="kegiatan" id="kegiatan"
                            class="form-control @error('kegiatan') is-invalid @enderror"
                            value="{{ old('kegiatan', $dispen->kegiatan ?? '') }}"
                            placeholder="Contoh: Lomba atau kegiatan sekolah" required>

                        @error('kegiatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">

                        <label for="alasan" class="form-label fw-500">

                            Alasan Dispensasi

                            <span class="text-danger">*</span>

                        </label>


                        <textarea name="alasan" id="alasan" rows="5"
                            class="form-control @error('alasan') is-invalid @enderror"
                            placeholder="Jelaskan alasan pengajuan dispensasi..."
                            required>{{ old('alasan', $dispen->alasan ?? '') }}</textarea>


                        @error('alasan')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>




                    <div class="mb-4">

                        <label for="surat" class="form-label fw-semibold">
                            Surat Dispensasi dari Kesiswaan
                            @unless(isset($dispen))
                                <span class="text-danger">*</span>
                            @endunless
                        </label>


                        @isset($dispen)
                            @if($dispen->surat)
                                <div class="mb-2">
                                    <a href="{{ asset('storage/' . $dispen->surat) }}" target="_blank"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-file-earmark-text me-1"></i>
                                        Lihat Surat Saat Ini
                                    </a>
                                </div>
                                <div class="form-text mb-2">
                                    Tidak perlu upload ulang jika tidak ingin mengganti surat.
                                </div>
                            @endif
                        @endisset

                        <input type="file" name="surat" id="surat" class="form-control @error('surat') is-invalid @enderror"
                            accept=".pdf,.jpg,.jpeg,.png" {{ isset($dispen) ? '' : 'required' }}>


                        <div class="form-text">
                            Upload surat dispensasi yang sudah diberikan oleh kesiswaan.
                            Format PDF, JPG, JPEG, atau PNG. Maksimal 2 MB.
                        </div>


                        @error('surat')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>




                    <div class="d-flex gap-2">

                        <a href="{{ route('siswa.dispen.index') }}" class="btn btn-secondary">

                            Kembali

                        </a>


                        <button type="submit" class="btn btn-primary">

                            {{ isset($dispen) ? 'Simpan Perubahan' : 'Ajukan Dispensasi' }}

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection