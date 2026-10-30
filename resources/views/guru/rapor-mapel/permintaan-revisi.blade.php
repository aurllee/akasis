@extends('layouts.app')

@section('title', 'Permintaan Revisi Rapor')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <a href="{{ route('guru.rapor-mapel.index') }}"
           class="btn btn-outline-secondary btn-sm mb-3">
            <i class="bi bi-arrow-left me-1"></i>
            Kembali
        </a>

        <h3 class="fw-semibold mb-1">Permintaan Revisi Rapor</h3>
        <p class="text-muted mb-0">
            Periksa alasan dari wali kelas, lalu perbaiki nilai akhir dan deskripsi capaian.
        </p>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @forelse ($permintaan as $item)
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h5 class="mb-1">{{ $item->nama_mapel }}</h5>
                    <div class="text-muted small">
                        {{ $item->nama_siswa }} · NIS {{ $item->nis }}
                    </div>
                    <div class="text-muted small">
                        Kelas {{ $item->tingkat }} {{ $item->nama_kelas }}
                        · Tahun Ajaran {{ $item->tahun_ajaran }}
                        · Semester {{ $item->semester }}
                    </div>
                </div>

                @if ($item->status === 'menunggu')
                    <span class="badge text-bg-warning">Menunggu</span>
                @else
                    <span class="badge text-bg-success">Selesai</span>
                @endif
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Alasan Revisi dari Wali Kelas</label>
                    <div class="p-3 bg-light rounded-3 text-break">
                        {{ $item->alasan_revisi }}
                    </div>
                </div>

                @if ($item->status === 'menunggu')
                    <form method="POST"
                          action="{{ route('guru.rapor-mapel.permintaan-revisi.update', ['id' => $item->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nilai_akhir_{{ $item->id }}" class="form-label fw-semibold">
                                Nilai Akhir
                            </label>
                            <input
                                type="number"
                                id="nilai_akhir_{{ $item->id }}"
                                name="nilai_akhir"
                                class="form-control"
                                min="0"
                                max="100"
                                step="0.01"
                                value="{{ old('nilai_akhir', $item->nilai_akhir_tersimpan ?? $item->nilai_akhir_rapor) }}"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi_{{ $item->id }}" class="form-label fw-semibold">
                                Deskripsi Capaian
                            </label>
                            <textarea
                                id="deskripsi_{{ $item->id }}"
                                name="deskripsi_capaian"
                                class="form-control"
                                rows="4"
                                maxlength="5000"
                                required
                            >{{ old('deskripsi_capaian', $item->deskripsi_tersimpan ?? $item->deskripsi_rapor) }}</textarea>
                        </div>

                        <button type="submit"
                                class="btn btn-primary"
                                onclick="return confirm('Simpan revisi nilai akhir dan deskripsi capaian?');">
                            <i class="bi bi-save me-1"></i>
                            Simpan Revisi
                        </button>
                    </form>
                @else
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3">
                                <div class="text-muted small">Nilai Akhir Tersimpan</div>
                                <div class="fs-4 fw-semibold">
                                    {{ $item->nilai_akhir_tersimpan ?? $item->nilai_akhir_rapor ?? '-' }}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="p-3 bg-light rounded-3">
                                <div class="text-muted small mb-1">Deskripsi Capaian Tersimpan</div>
                                <div class="text-break">
                                    {{ $item->deskripsi_tersimpan ?? $item->deskripsi_rapor ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-success mt-3 mb-0">
                        Revisi sudah disimpan.
                    </div>
                @endif
            </div>

            <div class="card-footer bg-white text-muted small">
                Permintaan dibuat:
                {{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') : '-' }}
            </div>
        </div>
    @empty
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted"></i>
                <h5 class="mt-3">Belum Ada Permintaan Revisi</h5>
                <p class="text-muted mb-0">
                    Permintaan revisi dari wali kelas akan muncul di halaman ini.
                </p>
            </div>
        </div>
    @endforelse
</div>
@endsection