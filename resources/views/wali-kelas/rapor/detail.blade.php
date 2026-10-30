@extends('layouts.app')

@section('title', 'Detail Rapor Siswa')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <a
            href="{{ route('wali-kelas.rapor.siswa', [
                'kelasId' => $kelas->id,
                'tahunAjaranId' => $kelas->tahun_ajaran_id
            ]) }}"
            class="btn btn-outline-secondary btn-sm mb-3"
        >
            <i class="bi bi-arrow-left me-1"></i>
            Kembali ke Daftar Siswa
        </a>

        <h3 class="fw-semibold mb-1">Detail Rapor Siswa</h3>

        <p class="text-muted mb-0">
            {{ $siswa->nama }} · NIS {{ $siswa->nis }}
        </p>

        <p class="text-muted mb-0">
            Kelas {{ $kelas->tingkat }} {{ $kelas->nama_kelas }}
            · Tahun Ajaran {{ $kelas->tahun_ajaran }}
            · Semester {{ $kelas->semester }}
        </p>
    </div>

    @if ($rapor->status === 'final')
    <a
        href="{{ route('wali-kelas.rapor.cetak', [
            'kelasId' => $kelas->id,
            'tahunAjaranId' => $kelas->tahun_ajaran_id,
            'siswaId' => $siswa->id
        ]) }}"
        target="_blank"
        rel="noopener noreferrer"
        class="btn btn-success btn-sm mt-3"
    >
        <i class="bi bi-file-earmark-pdf me-1"></i>
        Cetak / Simpan PDF
    </a>
@endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger rounded-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $statusLabel = [
            'draft' => 'Draft',
            'perlu_revisi' => 'Perlu Revisi',
            'final' => 'Final',
        ];

        $statusClass = [
            'draft' => 'text-bg-secondary',
            'perlu_revisi' => 'text-bg-warning',
            'final' => 'text-bg-success',
        ];
    @endphp

    
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-1">Nilai Mata Pelajaran</h5>
        <small class="text-muted">
            Deskripsi capaian diisi oleh guru mata pelajaran.
        </small>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-3 py-3">No.</th>
                        <th class="py-3">Mata Pelajaran</th>
                        <th class="py-3">Predikat</th>
                        <th class="py-3">Nilai Akhir</th>
                        <th class="py-3">Status</th>
                        <th class="py-3" style="min-width: 260px;">Deskripsi Capaian</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($detail as $item)
                        @php
                            $nilaiAkhir = $item->nilai_akhir;

                            if ($nilaiAkhir === null || $nilaiAkhir === '') {
                                $predikat = '-';
                            } elseif ($nilaiAkhir >= 90) {
                                $predikat = 'A';
                            } elseif ($nilaiAkhir >= 80) {
                                $predikat = 'B';
                            } elseif ($nilaiAkhir >= 70) {
                                $predikat = 'C';
                            } else {
                                $predikat = 'D';
                            }
                        @endphp

                        <tr>
                            <td class="px-3">{{ $loop->iteration }}</td>

                            <td>
                                <div class="fw-medium">{{ $item->nama_mapel }}</div>
                                <small class="text-muted">{{ $item->kode_mapel }}</small>
                            </td>

                            <td>
                                <span class="badge text-bg-primary">
                                    {{ $predikat }}
                                </span>
                            </td>

                            <td class="fw-semibold">
                                {{ $nilaiAkhir !== null ? $nilaiAkhir : '-' }}
                            </td>

                            <td>
                                @if ($item->status === 'aman')
                                    <span class="badge text-bg-success">Aman</span>
                                @else
                                    <span class="badge text-bg-warning">Perlu Revisi</span>
                                @endif
                            </td>

                            <td>
                                <div class="small text-break">
                                    {{ filled($item->deskripsi_capaian) ? $item->deskripsi_capaian : 'Belum diisi oleh guru mata pelajaran.' }}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted p-4">
                                Belum ada detail nilai. Periksa kembali proses generate rapor.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if ($rapor->status !== 'final' && $detail->isNotEmpty())
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-1">Ajukan Permintaan Revisi</h5>
            <small class="text-muted">
                Pilih mata pelajaran yang perlu diperbaiki. Guru akan menerima permintaan pada halaman Permintaan Revisi Rapor.
            </small>
        </div>

        <div class="card-body">
            <form
                method="POST"
                action="{{ route('wali-kelas.rapor.minta-revisi', [
                    'kelasId' => $kelas->id,
                    'tahunAjaranId' => $kelas->tahun_ajaran_id,
                    'siswaId' => $siswa->id
                ]) }}"
                onsubmit="return confirm('Kirim permintaan revisi kepada guru mata pelajaran yang dipilih?');"
            >
                @csrf

                <div class="mb-3">
                    <label for="mata_pelajaran_id" class="form-label">
                        Mata Pelajaran
                    </label>

                    <select
                        id="mata_pelajaran_id"
                        name="mata_pelajaran_id"
                        class="form-select"
                        required
                    >
                        <option value="">Pilih mata pelajaran</option>

                        @foreach ($detail as $item)
                            <option
                                value="{{ $item->mata_pelajaran_id }}"
                                {{ old('mata_pelajaran_id') == $item->mata_pelajaran_id ? 'selected' : '' }}
                            >
                                {{ $item->nama_mapel }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="alasan_revisi" class="form-label">
                        Alasan Revisi
                    </label>

                    <textarea
                        id="alasan_revisi"
                        name="alasan_revisi"
                        class="form-control"
                        rows="4"
                        maxlength="5000"
                        placeholder="Contoh: Mohon periksa kembali nilai akhir dan sesuaikan deskripsi capaian dengan hasil belajar siswa."
                        required
                    >{{ old('alasan_revisi') }}</textarea>
                </div>

                <button type="submit" class="btn btn-outline-warning">
                    <i class="bi bi-arrow-repeat me-1"></i>
                    Kirim Permintaan Revisi
                </button>
            </form>
        </div>
    </div>
@endif

    <form
        method="POST"
        action="{{ route('wali-kelas.rapor.detail.update', [
            'kelasId' => $kelas->id,
            'tahunAjaranId' => $kelas->tahun_ajaran_id,
            'siswaId' => $siswa->id
        ]) }}"
    >
        @csrf
        @method('PUT')

        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Catatan Wali Kelas</h5>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label for="catatan_wali_kelas" class="form-label">
                        Catatan untuk Siswa
                    </label>

                    <textarea
                        id="catatan_wali_kelas"
                        name="catatan_wali_kelas"
                        class="form-control"
                        rows="4"
                        maxlength="5000"
                        {{ $rapor->status === 'final' ? 'readonly' : '' }}
                    >{{ old('catatan_wali_kelas', $rapor->catatan_wali_kelas) }}</textarea>
                </div>

                @if ($rapor->status !== 'final')
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Simpan Catatan
                    </button>
                @else
                    <div class="alert alert-success mb-0">
                        Rapor sudah final. Catatan dan nilai hanya dapat dilihat.
                    </div>
                @endif
            </div>
        </div>
    </form>

    @if ($rapor->status !== 'final')
        <div class="d-flex flex-wrap gap-2">

            <form
                method="POST"
                action="{{ route('wali-kelas.rapor.finalisasi', [
                    'kelasId' => $kelas->id,
                    'tahunAjaranId' => $kelas->tahun_ajaran_id,
                    'siswaId' => $siswa->id
                ]) }}"
                onsubmit="return confirm('Finalisasi rapor ini? Setelah final, rapor tidak dapat diedit atau dihitung ulang.');"
            >
                @csrf

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle me-1"></i>
                    Finalisasi Rapor
                </button>
            </form>
        </div>
    @endif
</div>
@endsection
