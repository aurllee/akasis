<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pembagian Kelas</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    <style>
        body {
            margin: 0;
            padding: 30px;
            margin-left: 250px;
            background: #f5f6fa;
            color: #212529;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 650px;
            margin: auto;
            padding: 25px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
        }

        h1 {
            margin: 0 0 8px;
        }

        .description {
            margin: 0 0 25px;
            color: #64748b;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background: white;
            box-sizing: border-box;
        }

        .error {
            margin-bottom: 20px;
            padding: 12px 15px;
            border-radius: 6px;
            background: #fef2f2;
            color: #b91c1c;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            border: 0;
            border-radius: 6px;
            color: white;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
        }

        .btn-simpan {
            background: #2449a4;
        }

        .btn-kembali {
            background: #64748b;
        }

        @media (max-width: 768px) {
            body {
                margin-left: 210px;
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    @include('layouts.sidebar')

    <main class="container">
        <h1>Tambah Pembagian Kelas</h1>
        <p class="description">Pilih siswa dan kelas untuk membuat pembagian kelas baru.</p>

        @if (session('error'))
            <div class="error" role="alert">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pembagian_kelas.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="siswa_id">Siswa</label>
                <select name="siswa_id" id="siswa_id" required>
                    <option value="">-- Pilih Siswa --</option>
                    @foreach ($siswa as $item)
                        <option value="{{ $item->id }}" {{ old('siswa_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->nisn }} - {{ $item->nama_lengkap }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="kelas_id">Kelas</label>
                <select name="kelas_id" id="kelas_id" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach ($kelas as $item)
                        <option value="{{ $item->id }}" {{ old('kelas_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->tingkat }} {{ $item->nama_kelas }}
                            - {{ $item->jurusan?->nama_jurusan ?? 'Jurusan belum dipilih' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-simpan">Simpan</button>
                <a href="{{ route('pembagian_kelas.index') }}" class="btn btn-kembali">Kembali</a>
            </div>
        </form>
    </main>
</body>

</html>