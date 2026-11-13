@extends('layouts.app')

@section('title', 'Dashboard Tatib')

@push('styles')
    <style>
        body {
            background: #f4f7fb;
            color: #1f2937;
            font-family: 'Poppins', sans-serif;
        }

        .tatib-dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .tatib-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(30, 64, 102, 0.05);
            padding: 22px;
        }

        .tatib-card h3 {
            color: #475569;
            font-size: 14px;
            margin-bottom: 12px;
        }

        .tatib-card .value {
            color: #111827;
            font-size: 32px;
            font-weight: 700;
            margin: 0;
        }

        .tatib-card .badge {
            display: inline-block;
            font-size: 12px;
            border-radius: 999px;
            padding: 6px 10px;
        }
    </style>
@endpush

@section('content')
    <div class="tatib-dashboard">
        <div class="tatib-card">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h3>Jumlah Pelanggaran</h3>
                <span class="badge bg-danger-subtle text-danger">Hari ini</span>
            </div>
            <p class="value">0</p>
        </div>

        <div class="tatib-card">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h3>Siswa Terpantau</h3>
                <span class="badge bg-primary-subtle text-primary">Aktif</span>
            </div>
            <p class="value">0</p>
        </div>

        <div class="tatib-card">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h3>Persetujuan</h3>
                <span class="badge bg-warning-subtle text-warning">Menunggu</span>
            </div>
            <p class="value">0</p>
        </div>
    </div>
@endsection