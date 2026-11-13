@extends('layouts.app')

@section('title', 'Edit Semua Jadwal')

@push('styles')
    <style>
    body {
        font-family: 'Poppins', sans-serif;
        color: #212529;
        background: #f5f6fa;
    }

        .academic-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            margin-bottom: 24px;
        }

        .academic-header {
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f1f5f9;
        }

        .academic-header h1 {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 4px 0;
        }

        .academic-info {
            font-size: 14px;
            color: #64748b;
            margin: 0;
        }

        .academic-info strong {
            color: #1e293b;
            font-weight: 600;
        }

        .academic-section-title {
            font-size: 15px;
            font-weight: 600;
            color: #1e293b;
            margin: 20px 0 12px 0;
            padding-bottom: 6px;
            border-bottom: 1px solid #e2e8f0;
        }

        .mapel-row {
            display: grid;
            grid-template-columns: 2fr 2fr 1.5fr 1fr auto;
            gap: 10px;
            align-items: center;
            background: #f8fafc;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            margin-bottom: 10px;
        }

        .mapel-row select {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background-color: #ffffff;
            font-size: 14px;
            color: #1e293b;
            outline: none;
            transition: all 0.2s;
        }

        .mapel-row select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .btn-hapus-row {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-hapus-row:hover {
            background: #fee2e2;
        }

        .academic-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 24px;
            padding-top: 16px;
            border-top: 1px solid #f1f5f9;
        }

        .btn-submit {
            background: #2563eb;
            color: #ffffff;
            border: none;
            padding: 9px 18px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-submit:hover {
            background: #1d4ed8;
        }

        @media (max-width: 768px) {
            .mapel-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
<div class="academic-container">
    <div class="academic-card">
        <div class="academic-header">
            <h1>Edit Semua Jadwal</h1>
            <p class="academic-info">
                <strong>{{ $kelasTerpilih->nama_kelas }}</strong> · 
                Tingkat {{ $kelasTerpilih->tingkat }} · 
                {{ optional($kelasTerpilih->jurusan)->kode_jurusan ?? optional($kelasTerpilih->jurusan)->nama_jurusan }} · 
                <strong>{{ $hariTerpilih }}</strong>
            </p>
        </div>

        <form action="{{ route('admin.jadwal_pelajaran.update_hari', [$kelasTerpilih->id, $hariTerpilih]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="academic-section-title">Daftar Mata Pelajaran</div>

            @foreach ($jadwal as $item)
                <div class="mapel-row">
                    <input type="hidden" name="jadwal_id[]" value="{{ $item->id }}">
                    
                    <select name="mapel_id[]" required>
                        @foreach ($mapel as $option)
                            <option value="{{ $option->id }}" {{ (string) $item->mata_pelajaran_id === (string) $option->id ? 'selected' : '' }}>
                                {{ $option->kode_mapel }} - {{ $option->nama_mapel }}
                            </option>
                        @endforeach
                    </select>

                    <select name="guru_id[]" required>
                        @foreach ($guru as $option)
                            <option value="{{ $option->id }}" {{ (string) $item->guru_id === (string) $option->id ? 'selected' : '' }}>
                                {{ $option->kode_guru ?? $option->nip }} - {{ $option->nama }}
                            </option>
                        @endforeach
                    </select>

                    <select name="ruang_id[]" required>
                        @foreach ($ruangan as $option)
                            <option value="{{ $option->id }}" {{ (string) $item->ruangan_id === (string) $option->id ? 'selected' : '' }}>
                                {{ $option->kode_ruang }} - {{ $option->nama_ruang }}
                            </option>
                        @endforeach
                    </select>

                    <select name="jumlah_jp[]" required>
                        @for ($jp = 1; $jp <= ($jumlahJpPerHari[$hariTerpilih] ?? 10); $jp++)
                            <option value="{{ $jp }}" {{ (int) ($item->jumlah_jp ?? 1) === $jp ? 'selected' : '' }}>
                                {{ $jp }} JP
                            </option>
                        @endfor
                    </select>

                    <button type="button" class="btn-hapus-row"
                        data-action="{{ route('admin.jadwal_pelajaran.destroy', $item->id) }}"
                        onclick="hapusJadwal(this)">
                        Hapus
                    </button>
                </div>
            @endforeach

            <div class="academic-actions">
                <button type="submit" class="btn-submit">Simpan Semua</button>
                <a href="{{ route('admin.jadwal_pelajaran.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function hapusJadwal(button) {
        if (!confirm('Yakin ingin menghapus jadwal ini?')) {
            return;
        }

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = button.dataset.action;
        form.innerHTML = '<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="DELETE">';
        document.body.appendChild(form);
        form.submit();
    }
</script>
@endpush