```blade
@extends('layouts.app')

@section('content')

<style>
    :root {
        --brand: #2449a4;
        --brand-dark: #1a3679;
        --brand-soft: #eaf0fb;
    }

    .card-absen {
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(36, 73, 164, .10);
        border-top: 4px solid var(--brand);
        overflow: hidden;
    }

    .card-header-absen {
        background: linear-gradient(
            135deg,
            var(--brand) 0%,
            var(--brand-dark) 100%
        );
        color: #fff;
        padding: 1.25rem 1.5rem;
    }

    .card-header-absen small {
        color: #d6e0f7;
    }

    .btn-brand {
        background-color: var(--brand);
        border-color: var(--brand);
        color: #fff;
    }

    .btn-brand:hover {
        background-color: var(--brand-dark);
        border-color: var(--brand-dark);
        color: #fff;
    }

    .form-control:focus {
        border-color: var(--brand);
        box-shadow: 0 0 0 .2rem rgba(36, 73, 164, .15);
    }

    thead.table-header {
        background-color: var(--brand);
        color: #fff;
    }

    table td,
    table th {
        vertical-align: middle;
    }

    tbody tr:hover {
        background-color: var(--brand-soft);
    }

    .badge-hadir {
        background-color: #198754;
    }

    .badge-sakit {
        background-color: #fd7e14;
    }

    .badge-izin {
        background-color: var(--brand);
    }

    .badge-alpa {
        background-color: #dc3545;
    }
</style>

<div class="container-fluid py-4">

    <div class="card card-absen">

        <div class="card-header-absen">
            <h4 class="mb-0">Data Absen Siswa</h4>

            <small>
                Wali Kelas: {{ $kelas ?? 'Kelas belum diatur' }}
            </small>
        </div>

        <div class="card-body p-4">

            {{-- Filter tanggal --}}
            <form method="GET" class="row g-2 mb-3">

                <div class="col-auto">
                    <input
                        type="date"
                        name="tanggal"
                        value="{{ $tanggal ?? now()->format('Y-m-d') }}"
                        class="form-control"
                    >
                </div>

                <div class="col-auto">
                    <button type="submit" class="btn btn-brand">
                        Tampilkan
                    </button>
                </div>

            </form>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-header">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Hari / Tanggal</th>
                            <th>Dokumen</th>
                            <th>Keterangan</th>
                            <th>Alasan</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($absensi as $i => $absen)

                            @php
                                $nama = $absen->nama ?? $absen['nama'] ?? '-';
                                $tanggalAbsen = $absen->tanggal ?? $absen['tanggal'] ?? null;
                                $keterangan = $absen->keterangan ?? $absen['keterangan'] ?? '-';
                                $alasan = $absen->alasan ?? $absen['alasan'] ?? '-';

                                $ket = strtolower($keterangan);

                                $badgeClass = match($ket) {
                                    'hadir' => 'badge-hadir',
                                    'sakit' => 'badge-sakit',
                                    'izin'  => 'badge-izin',
                                    'alpa', 'alfa' => 'badge-alpa',
                                    default => 'bg-secondary',
                                };
                            @endphp

                            <tr>

                                <td>{{ $i + 1 }}</td>

                                <td>{{ $nama }}</td>

                                <td>
                                    @if($tanggalAbsen)
                                        {{ \Carbon\Carbon::parse($tanggalAbsen)
                                            ->locale('id')
                                            ->translatedFormat('l, d/m/Y') }}
                                    @else
                                        -
                                    @endif
                                </td>

<td>
                                        @if ($absen->dokumen)
                                            <a href="{{ asset('storage/' . $absen->dokumen) }}" target="_blank"
                                                class="btn btn-sm btn-outline-secondary">
                                                <i class="bi bi-file-earmark me-1"></i>Lihat
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                <td>
                                    <span class="badge {{ $badgeClass }}">
                                        {{ ucfirst($keterangan) }}
                                    </span>
                                </td>

                                <td>
                                    {{ $alasan }}
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="text-center text-muted py-3">
                                    Belum ada data absen untuk tanggal ini.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>
    </div>

</div>

@endsection
```
