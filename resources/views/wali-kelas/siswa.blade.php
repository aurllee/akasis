@extends('layouts.app')

@section('title', 'Data Siswa')

@push('styles')
<style>
    .page-header {
        margin-bottom: 24px;
    }

    .page-header h1 {
        font-size: 24px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .page-header p {
        color: #64748b;
        font-size: 14px;
        margin: 0;
    }

    .card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        padding: 24px;
    }

    .table-wrapper {
        overflow-x: auto;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 14px;
    }

    table thead th {
        background-color: #f8fafc;
        color: #475569;
        font-weight: 600;
        padding: 12px 16px;
        border-bottom: 2px solid #e2e8f0;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.05em;
    }

    table tbody td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        vertical-align: middle;
    }

    table tbody tr:last-child td {
        border-bottom: none;
    }

    table tbody tr:hover {
        background-color: #f8fafc;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
    }

    .btn-primary {
        background-color: #2563eb;
        color: #ffffff;
    }

    .btn-primary:hover {
        background-color: #1d4ed8;
    }

    .btn-secondary {
        background-color: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
    }

    .btn-secondary:hover {
        background-color: #e2e8f0;
        color: #1e293b;
    }

    td .btn {
        margin-right: 6px;
    }
</style>
@endpush

@section('content')

<div class="page-header">
    <h1>Data Siswa</h1>

    <p>
        Kelas {{ $kelas->tingkat }} {{ $kelas->nama_kelas }}
    </p>
</div>

<div class="card">

    <div style="margin-bottom: 20px;">
        <a href="{{ route('wali-kelas.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NISN</th>
                    <th>Nama Siswa</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($siswa as $item)

                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            {{ $item->siswa->nisn ?? '-' }}
                        </td>

                        <td>
                            {{ optional($item->siswa)->nama ?? '-' }}
                        </td>

                        <td>
                            @if($item->siswa)

                                <a
                                    href="{{ route('wali-kelas.nilai', $item->siswa->id) }}"
                                    class="btn btn-primary"
                                >
                                    Nilai
                                </a>

                            @endif
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="4">
                            Belum ada siswa di kelas ini.
                        </td>
                    </tr>

                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection