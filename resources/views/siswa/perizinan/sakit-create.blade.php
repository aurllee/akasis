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

    .form-control,
    .form-select {
        border-color: #cbd5e1;
        border-radius: 8px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #3c73fe;
        box-shadow: 0 0 0 3px rgba(60, 115, 254, 0.15);
    }

    .info-box {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 8px;
        padding: 12px 15px;
    }
</style>
@endpush

<div class="container-fluid">

    <div class="mb-4">
        <h4 class="fw-500 mb-1">Ajukan Perizinan</h4>
        <p class="text-muted mb-0">
            Isi data perizinan dengan benar.
        </p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form
                action="{{ route('siswa.perizinan.store') }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Jenis Perizinan
                    </label>

                    <select
                        name="jenis"
                        id="jenis"
                        class="form-select @error('jenis') is-invalid @enderror">

                        <option value="">
                            -- Pilih Jenis Perizinan --
                        </option>

                        <option value="sakit"
                            {{ old('jenis') === 'sakit' ? 'selected' : '' }}>
                            Izin Sakit
                        </option>

                        <option value="keluar"
                            {{ old('jenis') === 'keluar' ? 'selected' : '' }}>
                            Izin Keluar
                        </option>

                        <option value="pulang"
                            {{ old('jenis') === 'pulang' ? 'selected' : '' }}>
                            Izin Pulang
                        </option>

                    </select>

                    @error('jenis')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div id="infoSakit" class="info-box mb-4 d-none">

                    <strong>Izin Sakit</strong>

                    <div class="text-muted small mt-1">
                        Digunakan jika kamu tidak dapat mengikuti
                        kegiatan sekolah karena sakit. Pengajuan akan
                        diverifikasi oleh wali kelas.
                    </div>

                </div>

                <div id="infoKeluar" class="info-box mb-4 d-none">

                    <strong>Izin Keluar</strong>

                    <div class="text-muted small mt-1">
                        Digunakan jika kamu perlu keluar sekolah
                        pada jam tertentu. Dokumen wajib sudah
                        ditandatangani.
                    </div>

                </div>

                <div id="infoPulang" class="info-box mb-4 d-none">

                    <strong>Izin Pulang</strong>

                    <div class="text-muted small mt-1">
                        Digunakan jika kamu perlu pulang sebelum
                        kegiatan sekolah selesai. Dokumen wajib
                        sudah ditandatangani.
                    </div>

                </div>
                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Tanggal
                    </label>

                    <input
                        type="date"
                        name="tanggal"
                        class="form-control @error('tanggal') is-invalid @enderror"
                        value="{{ old('tanggal') }}">

                    @error('tanggal')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>
                <div
                    class="mb-3 d-none"
                    id="fieldJamMulai">

                    <label class="form-label fw-semibold">
                        Jam Mulai
                    </label>

                    <input
                        type="time"
                        name="jam_mulai"
                        class="form-control @error('jam_mulai') is-invalid @enderror"
                        value="{{ old('jam_mulai') }}">

                    @error('jam_mulai')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>
                <div
                    class="mb-3 d-none"
                    id="fieldJamSelesai">

                    <label class="form-label fw-semibold">
                        Jam Selesai
                    </label>

                    <input
                        type="time"
                        name="jam_selesai"
                        class="form-control @error('jam_selesai') is-invalid @enderror"
                        value="{{ old('jam_selesai') }}">

                    @error('jam_selesai')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Alasan
                    </label>

                    <textarea
                        name="alasan"
                        rows="4"
                        class="form-control @error('alasan') is-invalid @enderror"
                        placeholder="Jelaskan alasan perizinan">{{ old('alasan') }}</textarea>

                    @error('alasan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Surat / Bukti
                        <span class="text-muted fw-normal">(Wajib)</span>
                    </label>

                    <input
                        type="file"
                        name="dokumen"
                        class="form-control @error('dokumen') is-invalid @enderror"
                        accept=".jpg,.jpeg,.png,.pdf">

                    <small class="text-muted">
                        Format: JPG, JPEG, PNG, atau PDF. Maksimal 2 MB.
                    </small>

                    @error('dokumen')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>
                <div class="d-flex gap-2">

                    <a
                        href="{{ route('siswa.perizinan.index') }}"
                        class="btn btn-secondary">
                        Kembali
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="fas fa-paper-plane me-1"></i>
                        Kirim Pengajuan

                    </button>

                </div>

            </form>

        </div>
    </div>

</div>


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const jenis = document.getElementById('jenis');

    const fieldJamMulai =
        document.getElementById('fieldJamMulai');

    const fieldJamSelesai =
        document.getElementById('fieldJamSelesai');

    const infoSakit =
        document.getElementById('infoSakit');

    const infoKeluar =
        document.getElementById('infoKeluar');

    const infoPulang =
        document.getElementById('infoPulang');


    function updateForm() {

        const value = jenis.value;

        // Reset
        fieldJamMulai.classList.add('d-none');
        fieldJamSelesai.classList.add('d-none');

        infoSakit.classList.add('d-none');
        infoKeluar.classList.add('d-none');
        infoPulang.classList.add('d-none');


        // SAKIT
        if (value === 'sakit') {

            infoSakit.classList.remove('d-none');

        }


        // KELUAR
        else if (value === 'keluar') {

            fieldJamMulai.classList.remove('d-none');
            fieldJamSelesai.classList.remove('d-none');

            infoKeluar.classList.remove('d-none');

        }


        // PULANG
        else if (value === 'pulang') {

            fieldJamMulai.classList.remove('d-none');

            infoPulang.classList.remove('d-none');

        }

    }


    updateForm();

    jenis.addEventListener('change', updateForm);

});
</script>
@endpush

@endsection
