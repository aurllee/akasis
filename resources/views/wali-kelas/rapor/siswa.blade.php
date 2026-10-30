
@extends('layouts.app')

@section('title', 'Daftar Rapor Siswa')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h3 class="fw-semibold mt-3 mb-1">
            Rapor Kelas {{ $kelas->tingkat }} {{ $kelas->nama_kelas }}
        </h3>

        <p class="text-muted mb-0">
            Tahun Ajaran {{ $kelas->tahun_ajaran }} · Semester {{ $kelas->semester }}
        </p>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    @if ($siswa->isEmpty())
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 text-center text-muted">
                Belum ada siswa yang terdaftar di kelas ini.
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">No.</th>
                                <th class="py-3">NIS</th>
                                <th class="py-3">Nama Siswa</th>
                                <th class="py-3">Status Rapor</th>
                                <th class="text-end px-4 py-3">Tindakan</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($siswa as $item)
                                @php
                                    $dataRapor = $rapor->get($item->id);
                                @endphp

                                <tr>
                                    <td class="px-4">{{ $loop->iteration }}</td>

                                    <td>{{ $item->nis }}</td>

                                    <td class="fw-medium">{{ $item->nama }}</td>

                                    <td>
                                        @if (!$dataRapor)
                                            <span class="badge text-bg-secondary">
                                                Belum Dibuat
                                            </span>
                                        @elseif ($dataRapor->status === 'final' && !empty($dataRapor->dipublikasikan_at))
                                            <span class="badge text-bg-success">
                                                Sudah Dipublikasikan
                                            </span>
                                        @elseif ($dataRapor->status === 'final')
                                            <span class="badge text-bg-primary">
                                                Final - Belum Dipublikasikan
                                            </span>
                                        @elseif ($dataRapor->status === 'perlu_revisi')
                                            <span class="badge text-bg-warning">
                                                Perlu Revisi
                                            </span>
                                        @else
                                            <span class="badge text-bg-light border text-dark">
                                                Draft
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-end px-4">
                                        <div class="d-inline-flex gap-2 flex-wrap justify-content-end">
                                            @if ($dataRapor)
                                                <a
                                                    href="{{ route('wali-kelas.rapor.detail', [
                                                        'kelasId' => $kelas->id,
                                                        'tahunAjaranId' => $kelas->tahun_ajaran_id,
                                                        'siswaId' => $item->id
                                                    ]) }}"
                                                    class="btn btn-sm btn-outline-primary rounded-3 px-3"
                                                >
                                                    <i class="bi bi-eye me-1"></i>
                                                    Lihat Rapor
                                                </a>
                                            @endif

                                            @if (!$dataRapor || $dataRapor->status !== 'final')
                                                <form
                                                    action="{{ route('wali-kelas.rapor.generate', [
                                                        'kelasId' => $kelas->id,
                                                        'tahunAjaranId' => $kelas->tahun_ajaran_id,
                                                        'siswaId' => $item->id
                                                    ]) }}"
                                                    method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Generate nilai rapor untuk siswa ini? Nilai draft yang sudah ada dapat diperbarui.');"
                                                >
                                                    @csrf

                                                    <button type="submit" class="btn btn-sm btn-primary rounded-3 px-3">
                                                        {{ $dataRapor ? 'Hitung Ulang' : 'Generate Rapor' }}
                                                    </button>
                                                </form>
                                            @endif

                                            @if ($dataRapor && $dataRapor->status === 'final')
                                                @if (empty($dataRapor->dipublikasikan_at))
                                                    <form
                                                        action="{{ route('wali-kelas.rapor.publikasi', [
                                                            'kelasId' => $kelas->id,
                                                            'tahunAjaranId' => $kelas->tahun_ajaran_id,
                                                            'siswaId' => $item->id
                                                        ]) }}"
                                                        method="POST"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Publikasikan rapor {{ $item->nama }} agar dapat dilihat siswa?');"
                                                    >
                                                        @csrf

                                                        <button type="submit" class="btn btn-sm btn-success rounded-3 px-3">
                                                            <i class="bi bi-megaphone me-1"></i>
                                                            Publikasikan
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="badge text-bg-success align-self-center">
                                                        <i class="bi bi-check-circle me-1"></i>
                                                        Sudah Dipublikasikan
                                                    </span>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
