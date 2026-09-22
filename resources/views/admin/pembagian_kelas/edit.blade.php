<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Pembagian Kelas</title>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f6fa;
            margin: 0;
            padding: 30px;
        }

        .container {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            max-width: 600px;
            margin: auto;
        }

        h1 {
            margin-top: 0;
            margin-bottom: 25px;
        }

        .info {
            background-color: #f8fafc;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .info p {
            margin: 7px 0;
        }

        .form-group {
            margin-bottom: 18px;
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
            box-sizing: border-box;
        }

        .btn {
            padding: 10px 15px;
            border-radius: 6px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .btn-simpan {
            background-color: #2449a4;
            color: white;
        }

        .btn-kembali {
            background-color: #64748b;
            color: white;
            margin-left: 5px;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <div class="container">

        <h1>Edit Pembagian Kelas</h1>

        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="info">

            <p>
                <strong>NIS:</strong>
                {{ $pembagian->siswa?->nisn ?? '-' }}
            </p>

            <p>
                <strong>Nama:</strong>
                {{ $pembagian->siswa?->nama ?? 'Data siswa tidak tersedia' }}
            </p>

        </div>


        <form action="{{ route('pembagian_kelas.update', $pembagian->id) }}" method="POST">

            @csrf
            @method('PUT')


            <div class="form-group">

                <label for="kelas_id">
                    Kelas
                </label>

                <select name="kelas_id" id="kelas_id" required>

                    <option value="">
                        -- Pilih Kelas --
                    </option>

                    @foreach ($kelas as $k)

                        <option value="{{ $k->id }}" {{ $pembagian->kelas_id == $k->id ? 'selected' : '' }}>

                            {{ $k->tingkat }} {{ $k->nama_kelas }}
                            - {{ $k->jurusan?->nama_jurusan ?? 'Jurusan belum dipilih' }}

                        </option>

                    @endforeach

                </select>

            </div>


            <button type="submit" class="btn btn-simpan">
                Simpan Perubahan
            </button>

            <a href="{{ route('pembagian_kelas.index') }}" class="btn btn-kembali">
                Kembali
            </a>

        </form>

    </div>

</body>

</html>