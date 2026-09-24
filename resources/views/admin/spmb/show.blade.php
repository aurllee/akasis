@extends('layouts.app')

@section('title', 'Detail Calon Siswa')

@section('content')

<div class="spmb-detail-page">

    <div class="page-header">
        <div class="page-title">
            <h4>Detail Calon Siswa</h4>
            <p>{{ $calonSiswa->no_pendaftaran }}</p>
        </div>

        <div class="header-actions">
            <a
                href="{{ route('admin.spmb.edit', $calonSiswa->id) }}"
                class="btn-edit"
            >
                Edit
            </a>

            <a
                href="{{ route('admin.spmb.index') }}"
                class="btn-back"
            >
                Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-custom alert-success-custom">
            <div class="alert-content">
                <strong>Berhasil</strong>
                <span>{{ session('success') }}</span>
            </div>

            <button
                type="button"
                class="alert-close"
                data-bs-dismiss="alert"
            >
                ×
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert-custom alert-danger-custom">
            <div class="alert-content">
                <strong>Terjadi Kesalahan</strong>
                <span>{{ session('error') }}</span>
            </div>

            <button
                type="button"
                class="alert-close"
                data-bs-dismiss="alert"
            >
                ×
            </button>
        </div>
    @endif

    <div class="row g-4">

        <div class="col-lg-8">

            <div class="detail-card">

                <div class="card-header-custom">
                    <div>
                        <h5>Data Pribadi</h5>
                        <span>Informasi lengkap calon siswa</span>
                    </div>
                </div>

                <div class="card-body-custom">

                    <div class="detail-grid">

                        <div class="detail-item detail-item-wide">
                            <span class="detail-label">Nama Lengkap</span>
                            <strong class="detail-value">
                                {{ $calonSiswa->nama_lengkap }}
                            </strong>
                        </div>

                        <div class="detail-item detail-item-wide">
                            <span class="detail-label">No. Pendaftaran</span>
                            <strong class="detail-value registration-number">
                                {{ $calonSiswa->no_pendaftaran }}
                            </strong>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">NIK</span>
                            <span class="detail-value">
                                {{ $calonSiswa->nik ?? '-' }}
                            </span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">NISN</span>
                            <span class="detail-value">
                                {{ $calonSiswa->nisn ?? '-' }}
                            </span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Jenis Kelamin</span>
                            <span class="detail-value">
                                {{
                                    in_array(
                                        $calonSiswa->jenis_kelamin,
                                        ['laki-laki', 'Laki-laki', 'L'],
                                        true
                                    )
                                    ? 'Laki-laki'
                                    : (
                                        in_array(
                                            $calonSiswa->jenis_kelamin,
                                            ['perempuan', 'Perempuan', 'P'],
                                            true
                                        )
                                        ? 'Perempuan'
                                        : ucfirst((string) $calonSiswa->jenis_kelamin)
                                    )
                                }}
                            </span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Tempat, Tanggal Lahir</span>
                            <span class="detail-value">
                                {{ $calonSiswa->tempat_lahir ?? '-' }},
                                {{
                                    $calonSiswa->tanggal_lahir
                                    ? $calonSiswa->tanggal_lahir->format('d-m-Y')
                                    : '-'
                                }}
                            </span>
                        </div>

                        <div class="detail-item detail-item-wide">
                            <span class="detail-label">Asal Sekolah</span>
                            <span class="detail-value">
                                {{ $calonSiswa->asal_sekolah ?? '-' }}
                            </span>
                        </div>

                        <div class="detail-item detail-item-full">
                            <span class="detail-label">Alamat</span>
                            <span class="detail-value">
                                {{ $calonSiswa->alamat ?? '-' }}
                            </span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">No. KK</span>
                            <span class="detail-value">
                                {{ $calonSiswa->no_kk ?? '-' }}
                            </span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Ayah</span>
                            <span class="detail-value">
                                {{ $calonSiswa->nama_ayah ?? '-' }}
                            </span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Ibu</span>
                            <span class="detail-value">
                                {{ $calonSiswa->nama_ibu ?? '-' }}
                            </span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">No. HP Orang Tua</span>
                            <span class="detail-value">
                                {{ $calonSiswa->no_hp_ortu ?? '-' }}
                            </span>
                        </div>

                    </div>

                </div>

            </div>

            <div class="detail-card">

                <div class="card-header-custom">
                    <div>
                        <h5>Data SPMB</h5>
                        <span>Informasi pendaftaran dan penerimaan</span>
                    </div>
                </div>

                <div class="card-body-custom">

                    <div class="detail-grid">

                        <div class="detail-item detail-item-wide">
                            <span class="detail-label">Jurusan</span>

                            <div class="jurusan-detail">

                                @if($calonSiswa->jurusan)

                                    <strong class="detail-value">
                                        {{ $calonSiswa->jurusan->nama_jurusan }}
                                    </strong>

                                    <span class="jurusan-code">
                                        {{ $calonSiswa->jurusan->kode_jurusan }}
                                    </span>

                                @else

                                    <span class="empty-text">
                                        Jurusan tidak tersedia
                                    </span>

                                @endif

                            </div>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Jalur Pendaftaran</span>

                            <span class="detail-value">
                                {{ $calonSiswa->jalur_pendaftaran ?? '-' }}
                            </span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Penerimaan</span>

                            <div>

                                @if($calonSiswa->status_penerimaan === 'diterima')

                                    <span class="status-badge status-verified">
                                        Diterima
                                    </span>

                                @else

                                    <span class="status-badge status-rejected">
                                        Tidak Diterima
                                    </span>

                                @endif

                            </div>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Status Daftar Ulang</span>

                            <div>

                                @if($calonSiswa->status_daftar_ulang === 'terverifikasi')

                                    <span class="status-badge status-verified">
                                        Terverifikasi
                                    </span>

                                @elseif($calonSiswa->status_daftar_ulang === 'revisi')

                                    <span class="status-badge status-rejected">
                                        Revisi
                                    </span>

                                @elseif($calonSiswa->status_daftar_ulang === 'menunggu_verifikasi')

                                    <span class="status-badge status-waiting">
                                        Menunggu Verifikasi
                                    </span>

                                @else

                                    <span class="status-badge status-unregistered">
                                        Belum Daftar Ulang
                                    </span>

                                @endif

                            </div>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Tanggal Daftar Ulang</span>

                            <span class="detail-value">
                                {{
                                    $calonSiswa->tanggal_daftar_ulang
                                    ? $calonSiswa->tanggal_daftar_ulang->format('d-m-Y H:i')
                                    : '-'
                                }}
                            </span>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="detail-card status-card">

                <div class="card-header-custom">
                    <div>
                        <h5>Status Daftar Ulang</h5>
                        <span>Status proses verifikasi</span>
                    </div>
                </div>

                <div class="card-body-custom">

                    @if($calonSiswa->status_daftar_ulang === 'terverifikasi')

                        <div class="status-message status-message-success">
                            <strong>Daftar ulang terverifikasi</strong>
                            <span>
                                Semua dokumen telah diverifikasi.
                            </span>
                        </div>

                    @elseif($calonSiswa->status_daftar_ulang === 'revisi')

                        <div class="status-message status-message-danger">
                            <strong>Perlu perbaikan</strong>
                            <span>
                                Terdapat dokumen yang perlu diperbaiki.
                            </span>
                        </div>

                    @elseif($calonSiswa->status_daftar_ulang === 'menunggu_verifikasi')

                        <div class="status-message status-message-warning">
                            <strong>Menunggu verifikasi</strong>
                            <span>
                                Dokumen sedang menunggu proses verifikasi.
                            </span>
                        </div>

                    @else

                        <div class="status-message status-message-neutral">
                            <strong>Belum daftar ulang</strong>
                            <span>
                                Calon siswa belum melakukan daftar ulang.
                            </span>
                        </div>

                    @endif

                    @if($calonSiswa->catatan_revisi)

                        <div class="revision-note">

                            <span>Catatan Revisi</span>

                            <p>
                                {{ $calonSiswa->catatan_revisi }}
                            </p>

                        </div>

                    @endif

                    @if(
                        $calonSiswa->status_penerimaan === 'diterima' &&
                        $calonSiswa->status_daftar_ulang !== 'terverifikasi'
                    )

                        <form
                            action="{{ route(
                                'admin.spmb.daftar-ulang.verifikasi',
                                $calonSiswa->id
                            ) }}"
                            method="POST"
                            class="verification-form"
                        >

                            @csrf
                            @method('PUT')

                            <button
                                type="submit"
                                class="btn-verify"
                                onclick="return confirm('Verifikasi daftar ulang siswa ini?')"
                            >
                                Verifikasi Daftar Ulang
                            </button>

                        </form>

                    @endif

                </div>

            </div>

        </div>

    </div>

    <div class="detail-card documents-card">

        <div class="card-header-custom">
            <div>
                <h5>Dokumen Daftar Ulang</h5>
                <span>
                    Daftar dokumen dan status verifikasi calon siswa
                </span>
            </div>
        </div>

        <div class="table-responsive">

            @php
                $jenisDokumen = [
                    'skl_ijazah' => 'SKL / Ijazah',
                    'rapor' => 'Rapor',
                    'kk' => 'Kartu Keluarga',
                    'akta_kelahiran' => 'Akta Kelahiran',
                    'surat_kesehatan' => 'Surat Kesehatan',
                    'surat_pernyataan_orang_tua' => 'Surat Pernyataan Orang Tua',
                    'bukti_penerimaan' => 'Bukti Penerimaan Tahap',
                ];
            @endphp

            <table class="document-table">

                <thead>
                    <tr>
                        <th>Dokumen</th>
                        <th>File</th>
                        <th>Status</th>
                        <th>Catatan</th>
                        <th width="330">Verifikasi</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($jenisDokumen as $key => $label)

                        @php
                            $dok = $calonSiswa->dokumen
                                ->where('jenis_dokumen', $key)
                                ->first();
                        @endphp

                        <tr>

                            <td>
                                <strong class="document-name">
                                    {{ $label }}
                                </strong>
                            </td>

                            <td>

                                @if($dok)

                                    <a
                                        href="{{ asset('storage/' . $dok->path_file) }}"
                                        target="_blank"
                                        class="document-link"
                                    >
                                        Lihat Dokumen
                                    </a>

                                @else

                                    <span class="empty-text">
                                        Belum diupload
                                    </span>

                                @endif

                            </td>

                            <td>

                                @if(!$dok)

                                    <span class="status-badge status-unregistered">
                                        Belum Ada
                                    </span>

                                @elseif($dok->status === 'Valid')

                                    <span class="status-badge status-verified">
                                        Valid
                                    </span>

                                @elseif($dok->status === 'Tidak Valid')

                                    <span class="status-badge status-rejected">
                                        Tidak Valid
                                    </span>

                                @else

                                    <span class="status-badge status-waiting">
                                        Belum Diverifikasi
                                    </span>

                                @endif

                            </td>

                            <td>

                                @if($dok && $dok->catatan)

                                    <span class="note-text">
                                        {{ $dok->catatan }}
                                    </span>

                                @else

                                    <span class="empty-text">
                                        -
                                    </span>

                                @endif

                            </td>

                            <td>

                                @if($dok)

                                    <form
                                        action="{{ route(
                                            'admin.spmb.dokumen.verifikasi',
                                            [
                                                'id' => $calonSiswa->id,
                                                'dokumenId' => $dok->id
                                            ]
                                        ) }}"
                                        method="POST"
                                        class="document-form"
                                    >

                                        @csrf
                                        @method('PUT')

                                        <select
                                            name="status_verifikasi"
                                            class="verification-select"
                                            required
                                        >
                                            <option
                                                value="Belum Diverifikasi"
                                                @selected($dok->status === 'Belum Diverifikasi')
                                            >
                                                Belum Diverifikasi
                                            </option>

                                            <option
                                                value="Valid"
                                                @selected($dok->status === 'Valid')
                                            >
                                                Valid
                                            </option>

                                            <option
                                                value="Tidak Valid"
                                                @selected($dok->status === 'Tidak Valid')
                                            >
                                                Tidak Valid
                                            </option>
                                        </select>

                                        <input
                                            type="text"
                                            name="catatan"
                                            class="verification-input"
                                            placeholder="Catatan"
                                            value="{{ $dok->catatan }}"
                                        >

                                        <button
                                            type="submit"
                                            class="btn-save"
                                        >
                                            Simpan
                                        </button>

                                    </form>

                                @else

                                    <span class="empty-text">
                                        Menunggu upload
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection

@push('styles')

<style>
    body {
        font-family: 'Poppins', sans-serif;
    }

    .spmb-detail-page {
        width: 100%;
        padding: 6px 2px 30px;
        color: #1e293b;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 24px;
    }

    .page-title h4 {
        margin: 0 0 5px;
        font-size: 23px;
        font-weight: 700;
        color: #172033;
    }

    .page-title p {
        margin: 0;
        color: #718096;
        font-size: 13px;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-edit,
    .btn-back {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 76px;
        padding: 9px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: .2s ease;
    }

    .btn-edit {
        background: #fff7ed;
        color: #c2410c;
        border: 1px solid #fed7aa;
    }

    .btn-edit:hover {
        background: #ffedd5;
        color: #9a3412;
    }

    .btn-back {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
    }

    .btn-back:hover {
        background: #e2e8f0;
        color: #334155;
    }

    .alert-custom {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 13px 15px;
        border-radius: 10px;
        margin-bottom: 18px;
        border: 1px solid;
    }

    .alert-success-custom {
        background: #f0fdf4;
        border-color: #bbf7d0;
        color: #166534;
    }

    .alert-danger-custom {
        background: #fef2f2;
        border-color: #fecaca;
        color: #991b1b;
    }

    .alert-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .alert-content strong {
        font-size: 12px;
        font-weight: 700;
    }

    .alert-content span {
        font-size: 12px;
    }

    .alert-close {
        border: 0;
        background: transparent;
        color: inherit;
        font-size: 18px;
        line-height: 1;
        opacity: .6;
        cursor: pointer;
    }

    .alert-close:hover {
        opacity: 1;
    }

    .detail-card {
        background: #fff;
        border: 1px solid #e8edf5;
        border-radius: 12px;
        margin-bottom: 20px;
        overflow: hidden;
        box-shadow: 0 3px 12px rgba(15, 23, 42, .04);
    }

    .card-header-custom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 17px 20px;
        background: #fbfcfe;
        border-bottom: 1px solid #edf1f6;
    }

    .card-header-custom h5 {
        margin: 0 0 3px;
        color: #263247;
        font-size: 15px;
        font-weight: 700;
    }

    .card-header-custom span {
        color: #8a95a7;
        font-size: 11px;
    }

    .card-body-custom {
        padding: 20px;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0;
    }

    .detail-item {
        min-height: 74px;
        padding: 13px 15px;
        border-bottom: 1px solid #edf1f5;
    }

    .detail-item:nth-last-child(-n+2) {
        border-bottom: 0;
    }

    .detail-item-wide {
        grid-column: span 1;
    }

    .detail-item-full {
        grid-column: 1 / -1;
    }

    .detail-label {
        display: block;
        margin-bottom: 6px;
        color: #8a95a7;
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .25px;
    }

    .detail-value {
        display: block;
        color: #334155;
        font-size: 12px;
        line-height: 1.5;
    }

    .detail-value strong,
    strong.detail-value {
        color: #263247;
        font-weight: 700;
    }

    .registration-number {
        color: #2563eb !important;
    }

    .jurusan-detail {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 7px;
    }

    .jurusan-code {
        padding: 3px 7px;
        border-radius: 5px;
        background: #eaf2ff;
        color: #2563eb;
        font-size: 10px;
        font-weight: 700;
    }

    .empty-text {
        color: #94a3b8;
        font-size: 11px;
    }

    .status-card {
        height: fit-content;
    }

    .status-message {
        display: flex;
        flex-direction: column;
        gap: 4px;
        padding: 14px;
        border-radius: 9px;
        border: 1px solid;
    }

    .status-message strong {
        font-size: 12px;
        font-weight: 700;
    }

    .status-message span {
        font-size: 11px;
        line-height: 1.5;
    }

    .status-message-success {
        background: #f0fdf4;
        border-color: #bbf7d0;
        color: #166534;
    }

    .status-message-danger {
        background: #fef2f2;
        border-color: #fecaca;
        color: #991b1b;
    }

    .status-message-warning {
        background: #fffbeb;
        border-color: #fde68a;
        color: #92400e;
    }

    .status-message-neutral {
        background: #f8fafc;
        border-color: #e2e8f0;
        color: #475569;
    }

    .revision-note {
        margin-top: 16px;
        padding: 14px;
        border-radius: 9px;
        background: #fffaf0;
        border: 1px solid #fde7b2;
    }

    .revision-note span {
        display: block;
        margin-bottom: 6px;
        color: #92400e;
        font-size: 11px;
        font-weight: 700;
    }

    .revision-note p {
        margin: 0;
        color: #78350f;
        font-size: 11px;
        line-height: 1.6;
    }

    .verification-form {
        margin-top: 16px;
    }

    .btn-verify {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #16a34a;
        border-radius: 8px;
        background: #16a34a;
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: .2s ease;
    }

    .btn-verify:hover {
        background: #15803d;
        border-color: #15803d;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 9px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-verified {
        background: #ecfdf3;
        color: #15803d;
    }

    .status-rejected {
        background: #fef2f2;
        color: #dc2626;
    }

    .status-waiting {
        background: #fffbeb;
        color: #b45309;
    }

    .status-unregistered {
        background: #f1f5f9;
        color: #64748b;
    }

    .documents-card {
        margin-bottom: 0;
    }

    .document-table {
        width: 100%;
        min-width: 1100px;
        border-collapse: separate;
        border-spacing: 0;
    }

    .document-table thead th {
        padding: 13px 15px;
        background: #f8fafc;
        border-bottom: 1px solid #e7ecf3;
        color: #64748b;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .25px;
        white-space: nowrap;
    }

    .document-table tbody td {
        padding: 14px 15px;
        border-bottom: 1px solid #edf1f5;
        color: #475569;
        font-size: 11px;
        vertical-align: middle;
    }

    .document-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .document-table tbody tr:hover {
        background: #fbfdff;
    }

    .document-name {
        color: #334155;
        font-size: 11px;
        font-weight: 600;
    }

    .document-link {
        display: inline-flex;
        align-items: center;
        padding: 6px 10px;
        border-radius: 6px;
        background: #eff6ff;
        border: 1px solid #dbeafe;
        color: #2563eb;
        font-size: 10px;
        font-weight: 600;
        text-decoration: none;
        transition: .2s ease;
    }

    .document-link:hover {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .note-text {
        display: block;
        max-width: 220px;
        color: #64748b;
        font-size: 11px;
        line-height: 1.5;
    }

    .document-form {
        display: grid;
        grid-template-columns: 145px 1fr auto;
        gap: 6px;
        align-items: center;
    }

    .verification-select,
    .verification-input {
        height: 34px;
        border: 1px solid #dfe5ed;
        border-radius: 6px;
        background: #fff;
        color: #475569;
        font-size: 10px;
        padding: 0 9px;
        box-shadow: none;
        outline: none;
    }

    .verification-select:focus,
    .verification-input:focus {
        border-color: #7aa2ef;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .08);
    }

    .verification-input::placeholder {
        color: #a0aabd;
    }

    .btn-save {
        height: 34px;
        padding: 0 12px;
        border: 1px solid #2563eb;
        border-radius: 6px;
        background: #2563eb;
        color: #fff;
        font-size: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: .2s ease;
    }

    .btn-save:hover {
        background: #1d4ed8;
        border-color: #1d4ed8;
    }

    @media (max-width: 992px) {
        .page-header {
            align-items: flex-start;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }

        .detail-item,
        .detail-item-wide,
        .detail-item-full {
            grid-column: 1 / -1;
        }

        .detail-item:nth-last-child(-n+2) {
            border-bottom: 1px solid #edf1f5;
        }

        .detail-item:last-child {
            border-bottom: 0;
        }
    }

    @media (max-width: 768px) {
        .spmb-detail-page {
            padding-top: 2px;
        }

        .page-header {
            flex-direction: column;
            align-items: stretch;
        }

        .header-actions {
            width: 100%;
        }

        .btn-edit,
        .btn-back {
            flex: 1;
        }

        .page-title h4 {
            font-size: 20px;
        }

        .card-header-custom,
        .card-body-custom {
            padding: 16px;
        }

        .detail-item {
            padding-left: 5px;
            padding-right: 5px;
        }
    }

    @media (max-width: 500px) {
        .header-actions {
            flex-direction: column;
        }

        .btn-edit,
        .btn-back {
            width: 100%;
        }
    }
</style>

@endpush