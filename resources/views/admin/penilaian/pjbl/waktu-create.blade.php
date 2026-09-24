<div class="pjbl-time-fields">
    <div class="mb-3">
        <label for="mulai_penilaian" class="form-label">Mulai Penilaian</label>
        <input type="datetime-local" name="mulai_penilaian" id="mulai_penilaian"
            class="form-control @error('mulai_penilaian') is-invalid @enderror"
            value="{{ old('mulai_penilaian', optional($pjbl->mulai_penilaian)->format('Y-m-d\\TH:i')) }}" required>
        @error('mulai_penilaian')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="batas_penilaian" class="form-label">Batas Penilaian</label>
        <input type="datetime-local" name="batas_penilaian" id="batas_penilaian"
            class="form-control @error('batas_penilaian') is-invalid @enderror"
            value="{{ old('batas_penilaian', optional($pjbl->batas_penilaian)->format('Y-m-d\\TH:i')) }}" required>
        @error('batas_penilaian')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>