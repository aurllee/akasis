
@extends('layouts.app')

@section('title', 'Detail Nilai Rapor Mapel')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <a href="{{ route('guru.rapor-mapel.index') }}"
           class="btn btn-outline-secondary btn-sm mb-3">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>

        <h3 class="fw-semibold mb-1">Detail Nilai Rapor Mapel</h3>

        <p class="text-muted mb-1">
            {{ $jadwal->nama_mapel }} —
            {{ $jadwal->tingkat }} {{ $jadwal->nama_kelas }}
        </p>

        <p class="text-muted mb-0">
            Tahun Ajaran {{ $jadwal->tahun_ajaran }}
            · Semester {{ $jadwal->semester }}
        </p>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <p class="text-muted mb-1">Jumlah Siswa</p>
                    <h3 class="fw-semibold mb-0">{{ $siswa->count() }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <p class="text-muted mb-1">Jumlah Penilaian</p>
                    <h3 class="fw-semibold mb-0">{{ $nilai->count() }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <p class="text-muted mb-1">Siswa Sudah Dinilai</p>
                    <h3 class="fw-semibold mb-0">
                        {{ $rekap->count() }}
                    </h3>
                </div>
            </div>
        </div>
    </div>

    

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 p-4">
            <h5 class="fw-semibold mb-1">Semua Riwayat Penilaian</h5>
            <p class="text-muted mb-0">
                Daftar setiap nilai yang telah tersimpan, termasuk tanggal dan judul penilaian.
            </p>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">No.</th>
                            <th class="py-3">NIS</th>
                            <th class="py-3">Nama Siswa</th>
                            <th class="py-3">Jenis Nilai</th>
                            <th class="py-3">Judul Tugas/Ujian</th>
                            <th class="py-3">Tanggal</th>
                            <th class="py-3">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($nilai as $item)
                            <tr>
                                <td class="px-4">{{ $loop->iteration }}</td>
                                <td>{{ $item->nis }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>
                                    <span class="badge {{ $item->jenis_nilai === 'ujian' ? 'bg-info text-dark' : 'bg-primary' }}">
                                        {{ ucfirst($item->jenis_nilai) }}
                                    </span>
                                </td>
                                <td>{{ $item->judul_tugas ?: '-' }}</td>
                                <td>
                                    {{ $item->tanggal_penilaian
                                        ? \Carbon\Carbon::parse($item->tanggal_penilaian)->format('d-m-Y')
                                        : '-' }}
                                </td>
                                <td class="fw-semibold">{{ $item->nilai }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Belum ada nilai yang diinput untuk jadwal ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
