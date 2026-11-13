
@extends('layouts.app')

@section('title', 'Rapor Saya')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h3 class="fw-bold">Rapor Saya</h3>
        <p class="text-muted mb-0">
            Daftar rapor yang sudah dipublikasikan oleh wali kelas.
        </p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">{{ $siswa->nama }}</h5>
            <p class="text-muted">NIS: {{ $siswa->nis }}</p>

            @if ($rapor->isEmpty())
                <div class="alert alert-info mb-0">
                    Belum ada rapor yang dipublikasikan untuk akun kamu.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No.</th>
                                <th>Tahun Ajaran</th>
                                <th>Semester</th>
                                <th>Kelas</th>
                                <th>Tanggal Publikasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rapor as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->tahun_ajaran }}</td>
                                    <td>{{ $item->semester }}</td>
                                    <td>
                                        {{ $item->tingkat }}
                                        {{ $item->nama_kelas }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($item->dipublikasikan_at)->format('d-m-Y H:i') }}
                                    </td>
                                    <td>
                                        <a
                                            href="{{ route('siswa.rapor.detail', $item->id) }}"
                                            class="btn btn-primary btn-sm"
                                        >
                                            Lihat Rapor
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
