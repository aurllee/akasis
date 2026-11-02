@extends('layouts.app')

@section('title', 'Detail Progres Rapor Kelas')

@push('styles')
<style>
    .rapor-detail {
        --rapor-primary: #2449A4;
        color: #1e293b;
        font-family: 'Poppins', sans-serif;
    }

    .rapor-detail-header,
    .rapor-detail-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(15, 23, 42, .05);
    }

    .rapor-detail-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        padding: 24px;
        margin-bottom: 20px;
    }

    .rapor-detail-title {
        margin: 0 0 6px;
        color: var(--rapor-primary);
        font-size: 24px;
        font-weight: 700;
    }

    .rapor-detail-subtitle {
        margin: 0;
        color: #64748b;
        font-size: 14px;
    }

    .rapor-detail-back {
        display: inline-flex;
        flex-shrink: 0;
        align-items: center;
        gap: 7px;
        padding: 9px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        color: #334155;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: background .2s ease, color .2s ease;
    }

    .rapor-detail-back:hover {
        background: #eff6ff;
        color: var(--rapor-primary);
    }

    .rapor-detail-card {
        padding: 22px;
    }

    .rapor-student-table-wrap {
        overflow-x: auto;
    }

    .rapor-student-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 13px;
    }

    .rapor-student-table th {
        padding: 12px 14px;
        background: #eff6ff;
        color: #1e3a8a;
        font-size: 11px;
        font-weight: 700;
        text-align: left;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .rapor-student-table td {
        padding: 13px 14px;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: middle;
    }

    .rapor-student-table tbody tr:hover td {
        background: #f8fbff;
    }

    .rapor-student-name {
        font-weight: 600;
    }

    .rapor-student-action {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 11px;
        border: 1px solid var(--rapor-primary);
        border-radius: 7px;
        background: var(--rapor-primary);
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
    }

    .rapor-student-action:hover {
        background: #1d3d8c;
        color: #fff;
    }

    .rapor-detail-card h2 {
        margin: 0 0 4px;
        font-size: 17px;
        font-weight: 700;
    }

    .rapor-detail-note {
        margin: 0 0 18px;
        color: #64748b;
        font-size: 13px;
    }

    .rapor-detail-table-wrap {
        overflow-x: auto;
    }

    .rapor-detail-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 13px;
    }

    .rapor-detail-table th {
        padding: 12px 14px;
        background: #eff6ff;
        color: #1e3a8a;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .03em;
        text-align: left;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .rapor-detail-table th:first-child {
        border-radius: 8px 0 0;
    }

    .rapor-detail-table th:last-child {
        border-radius: 0 8px 0 0;
    }

    .rapor-detail-table td {
        padding: 14px;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: middle;
    }

    .rapor-detail-table tbody tr:hover td {
        background: #f8fbff;
    }

    .rapor-mapel-name {
        display: block;
        font-weight: 600;
    }

    .rapor-mapel-code {
        display: block;
        margin-top: 3px;
        color: #64748b;
        font-size: 11px;
    }

    .rapor-progress-cell {
        min-width: 190px;
    }

    .rapor-progress-label {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 7px;
        color: #475569;
        font-size: 12px;
    }

    .rapor-progress-track {
        height: 8px;
        overflow: hidden;
        border-radius: 999px;
        background: #e2e8f0;
    }

    .rapor-progress-fill {
        height: 100%;
        border-radius: inherit;
        background: var(--rapor-primary);
    }

    .rapor-status {
        display: inline-flex;
        align-items: center;
        padding: 5px 9px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .rapor-status-empty {
        background: #f1f5f9;
        color: #475569;
    }

    .rapor-detail-empty {
        padding: 28px 16px;
        color: #64748b;
        text-align: center;
    }

    @media (max-width: 640px) {
        .rapor-detail-header {
            flex-direction: column;
            padding: 20px;
        }

        .rapor-detail-card {
            padding: 16px;
        }
    }
</style>
@endpush

@section('content')
<div class="rapor-detail">
    <header class="rapor-detail-header">
        <div>
            <h1 class="rapor-detail-title">Detail Progres Rapor Kelas</h1>
            <p class="rapor-detail-subtitle">
                {{ $kelas->nama_kelas }}
                @if($kelas->jurusan)
                · {{ $kelas->jurusan->nama_jurusan }}
                @endif
                · Tingkat {{ $kelas->tingkat }}
            </p>
            <p class="rapor-detail-subtitle">
                Tahun ajaran {{ $tahunAjaran->tahun_ajaran }}
                · Semester {{ $tahunAjaran->semester }}
            </p>
        </div>

        <a href="{{ route('kurikulum.rapor.index') }}" class="rapor-detail-back">
            <i class="bi bi-arrow-left" aria-hidden="true"></i>
            Kembali ke Monitoring Rapor
        </a>
    </header>

    <section class="rapor-detail-card">
        <h2>Progres Nilai Mata Pelajaran</h2>
        <p class="rapor-detail-note">
            Progres dihitung dari seluruh komponen penilaian yang sudah tercatat
            untuk mata pelajaran ini dan seluruh {{ $jumlahSiswa }} siswa di kelas.
            Siswa lengkap memiliki nilai pada semua komponen tercatat; sebagian
            memiliki nilai pada setidaknya satu komponen, tetapi belum semuanya.
            Komponen dibedakan berdasarkan jadwal, jenis nilai (Harian/Ujian),
            tanggal, dan judul tugas.
        </p>

        <div class="alert alert-warning py-2 mb-3" role="note">
            Komponen wajib tidak memiliki daftar terpisah di database. Karena itu,
            komponen pembanding di bawah berasal dari komponen yang sudah memiliki
            record nilai pada setidaknya satu siswa. Komponen yang belum tercatat
            untuk siapa pun tidak dapat terdeteksi sebagai komponen yang seharusnya ada.
        </div>

        <div class="rapor-detail-table-wrap">
            <table class="rapor-detail-table">
                <thead>
                    <tr>
                        <th>Mata Pelajaran</th>
                        <th>Progres Komponen Nilai</th>
                        <th>Siswa Lengkap</th>
                        <th>Siswa Sebagian</th>
                        <th>Tanpa Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mataPelajaran as $mapel)
                    <tr>
                        <td>
                            <span class="rapor-mapel-name">{{ $mapel->nama_mapel }}</span>
                            @if($mapel->kode_mapel)
                            <span class="rapor-mapel-code">{{ $mapel->kode_mapel }}</span>
                            @endif
                        </td>
                        <td class="rapor-progress-cell">
                            @if($mapel->jumlah_komponen > 0)
                            <div class="rapor-progress-label">
                                <span>
                                    {{ $mapel->jumlah_komponen_terisi }}/{{ $mapel->jumlah_komponen_target }}
                                    komponen siswa
                                </span>
                                <strong>{{ $mapel->progress_persen }}%</strong>
                            </div>
                            <div
                                class="rapor-progress-track"
                                role="progressbar"
                                aria-label="Progres nilai {{ $mapel->nama_mapel }}"
                                aria-valuemin="0"
                                aria-valuemax="100"
                                aria-valuenow="{{ $mapel->progress_persen }}">
                                <div
                                    class="rapor-progress-fill"
                                    style="width: {{ $mapel->progress_persen }}%"></div>
                            </div>
                            @else
                            <span class="rapor-status rapor-status-empty">
                                Komponen penilaian belum tersedia
                            </span>
                            @endif
                        </td>
                        <td>
                            {{ $mapel->jumlah_siswa_lengkap }} siswa
                        </td>
                        <td>
                            {{ $mapel->jumlah_siswa_sebagian }} siswa
                        </td>
                        <td>
                            @if($mapel->jumlah_komponen === 0)
                            <span class="rapor-status rapor-status-empty">
                                {{ $jumlahSiswa }} siswa · belum ada komponen
                            </span>
                            @else
                            {{ $mapel->jumlah_siswa_tanpa_nilai }} siswa
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="rapor-detail-empty">
                            Belum ada mata pelajaran yang dijadwalkan untuk kelas ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="rapor-detail-card mt-4">
        <h2>Daftar Siswa</h2>
        <p class="rapor-detail-note">
            Status ditentukan dari nilai yang sudah tercatat pada seluruh mata pelajaran
            terjadwal di kelas ini. Siswa tanpa nilai tetap ditampilkan.
        </p>

        <div class="rapor-student-table-wrap">
            <table class="rapor-student-table">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th>NISN</th>
                        <th>Status Kelengkapan Rapor</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="rapor-student-name">{{ $item->nama }}</td>
                        <td>{{ $item->nis ?: '-' }}</td>
                        <td>{{ $item->nisn ?: '-' }}</td>
                        <td>
                            <span class="rapor-status rapor-status-empty">
                                {{ $item->status_rapor }}
                            </span>
                        </td>
                        <td>
                            <a
                                href="{{ route('kurikulum.rapor.siswa', ['kelas' => $kelas->id, 'siswa' => $item->id]) }}"
                                class="rapor-student-action">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="rapor-detail-empty">
                            Belum ada siswa yang terdaftar pada kelas ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection