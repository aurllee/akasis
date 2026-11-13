@extends('layouts.app')

@section('title', 'Penilaian PjBL')

@push('styles')
    <style>
        .page-wrap {
            width: 100%;
        }

        .page-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(15, 23, 42, 0.04);
            padding: 24px;
        }

        .page-title {
            margin: 0 0 8px;
            font-size: 25px;
            font-weight: 500;
            font-size: 25px;
        }

        .page-subtitle {
            margin: 0 0 22px;
            color: #64748b;
        }

        .info-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 18px 20px;
            margin-bottom: 18px;
        }

        .info-card p {
            margin: 8px 0;
            color: #475569;
        }

        .student-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 18px 20px;
            margin-bottom: 14px;
        }

        .student-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .student-meta {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .student-meta strong {
            font-size: 16px;
        }

        .nilai-input {
            width: 100px;
            padding: 9px 10px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
        }

        .btn-primary {
            display: inline-block;
            padding: 10px 16px;
            background: #2449a4;
            color: #ffffff;
            border-radius: 8px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .btn-secondary {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            border: 1px solid #cbd5e1;
            color: #475569;
            background: #ffffff;
            margin-left: 8px;
        }

        @media (max-width: 768px) {
            .student-row {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        .fs-12 {
            font-size: 13px;
        }
    </style>
@endpush

@section('content')
    <div class="page-wrap">
        <div class="page-card">
            <h1 class="page-title">Penilaian PjBL</h1>
            <p class="page-subtitle">Data penilaian proyek siswa</p>

            <div class="info-card">
                <p><strong>PjBL:</strong> {{ ucwords(str_replace('_', ' ', $pjbl->periode)) }}</p>
                <p><strong>Guru Penguji:</strong> {{ $guru->nama }}</p>
                <p><strong>Jenis Penguji:</strong>
                    {{ $penguji?->jenis_peguji ? ucwords(str_replace('_', ' ', $penguji->jenis_peguji)) : '-' }}
                </p>
            </div>

            <form action="{{ route('guru.penilaian-pjbl.simpan', $pjbl->id) }}" method="POST">
                @csrf

                @forelse ($siswaKelas as $siswaKelasItem)
                    <div class="student-card">
                        <div class="student-row">
                            <div class="student-meta">
                                <strong>{{ $siswaKelasItem->siswa->nama }}</strong>
                                <small>NIS: {{ $siswaKelasItem->siswa->nis }}</small>
                            </div>

                            <div>
                                <label for="nilai_{{ $siswaKelasItem->siswa_id }}">Nilai</label>
                                <input id="nilai_{{ $siswaKelasItem->siswa_id }}" class="nilai-input" type="number"
                                    name="nilai[{{ $siswaKelasItem->siswa_id }}]" min="0" max="100"
                                    value="{{ old('nilai.' . $siswaKelasItem->siswa_id, $nilaiSiswa->get($siswaKelasItem->siswa_id)) }}"
                                    required>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="student-card">Belum ada siswa di kelas ini.</div>
                @endforelse

                <div class="mt-3">
                    <button type="submit" class="btn-primary fs-12">Simpan Penilaian</button>
                    <a href="{{ route('guru.penilaian-pjbl.index') }}" class="btn-secondary fs-12">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection