@extends('layouts.app')

@section('title', 'Absensi Siswa')

@push('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #1f2937;
        }

        .card {
            border: 1px solid #e5e7eb !important;
            border-radius: 14px;
        }

        .form-control {
            border-color: #cbd5e1;
            border-radius: 8px;
        }

        .form-control:focus {
            border-color: #3c73fe;
            box-shadow: 0 0 0 3px rgba(60, 115, 254, 0.15);
        }

        h1 {
            font-weight: 500;
            font-size: 25px;
        }
    </style>
@endpush

@section('content')

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4 p-md-5">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div>
                    <h1 class="mb-3">Absensi Siswa</h1>
                    <p class="text-muted mb-0">Masukkan kode absensi yang diberikan oleh guru.</p>
                </div>
            </div>

            <form action="{{ route('siswa.absensi.submit') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="token" class="form-label fw-medium">Kode Absensi</label>
                    <input type="text" name="token" id="token" class="form-control @error('token') is-invalid @enderror"
                        placeholder="Masukkan kode absensi" autocomplete="off" required>
                    @error('token')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    Kirim Absensi
                </button>
            </form>
        </div>
    </div>
@endsection