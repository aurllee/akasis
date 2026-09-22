@extends('layouts.app')

@section('title', 'Pembagian Kelas')

@push('styles')
    <style>
        .pembagian-page {
            color: #1f2937;
            font-family: 'Poppins', sans-serif;
        }

        .pembagian-card {
            background: #fff;
            border: 1px solid #e4eaf2;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(30, 64, 102, .05);
            padding: 24px;
        }

        .header {
            margin-bottom: 24px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }

        .header p {
            color: #64748b;
            font-size: 14px;
            margin: 0;
        }

        /* Flash Message Status */
        .success {
            background-color: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .error {
            background-color: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .import-error {
            background-color: #fff7ed;
            color: #c2410c;
            border: 1px solid #ffedd5;
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .import-error ul {
            margin: 8px 0 0 20px;
            padding: 0;
        }

        /* Card Import Box */
        .import-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            margin-bottom: 24px;
            padding: 18px 20px;
        }

        .import-box h3 {
            margin: 0 0 4px;
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
        }

        .import-box p {
            color: #64748b;
            font-size: 13px;
            margin: 0 0 16px;
        }

        .import-form {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .import-form input[type="file"] {
            padding: 7px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background-color: #ffffff;
            font-size: 13px;
            color: #475569;
            outline: none;
        }

        .import-form input[type="file"]::file-selector-button {
            padding: 6px 12px;
            border-radius: 4px;
            border: 1px solid #cbd5e1;
            background-color: #f1f5f9;
            color: #334155;
            cursor: pointer;
            margin-right: 10px;
            transition: all 0.2s;
        }

        .import-form input[type="file"]::file-selector-button:hover {
            background-color: #e2e8f0;
        }

        /* Button Styling */
        .btn-import {
            background: #2449a4;
            color: #ffffff;
            border: none;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-import:hover {
            background: #2449a4;
        }

        .btn-manual {
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            color: #475569;
            text-decoration: none;
            padding: 9px 14px;
            font-size: 13px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            transition: background-color 0.2s;
        }

        .btn-manual:hover {
            background: #e2e8f0;
            color: #334155;
        }

        /* Table Styling */
        .pembagian-table-wrapper {
            overflow-x: auto;
        }

        .pembagian-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 14px;
            background: #ffffff;
        }

        .pembagian-table th {
            background: #f1f5fb;
            color: #475569;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
        }

        .pembagian-table td {
            border-bottom: 1px solid #e5e7eb;
            padding: 12px;
            color: #374151;
            vertical-align: middle;
        }

        .pembagian-table tbody tr:last-child td {
            border-bottom: none;
        }

        .pembagian-table tbody tr:hover {
            background: #f8fbff;
        }

        .action-buttons {
            align-items: center;
            display: flex;
            gap: 8px;
            white-space: nowrap;
        }

        .btn-edit {
            background: #eff6ff;
            border: 1px solid #93c5fd;
            border-radius: 6px;
            color: #1d4ed8;
            display: inline-flex;
            font-size: 12px;
            font-weight: 600;
            padding: 7px 10px;
            text-decoration: none;
            transition: background-color 0.2s, color 0.2s;
        }

        .btn-edit:hover {
            background: #dbeafe;
            color: #1e40af;
            text-decoration: none;
        }

        .btn-hapus {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            border-radius: 6px;
            color: #b91c1c;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            padding: 7px 10px;
            transition: background-color 0.2s, color 0.2s;
        }

        .btn-hapus:hover {
            background: #fee2e2;
            color: #991b1b;
            text-decoration: none;
        }

        /* Pagination Styling */
        .pagination {
            margin-top: 24px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
        }

        .pagination a,
        .pagination span {
            padding: 8px 14px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            text-decoration: none;
            color: #475569;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .pagination a:hover {
            background-color: #f1f5f9;
            color: #1e293b;
        }

        .pagination .active {
            background-color: #2563eb;
            color: #ffffff;
            border-color: #2563eb;
        }

        .pagination .disabled {
            color: #cbd5e1;
            background-color: #f8fafc;
            cursor: not-allowed;
        }

        /* Responsive Layout */
        @media (max-width: 768px) {
            .pembagian-card {
                padding: 18px;
            }

            .import-form {
                flex-direction: column;
                align-items: stretch;
            }

            .import-form input[type="file"],
            .btn-import,
            .btn-manual {
                width: 100%;
                box-sizing: border-box;
                justify-content: center;
                text-align: center;
            }
        }
    </style>
@endpush

@section('content')

    <div class="pembagian-page">
        <div class="pembagian-card">

            <div class="header">
                <h1>Pembagian Kelas</h1>
                <p>Daftar siswa berdasarkan kelas yang telah ditentukan.</p>
            </div>

            @if (session('gagal_import'))
                <div class="import-error">

                    <strong>Data yang tidak berhasil diimport:</strong>

                    <ul>
                        @foreach (session('gagal_import') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>
            @endif



            <div class="import-box">

                <h3>Import Pembagian Kelas</h3>

                <p>
                    Upload file Excel dengan format:
                    <strong>NISN</strong> dan <strong>Kelas</strong>.
                </p>

                <form action="{{ route('pembagian_kelas.import') }}" method="POST" enctype="multipart/form-data"
                    class="import-form">

                    @csrf

                    <input type="file" name="file" accept=".xlsx,.xls,.csv" required>

                    <button type="submit" class="btn-import">
                        Import Excel
                    </button>

                    <a href="{{ route('pembagian_kelas.create') }}" class="btn-manual">
                        + Pembagian Manual
                    </a>

                </form>

            </div>



            <div class="pembagian-table-wrapper">
                <table class="pembagian-table">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NISN</th>
                            <th>Nama Siswa</th>
                            <th>Tingkat</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($pembagian as $index => $item)

                            <tr>

                                <td>
                                    {{ $pembagian->firstItem() + $index }}
                                </td>

                                <td>
                                    {{ $item->siswa?->nisn ?? '-' }}
                                </td>

                                <td>
                                    {{ $item->siswa?->nama ?? 'Data siswa tidak tersedia' }}
                                </td>

                                <td>
                                    {{ $item->kelas->tingkat }}
                                </td>

                                <td>
                                    {{ $item->kelas->nama_kelas }}
                                </td>

                                <td>
                                    {{ $item->kelas->jurusan?->nama_jurusan ?? 'Jurusan belum dipilih' }}
                                </td>


                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('pembagian_kelas.edit', $item->id) }}" class="btn-edit">
                                            Edit
                                        </a>

                                        <form action="{{ route('pembagian_kelas.destroy', $item->id) }}" method="POST"
                                            style="margin: 0;"
                                            onsubmit="return confirm('Yakin ingin mengeluarkan siswa dari kelas ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-hapus">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" style="text-align: center;">
                                    Belum ada pembagian kelas.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>



            @if ($pembagian->hasPages())

                <div class="pagination">

                    @if ($pembagian->onFirstPage())

                        <span class="disabled">
                            ← Previous
                        </span>

                    @else

                        <a href="{{ $pembagian->previousPageUrl() }}">
                            ← Previous
                        </a>

                    @endif


                    @for ($i = 1; $i <= $pembagian->lastPage(); $i++)

                        <a href="{{ $pembagian->url($i) }}" class="{{ $pembagian->currentPage() == $i ? 'active' : '' }}">
                            {{ $i }}
                        </a>

                    @endfor


                    @if ($pembagian->hasMorePages())

                        <a href="{{ $pembagian->nextPageUrl() }}">
                            Next →
                        </a>

                    @else

                        <span class="disabled">
                            Next →
                        </span>

                    @endif

                </div>

            @endif

        </div>
    </div>
@endsection