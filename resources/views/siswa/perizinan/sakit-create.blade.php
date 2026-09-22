@extends('layouts.app')

@section('content')

@push('styles')
<style>
    body {
        font-family: 'Poppins', sans-serif;
        color: #1f2937;
    }

    .container-fluid>.card {
        border: 1px solid #e5e7eb !important;
        border-radius: 14px;
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

<div class="container-fluid">

    <div class="mb-4">
        <h4 class="fw-500 mb-1">
            {{ isset($sakit) ? 'Edit Pengajuan Sakit' : 'Ajukan Izin Sakit' }}
        </h4>
        <p class="text-muted mb-0">
            Isi data sakit dengan benar.
        </p>
    </div>


    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <form
                action="{{ isset($sakit) ? route('siswa.perizinan.sakit.update', $sakit->id) : route('siswa.perizinan.sakit.store') }}"
                method="POST" enctype="multipart/form-data">

                @csrf

                @isset($sakit)
                    @method('PUT')
                @endisset



                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Tanggal Sakit
                    </label>

                    <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
                        value="{{ old('tanggal', isset($sakit) ? $sakit->tanggal?->format('Y-m-d') : '') }}">

                    @error('tanggal')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>





                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Alasan Sakit
                    </label>

                    <textarea name="alasan" rows="4" class="form-control @error('alasan') is-invalid @enderror"
                        placeholder="Contoh: Demam dan perlu istirahat di rumah">{{ old('alasan', $sakit->alasan ?? '') }}</textarea>

                    @error('alasan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>



                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Surat / Bukti Sakit
                        <span class="text-muted fw-normal">
                            (opsional)
                        </span>
                    </label>

                    @isset($sakit)
                        @if($sakit->dokumen)
                            <div class="mb-2">
                                <a href="{{ asset('storage/' . $sakit->dokumen) }}" target="_blank"
                                    class="btn btn-sm btn-outline-secondary">
                                    Lihat dokumen saat ini
                                </a>
                            </div>
                            <div class="form-text mb-2">
                                Tidak perlu upload ulang. Pilih file hanya jika ingin mengganti dokumen.
                            </div>
                        @endif
                    @endisset

                    <input type="file" name="dokumen" class="form-control @error('dokumen') is-invalid @enderror"
                        accept=".jpg,.jpeg,.png,.pdf">

                    <small class="text-muted">
                        Format: JPG, JPEG, PNG, atau PDF. Maksimal 2 MB.
                    </small>

                    @isset($sakit)
                        @if($sakit->dokumen)
                            <div class="form-text">
                                Dokumen lama tetap tersimpan jika tidak ada file baru.
                            </div>
                        @endif
                    @endisset

                    @error('dokumen')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>



                <div class="d-flex gap-2">

                    <a href="{{ route('siswa.perizinan.sakit') }}" class="btn btn-secondary">
                        Kembali
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-1"></i>
                        {{ isset($sakit) ? 'Simpan Perubahan' : 'Kirim Pengajuan' }}
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection