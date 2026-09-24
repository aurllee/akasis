<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Nilai Siswa</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <style>
        body {
            margin: 0;
            background: #f4f7fb;
            color: #1f2937;
            font-family: 'Poppins', Arial, sans-serif;
        }

        .container {
            margin-left: 250px;
            padding: 30px;
        }

        .card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(15, 23, 42, 0.05);
            padding: 22px;
        }

        .mb-3 {
            margin-bottom: 16px;
        }

        .mb-4 {
            margin-bottom: 24px;
        }

        .d-flex {
            display: flex;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .align-items-center {
            align-items: center;
        }

        .fw-bold {
            font-weight: 700;
        }

        .text-muted {
            color: #64748b;
        }

        .btn {
            display: inline-block;
            padding: 9px 14px;
            border: 0;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-primary {
            background: #2449a4;
            color: #ffffff;
        }

        .btn-secondary {
            background: #64748b;
            color: #ffffff;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #e2e8f0;
            padding: 10px 12px;
            text-align: left;
        }

        .table th {
            background: #eff6ff;
            color: #1e40af;
        }

        .form-control {
            box-sizing: border-box;
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
        }

        .form-control:focus {
            border-color: #3c73fe;
            box-shadow: 0 0 0 3px rgba(60, 115, 254, 0.15);
            outline: none;
        }

        @media (max-width: 768px) {
            .container {
                margin-left: 210px;
                padding: 15px;
            }

            .d-flex {
                align-items: flex-start;
                flex-direction: column;
                gap: 12px;
            }
        }
    </style>
</head>

<body>
    @include('layouts.sidebar-guru')

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-3">Edit Nilai Siswa</h3>
                <p class="text-muted mb-0">
                    {{ $jadwal->mapel->nama_mapel ?? '-' }} - {{ $jadwal->kelas->nama_kelas ?? '-' }}
                </p>
            </div>

            <a href="{{ route('guru.penilaian.detail', $jadwal->id) }}" class="btn btn-secondary">
                Kembali
            </a>
        </div>

        <div class="card">
            <div class="mb-3">
                <strong>Nama Siswa:</strong> {{ $siswa->nama ?? '-' }}
            </div>
            <div class="mb-3">
                <strong>NIS:</strong> {{ $siswa->nisn ?? '-' }}
            </div>

            <form action="{{ route('guru.penilaian.updateSiswa', ['jadwal' => $jadwal->id, 'siswa' => $siswa->id]) }}"
                method="POST">
                @csrf
                @method('PUT')

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Jenis Nilai</th>
                            <th>Tanggal</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($nilai as $item)
                            <tr>
                                <td>{{ ucfirst($item->jenis_nilai) }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_penilaian)->format('d-m-Y') }}</td>
                                <td>
                                    <input type="number" name="nilai[{{ $item->id }}]" class="form-control" min="0"
                                        max="100" step="0.01" value="{{ old('nilai.' . $item->id, $item->nilai) }}">
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">
                                    Belum ada data penilaian untuk siswa ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if($nilai->isNotEmpty())
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</body>

</html>