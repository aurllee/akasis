@extends('layouts.app')

@section('title', 'Rapor Mapel')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h3 class="fw-semibold mb-1">Rapor Mapel</h3>
        <p class="text-muted mb-0">
            Pilih kelas dan mata pelajaran yang kamu ajar untuk menginput nilai rapor siswa.
        </p>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            @if ($jadwal->isEmpty())
                <div class="p-4 text-center text-muted">
                    Belum ada jadwal mengajar untuk akun ini.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">No.</th>
                                <th class="py-3">Kelas</th>
                                <th class="py-3">Mata Pelajaran</th>
                                <th class="py-3">Tahun Ajaran</th>
                                <th class="py-3">Semester</th>
                                <th class="py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwal as $item)
                                <tr>
                                    <td class="px-4">{{ $loop->iteration }}</td>
                                    <td>{{ $item->tingkat }} {{ $item->nama_kelas }}</td>
                                    <td>{{ $item->nama_mapel }}</td>
                                    <td>{{ $item->tahun_ajaran ?? '-' }}</td>
                                    <td>{{ $item->semester ?? '-' }}</td>
                                    
<td>
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('guru.rapor-mapel.input', ['jadwalId' => $item->jadwal_id]) }}"
           class="btn btn-primary btn-sm">
            <i class="bi bi-pencil-square"></i> Input Nilai
        </a>

        <a href="{{ route('guru.rapor-mapel.detail', ['jadwalId' => $item->jadwal_id]) }}"
           class="btn btn-outline-info btn-sm">
            <i class="bi bi-list-check"></i> Detail Nilai
        </a>

        <a href="{{ route('guru.rapor-mapel.deskripsi', ['jadwalId' => $item->jadwal_id]) }}"
   class="btn btn-outline-primary btn-sm">
    Deskripsi Capaian
</a>
    </div>
</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection