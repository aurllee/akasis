@extends('layouts.app')

@section('title', 'Tambah Pembagian Kelas')

@section('content')
@push('styles')
<style>
    .academic-create {
        width: 100%;
        color: #1f2937;
    }

    .academic-create__panel {
        width: 100%;
        padding: 24px;
        background: #fff;
        border: 1px solid #e4eaf2;
        border-radius: 10px;
        box-shadow: 0 6px 18px rgba(30, 64, 102, .05);
        box-sizing: border-box;
    }

    .academic-create h1 {
        margin: 0 0 6px;
        color: #1e293b;
        font-size: 24px;
        font-weight: 600;
    }

    .academic-create__description {
        margin: 0 0 22px;
        color: #64748b;
    }

    .academic-create__field {
        margin-bottom: 18px;
    }

    .academic-create__field label {
        display: block;
        margin-bottom: 7px;
        color: #334155;
        font-size: 13px;
        font-weight: 600;
    }

    .academic-create__field select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 7px;
        background: #fff;
        color: #1e293b;
        font: inherit;
        box-sizing: border-box;
    }

    .academic-create__field select:focus {
        border-color: #2449a4;
        box-shadow: 0 0 0 3px rgba(36, 73, 164, .12);
        outline: none;
    }

    .academic-create__error {
        margin: 0 0 18px;
        padding: 12px 16px;
        border: 1px solid #fecaca;
        border-radius: 8px;
        background: #fef2f2;
        color: #b91c1c;
    }

    .academic-create__error ul {
        margin: 0;
        padding-left: 18px;
    }

    .academic-create__actions {
        display: flex;
        gap: 10px;
        margin-top: 22px;
        padding-top: 22px;
        border-top: 1px solid #eef2f7;
    }

    .academic-create__actions button,
    .academic-create__actions a {
        display: inline-flex;
        align-items: center;
        padding: 10px 15px;
        border: 1px solid transparent;
        border-radius: 7px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: background-color .2s ease, border-color .2s ease, color .2s ease;
    }

    .academic-create__save {
        background: #2449a4;
        color: #fff;
    }

    .academic-create__save:hover {
        background: #1d3f8c;
    }

    .academic-create__back {
        border-color: #94a3b8 !important;
        background: #fff;
        color: #2449a4;
    }

    .academic-create__back:hover {
        border-color: #2449a4 !important;
        background: #eff6ff;
        color: #1d3f8c;
    }

    @media (max-width: 600px) {
        .academic-create__panel {
            padding: 20px;
        }

        .academic-create__actions {
            flex-direction: column;
        }

        .academic-create__actions button,
        .academic-create__actions a {
            justify-content: center;
        }
    }
</style>
@endpush

<main class="academic-create">
    <div class="academic-create__panel">
        <h1>Tambah Pembagian Kelas</h1>
        <p class="academic-create__description">Pilih siswa dan kelas untuk membuat pembagian kelas baru.</p>

        @if (session('error'))
            <div class="academic-create__error" role="alert">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="academic-create__error" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pembagian_kelas.store') }}" method="POST">
            @csrf

            <div class="academic-create__field">
                <label for="siswa_id">Siswa</label>
                <select name="siswa_id" id="siswa_id" required>
                    <option value="">-- Pilih Siswa --</option>
                    @foreach ($siswa as $item)
                        <option value="{{ $item->id }}" data-jurusan-id="{{ $item->jurusan_id }}"
                            {{ old('siswa_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->nisn }} - {{ $item->nama_lengkap }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="academic-create__field">
                <label for="kelas_id">Kelas</label>
                <select name="kelas_id" id="kelas_id" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach ($kelas as $item)
                        <option value="{{ $item->id }}" data-jurusan-id="{{ $item->jurusan_id }}"
                            {{ old('kelas_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->tingkat }} {{ $item->nama_kelas }}
                            - {{ $item->jurusan?->nama_jurusan ?? 'Jurusan belum dipilih' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="academic-create__actions">
                <button type="submit" class="academic-create__save">Simpan</button>
                <a href="{{ route('pembagian_kelas.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</main>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
    const siswaSelect = document.getElementById('siswa_id');
    const kelasSelect = document.getElementById('kelas_id');

    const semuaKelas = Array.from(
        kelasSelect.querySelectorAll('option[data-jurusan-id]')
    );

    siswaSelect.addEventListener('change', function () {
        const selectedSiswa = this.options[this.selectedIndex];

        const jurusanId = selectedSiswa
            ? selectedSiswa.dataset.jurusanId
            : '';

        kelasSelect.innerHTML = '';

        if (!jurusanId) {
            kelasSelect.disabled = true;

            const option = document.createElement('option');
            option.value = '';
            option.textContent = '-- Pilih Siswa Terlebih Dahulu --';

            kelasSelect.appendChild(option);
            return;
        }

        kelasSelect.disabled = false;

        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = '-- Pilih Kelas --';

        kelasSelect.appendChild(defaultOption);

        semuaKelas.forEach(function (kelas) {
            if (kelas.dataset.jurusanId === jurusanId) {
                kelasSelect.appendChild(kelas.cloneNode(true));
            }
        });
    });
    if (siswaSelect.value) {
        siswaSelect.dispatchEvent(new Event('change'));
    }
});
</script>