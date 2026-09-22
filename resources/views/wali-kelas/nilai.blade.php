@extends('layouts.app')

@section('title', 'Rekap Nilai')

@push('styles')
    <style>
        .rekap-container {
            max-width: 900px;
            margin: 0 auto;
            background: #ffffff;
            padding: 28px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        }

        .rekap-title {
            font-size: 24px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .siswa-info {
            font-size: 16px;
            font-weight: 500;
            color: #334155;
            margin-bottom: 20px;
        }

        .empty-alert {
            padding: 16px;
            color: #64748b;
            font-size: 14px;
            margin-bottom: 24px;
            text-align: center;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
        }

        .table-rekap {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        .table-rekap th, .table-rekap td {
            padding: 12px;
            border: 1px solid #e2e8f0;
            text-align: left;
        }

        .table-rekap th {
            background-color: #f8fafc;
            color: #475569;
        }
    </style>
@endpush

@section('content')
    <div class="rekap-container">
        <h1 class="rekap-title">Rekap Nilai</h1>
        <p class="siswa-info">Siswa: <strong>{{ $siswa->nama }}</strong></p>

        @if($nilaiList->isNotEmpty())
            <table class="table-rekap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama guru</th>
                        <th>Mata Pelajaran</th>
                        <th>Jenis Nilai</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($nilaiList as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->jadwalPelajaran?->guru?->nama ?? '-' }}</td>
                            <td>{{ $item->jadwalPelajaran?->mataPelajaran?->nama_mapel ?? '-' }}</td>
                            <td>{{ ucfirst($item->jenis_nilai) }}</td>
                            <td>{{ $item->nilai }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-alert">
                Data nilai belum tersedia untuk siswa ini.
            </div>
        @endif

        <a class="btn btn-secondary" href="{{ url()->previous() }}">Kembali</a>
    </div>
@endsection