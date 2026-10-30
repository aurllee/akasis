@extends('layouts.app')

@section('title', 'Rapor Digital')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h3 class="fw-semibold mb-1">Rapor Digital</h3>
        <p class="text-muted mb-0">Pilih kelas dan semester untuk mengelola rapor siswa.</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            @if ($kelas->isEmpty())
                <div class="p-4 text-center text-muted">
                    Belum ada penugasan wali kelas untuk akun ini.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">No.</th>
                                <th class="py-3">Kelas</th>
                                <th class="py-3">Tahun Ajaran</th>
                                <th class="py-3">Semester</th>
                                <th class="py-3 text-end px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kelas as $item)
                                <tr>
                                    <td class="px-4">{{ $loop->iteration }}</td>
                                    <td>{{ $item->tingkat }} {{ $item->nama_kelas }}</td>
                                    <td>{{ $item->tahun_ajaran }}</td>
                                    <td>{{ $item->semester }}</td>
                                    <td class="text-end px-4">
                                        <a
                                            href="{{ route('wali-kelas.rapor.siswa', [$item->kelas_id, $item->tahun_ajaran_id]) }}"
                                            class="btn btn-sm btn-outline-primary rounded-3"
                                        >
                                            Lihat Siswa
                                        </a>
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