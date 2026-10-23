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
                        <th>Nama</th>
                        <th>NIS</th>
                        <th>Total Poin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayat as $item)
                        <tr>
                            <td>{{ $riwayat->firstItem() + $loop->index }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->nis ?? '-' }}</td>
                            <td>{{ $item->total_poin ?? 0 }}</td>
                            <td>
                                <a href="{{ route('tatib.riwayat.detail', $item->siswa_id) }}"
                                    class="btn btn-sm btn-primary">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada riwayat pelanggaran siswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $riwayat->links() }}
    </div>
@endsection