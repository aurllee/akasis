@extends('layouts.app')

@section('title', 'Ganti Password')

@push('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f7fb;
            color: #1f2937;
        }

        .password-page {
            max-width: 760px;
            margin: 0 auto;
        }

        .password-header {
            margin-bottom: 22px;
        }

        .password-header h1 {
            margin: 0 0 8px;
            color: #1e293b;
            font-size: 25px;
            font-weight: 600;
        }

        .password-header p {
            margin: 0;
            color: #64748b;
        }

        .password-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            box-shadow: 0 8px 24px rgba(30, 64, 102, 0.08) !important;
        }

        .password-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        h1 {
            font-weight: 500;
            font-size: 25px;
        }

        @media (max-width: 576px) {
            .password-actions {
                flex-direction: column-reverse;
            }

            .password-actions .btn {
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')
    <div class="password-page">
        <div class="password-header">
            <h1>Ganti Password</h1>
            <p>Perbarui password akunmu secara berkala agar tetap aman.</p>
        </div>

        <div class="card password-card">
            <div class="card-body p-4 p-md-5">
                @php
                    $roleId = auth()->user()?->role_id;
                    $backRoute = route('siswa.dashboard');

                    if ($roleId == 1) {
                        $backRoute = route('admin.dashboard');
                    } elseif ($roleId == 2) {
                        $backRoute = route('guru.dashboard');
                    } elseif ($roleId == 3) {
                        $backRoute = route('wali-kelas.dashboard');
                    }
                @endphp

                <form action="{{ route('password.update') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Lama</label>
                        <input type="password" id="current_password" name="current_password"
                            class="form-control @error('current_password') is-invalid @enderror"
                            autocomplete="current-password" required>
                        @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" id="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" autocomplete="new-password"
                            minlength="8" required>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">Gunakan minimal 8 karakter.</div>
                    </div>

                    <div class="mb-0">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                            autocomplete="new-password" minlength="8" required>
                    </div>

                    <div class="password-actions mt-4">
                        <a href="{{ $backRoute }}" class="btn btn-secondary border">Kembali</a>
                        <button type="submit" class="btn btn-primary"> Simpan Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection