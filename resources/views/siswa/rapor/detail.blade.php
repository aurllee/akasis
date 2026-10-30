
@extends('layouts.app')

@section('title', 'Detail Rapor')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Rapor Siswa</h3>
            <p class="text-muted mb-0">
                Tahun Ajaran {{ $rapor->tahun_ajaran }}
                — Semester {{ $rapor->semester }}
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('siswa.rapor.index') }}" class="btn btn-secondary">
                Kembali
            </a>
            <button onclick="window.print()" class="btn btn-primary">
                Cetak / Simpan PDF
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm" id="area-rapor">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <h4 class="fw-bold">RAPOR HASIL BELAJAR SISWA</h4>
                <p class="mb-0">Tahun Ajaran {{ $rapor->tahun_ajaran }}</p>
            </div>

            <table class="table table-borderless mb-4">
                <tr>
                    <td width="180">Nama Siswa</td>
                    <td width="10">:</td>
                    <td>{{ $siswa->nama }}</td>
                </tr>
                <tr>
                    <td>NIS</td>
                    <td>:</td>
                    <td>{{ $siswa->nis }}</td>
                </tr>
                <tr>
                    <td>NISN</td>
                    <td>:</td>
                    <td>{{ $siswa->nisn }}</td>
                </tr>
                <tr>
                    <td>Kelas</td>
                    <td>:</td>
                    <td>{{ $rapor->tingkat }} {{ $rapor->nama_kelas }}</td>
                </tr>
                <tr>
                    <td>Semester</td>
                    <td>:</td>
                    <td>{{ $rapor->semester }}</td>
                </tr>
            </table>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="60">No.</th>
                            <th>Mata Pelajaran</th>
                            <th width="120">Nilai Akhir</th>
                            <th>Deskripsi Capaian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($detail as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_mapel ?? '-' }}</td>
                                <td>{{ $item->nilai_akhir ?? '-' }}</td>
                                <td>{{ $item->deskripsi_capaian ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    Belum ada detail nilai pada rapor ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <h6 class="fw-bold">Catatan Wali Kelas</h6>
                <p>{{ $rapor->catatan_wali_kelas ?: 'Tidak ada catatan.' }}</p>
            </div>

            <div class="text-end mt-5">
                <p>Rapor dipublikasikan pada</p>
                <p>
                    {{ \Carbon\Carbon::parse($rapor->dipublikasikan_at)->format('d-m-Y H:i') }}
                </p>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    body {
        background: #fff !important;
    }

    .sidebar,
    nav,
    .navbar,
    .btn {
        display: none !important;
    }

    .container-fluid {
        margin: 0 !important;
        padding: 0 !important;
    }

    #area-rapor {
        box-shadow: none !important;
        border: none !important;
    }

    @page {
        size: A4 portrait;
        margin: 15mm;
    }
}
</style>
@endsection
