@extends('layouts.app')

@section('title', 'Penilaian ' . $mataPelajaran->nama_mapel)

@push('styles')
<style>
    .academic-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .1);
        margin-bottom: 24px;
    }

    .academic-header {
        margin-bottom: 20px;
    }

    .academic-header h1 {
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 4px;
    }

    .academic-header p {
        font-size: 13px;
        color: #64748b;
        margin: 0;
    }

    .btn-back-link {
        color: #64748b;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 20px;
    }

    .btn-back-link:hover {
        color: #2563eb;
    }

    .assessment-card {
        display: block;
        position: relative;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 28px;
        text-decoration: none;
        overflow: hidden;
        transition: .2s ease;
        min-height: 220px;
    }

    .assessment-card:hover {
        transform: translateY(-3px);
        border-color: #bfdbfe;
        box-shadow: 0 8px 20px rgba(37, 99, 235, .10);
    }

    .assessment-icon {
        width: 54px;
        height: 54px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 20px;
    }

    .harian-icon {
        background: #eff6ff;
        color: #2563eb;
    }

    .ujian-icon {
        background: #f0fdf4;
        color: #16a34a;
    }

    .assessment-card h2 {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 8px;
    }

    .assessment-card p {
        color: #64748b;
        font-size: 12px;
        line-height: 1.6;
        margin: 0;
    }

    .assessment-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 25px;
    }

    .assessment-footer span {
        font-size: 12px;
        font-weight: 600;
        color: #2563eb;
    }

    .ujian-card .assessment-footer span {
        color: #16a34a;
    }

    .assessment-footer i {
        color: #94a3b8;
        font-size: 18px;
    }
</style>
@endpush

@section('content')

<div class="academic-container">

    <a
        href="{{ route('admin.penilaian.mapel.kelas', $kelas->id) }}"
        class="btn-back-link"
    >
        <i class="bi bi-arrow-left"></i>
        Kembali ke Mata Pelajaran
    </a>

    <div class="academic-header">

        <h1>{{ $mataPelajaran->nama_mapel }}</h1>

        <p>
            {{ $kelas->tingkat }} {{ $kelas->nama_kelas }}

            @if($kelas->jurusan)
                — {{ $kelas->jurusan->nama_jurusan }}
            @endif
        </p>

    </div>

    <div class="academic-card">

        <div class="mb-4">

            <h5 class="fw-bold mb-1">
                Pilih Jenis Penilaian
            </h5>

            <p class="text-muted small mb-0">
                Pilih jenis penilaian yang ingin dikelola.
            </p>

        </div>

        <div class="row g-4">

            <div class="col-md-6">

                <a
                    href="{{ route('admin.penilaian.mapel.harian', [
                        'kelasId' => $kelas->id,
                        'mapelId' => $mataPelajaran->id
                    ]) }}"
                    class="assessment-card"
                >

                    <div class="assessment-icon harian-icon">
                        <i class="bi bi-journal-text"></i>
                    </div>

                    <h2>Penilaian Harian</h2>

                    <p>
                        Kelola nilai penilaian harian siswa
                        untuk mata pelajaran {{ $mataPelajaran->nama_mapel }}.
                    </p>

                    <div class="assessment-footer">

                        <span>
                            Buka Penilaian Harian
                        </span>

                        <i class="bi bi-arrow-right"></i>

                    </div>

                </a>

            </div>

            <div class="col-md-6">

                <a
                    href="{{ route('admin.penilaian.mapel.ujian', [
                        'kelasId' => $kelas->id,
                        'mapelId' => $mataPelajaran->id
                    ]) }}"
                    class="assessment-card ujian-card"
                >

                    <div class="assessment-icon ujian-icon">
                        <i class="bi bi-file-earmark-check"></i>
                    </div>

                    <h2>Penilaian Ujian</h2>

                    <p>
                        Kelola nilai ujian siswa
                        untuk mata pelajaran {{ $mataPelajaran->nama_mapel }}.
                    </p>

                    <div class="assessment-footer">

                        <span>
                            Buka Penilaian Ujian
                        </span>

                        <i class="bi bi-arrow-right"></i>

                    </div>

                </a>

            </div>

        </div>

    </div>

</div>

@endsection