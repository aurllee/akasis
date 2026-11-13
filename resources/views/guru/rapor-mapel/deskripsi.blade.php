@extends('layouts.app')

@section('title', 'Deskripsi Capaian Rapor')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h3 class="fw-semibold mb-1">Deskripsi Capaian Rapor</h3>
            <p class="text-muted mb-0">
                {{ $jadwal->nama_mapel }} — Kelas {{ $jadwal->tingkat }} {{ $jadwal->nama_kelas }}
            </p>
            <small class="text-muted">
                Tahun Ajaran {{ $jadwal->tahun_ajaran }} · Semester {{ $jadwal->semester }}
            </small>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('guru.rapor-mapel.input', ['jadwalId' => $jadwal->jadwal_id]) }}" class="btn btn-outline-secondary">
                Input Nilai
            </a>
            <a href="{{ route('guru.rapor-mapel.index') }}" class="btn btn-outline-secondary">
                Kembali ke Daftar
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="alert alert-info">
        Isi deskripsi setelah penilaian mata pelajaran selesai. Deskripsi disimpan terpisah dari nilai harian dan ujian, sehingga tidak perlu diisi setiap kali memasukkan nilai.
    </div>

    <form action="{{ route('guru.rapor-mapel.store-deskripsi', ['jadwalId' => $jadwal->jadwal_id]) }}" method="POST">
        @csrf

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-3 py-3" style="width: 60px;">No.</th>
                                <th class="py-3" style="min-width: 110px;">NIS</th>
                                <th class="py-3" style="min-width: 200px;">Nama Siswa</th>
                                <th class="py-3" style="min-width: 140px;">Jumlah Nilai</th>
                                <th class="py-3" style="min-width: 360px;">Deskripsi Capaian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($siswa as $item)
                                <tr>
                                    <td class="px-3">{{ $loop->iteration }}</td>
                                    <td>{{ $item->nis }}</td>
                                    <td class="fw-medium">{{ $item->nama }}</td>
                                    <td>
                                        @php($jumlah = (int) $jumlahNilai->get($item->id, 0))
                                        @if ($jumlah > 0)
                                            <span class="badge bg-success">{{ $jumlah }} penilaian</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Belum ada nilai</span>
                                        @endif
                                    </td>
                                    <td class="pe-3">
                                        <textarea
                                            name="deskripsi_capaian[{{ $item->id }}]"
                                            class="form-control @error('deskripsi_capaian.' . $item->id) is-invalid @enderror"
                                            rows="3"
                                            maxlength="2000"
                                            placeholder="Tuliskan deskripsi capaian siswa..."
                                        >{{ old('deskripsi_capaian.' . $item->id, $deskripsiCapaian->get($item->id, '')) }}</textarea>
                                        @error('deskripsi_capaian.' . $item->id)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5">
                                        Belum ada siswa yang terdaftar di kelas ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($siswa->isNotEmpty())
                <div class="card-footer bg-white d-flex justify-content-end p-3">
                    <button type="submit" class="btn btn-primary">
                        Simpan Semua Deskripsi
                    </button>
                </div>
            @endif
        </div>
    </form>
</div>
@endsection
