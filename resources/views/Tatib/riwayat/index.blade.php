@extends('layouts.app')

@section('title', 'Riwayat Siswa')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-3">Riwayat Pelanggaran Siswa</h1>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Siswa</th>
                        <th>Pelanggaran</th>
                        <th>Poin</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayat as $item)
                        <tr>
                            <td>{{ $riwayat->firstItem() + $loop->index }}</td>
                            <td>{{ $item->tanggal ?? '-' }}</td>
                            <td>{{ $item->siswa?->nama ?? 'Siswa tidak ditemukan' }}</td>
                            <td>{{ $item->tatib?->jenis_pelanggaran ?? 'Pelanggaran tidak ditemukan' }}</td>
                            <td>{{ $item->tatib?->poin_pelanggaran ?? '-' }}</td>
                            <td>{{ $item->keterangan ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada riwayat pelanggaran siswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $riwayat->links() }}
    </div>
@endsection