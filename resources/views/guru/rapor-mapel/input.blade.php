
@extends('layouts.app')

@section('title', 'Input Nilai Rapor Mapel')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <a href="{{ route('guru.rapor-mapel.index') }}" class="btn btn-outline-secondary btn-sm mb-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>

        <h3 class="fw-semibold mb-1">Input Nilai Rapor Mapel</h3>

        <p class="text-muted mb-1">
            Kelas {{ $jadwal->tingkat }} {{ $jadwal->nama_kelas }}
            · {{ $jadwal->nama_mapel }}
        </p>

        <p class="text-muted mb-3">
            Tahun Ajaran {{ $jadwal->tahun_ajaran }}
            · Semester {{ $jadwal->semester }}
        </p>

        <a href="{{ route('guru.rapor-mapel.deskripsi', ['jadwalId' => $jadwal->jadwal_id]) }}"
           class="btn btn-outline-primary btn-sm">
            <i class="bi bi-file-text me-1"></i> Isi Deskripsi Capaian
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Periksa kembali nilai yang dimasukkan:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    

    <form method="POST"
          action="{{ route('guru.rapor-mapel.store', ['jadwalId' => $jadwal->jadwal_id]) }}">
        @csrf

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-1">Rekap Nilai Siswa</h5>
                <small class="text-muted">
                    Nilai akhir awal dihitung dari rata-rata harian dan ujian yang tersedia.
                </small>
            </div>

            <div class="card-body p-0">
                @if ($siswa->isEmpty())
                    <div class="p-4 text-center text-muted">
                        Belum ada siswa yang terdaftar pada kelas ini.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-3 py-3">No.</th>
                                    <th class="py-3">NIS</th>
                                    <th class="py-3">Nama Siswa</th>
                                    <th class="py-3 text-center">Rata-rata Harian</th>
                                    <th class="py-3 text-center">Rata-rata Ujian</th>
                                    <th class="py-3" style="min-width: 170px;">Nilai Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($siswa as $item)
                                    @php
                                        $dataRekap = $rekap->get($item->id, [
                                            'rata_harian' => null,
                                            'rata_ujian' => null,
                                            'nilai_awal' => null,
                                        ]);

                                        $nilaiTersimpan = $nilaiAkhirTersimpan->get($item->id);
                                        $nilaiAwal = old(
                                            'nilai_akhir.' . $item->id,
                                            $nilaiTersimpan !== null
                                                ? $nilaiTersimpan
                                                : $dataRekap['nilai_awal']
                                        );
                                    @endphp

                                    <tr>
                                        <td class="px-3">{{ $loop->iteration }}</td>
                                        <td>{{ $item->nis }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td class="text-center">
                                            {{ $dataRekap['rata_harian'] ?? '-' }}
                                        </td>
                                        <td class="text-center">
                                            {{ $dataRekap['rata_ujian'] ?? '-' }}
                                        </td>
                                        <td>
                                            <input
                                                type="number"
                                                name="nilai_akhir[{{ $item->id }}]"
                                                class="form-control"
                                                min="0"
                                                max="100"
                                                step="0.01"
                                                value="{{ $nilaiAwal }}"
                                                placeholder="0–100"
                                            >

                                            @if ($nilaiTersimpan !== null)
                                                <small class="text-success">
                                                    Nilai akhir telah disesuaikan
                                                </small>
                                            @elseif ($dataRekap['nilai_awal'] === null)
                                                <small class="text-muted">
                                                    Belum ada nilai sumber
                                                </small>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="p-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <small class="text-muted">
                            Kosongkan kolom jika belum ingin menyimpan nilai akhir siswa tersebut.
                            Nilai akhir yang sudah tersimpan tidak dihapus hanya karena kolom dikosongkan.
                        </small>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan Nilai Akhir
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </form>
</div>
@endsection
