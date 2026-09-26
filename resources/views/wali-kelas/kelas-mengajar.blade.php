@extends('layouts.app')

@section('title', 'Kelas Mengajar')

@section('content')

<div class="page-header">
    <h1>Kelas Mengajar</h1>
    <p>Daftar kelas dan mata pelajaran yang kamu ajar.</p>
</div>

<div class="card">

    <div class="table-wrapper">

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kelas</th>
                    <th>Jurusan</th>
                    <th>Mata Pelajaran</th>
                    <th>Jam Pelajaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($jadwalMengajar as $jadwal)

                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>
                        {{ $jadwal->kelas->tingkat ?? '-' }}
                        {{ $jadwal->kelas->nama_kelas ?? '-' }}
                    </td>

                    <td>
                        {{ $jadwal->kelas->jurusan->nama_jurusan ?? '-' }}
                    </td>

                    <td>
                        {{ $jadwal->mataPelajaran->nama_mapel ?? '-' }}
                    </td>

                    <td>
                        {{ $jadwal->jp_mulai }}–{{ $jadwal->jp_selesai }}
                    </td>

                    <td>
                        <a href="{{ route('wali-kelas.input-nilai', $jadwal->id) }}" class="btn btn-primary btn-sm">
                            Input Nilai
                        </a>
                    </td>
                </tr>

                @empty

                <tr>
                    <td colspan="6">
                        Kamu belum memiliki jadwal mengajar.
                    </td>
                </tr>

                @endforelse

            </tbody>
        </table>

    </div>

</div>

@endsection