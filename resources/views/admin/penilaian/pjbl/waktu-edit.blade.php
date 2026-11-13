@extends('layouts.app')

@section('title', 'Atur Batas Waktu Penilaian')

@push('styles')
    <style>
        .pjbl-time-page {
            max-width: 880px;
            margin: 0 auto;
        }

        .pjbl-time-page > .card {
            border: 1px solid #e2e8f0 !important;
            border-radius: 12px;
        }

        .pjbl-time-page h3 {
            color: #0f172a;
            font-size: 24px;
        }

        .pjbl-time-page .form-label {
            color: #334155;
            font-size: 13px;
            font-weight: 600;
        }

        .pjbl-time-page .form-control {
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            color: #1e293b;
            min-height: 42px;
        }

        .pjbl-time-page .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        .pjbl-time-page .btn {
            border-radius: 7px;
            font-weight: 500;
        }

        @media (max-width: 576px) {
            .pjbl-time-page .card-body {
                padding: 20px !important;
            }

            .pjbl-time-page form > .d-flex {
                flex-direction: column-reverse;
            }

            .pjbl-time-page form > .d-flex .btn {
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid py-4 pjbl-time-page">
        <div class="mb-4">
            <h3 class="fw-bold">Atur Batas Waktu Penilaian</h3>
            <p class="text-muted mb-0">Tentukan kapan semua guru dapat memasukkan nilai PJBL.</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.penilaian.pjbl.waktu.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    @include('admin.penilaian.pjbl.waktu-create')

                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.penilaian.pjbl.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Simpan Waktu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection