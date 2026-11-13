@extends('layouts.app')

@section('title', 'Tambah Jadwal')

@push('styles')
    <style>
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

        .academic-header p {
            font-size: 13px;
            color: #64748b;
            margin: 0;
        }

        .academic-grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .academic-field {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 16px;
        }

        .academic-field label {
            font-size: 13px;
            font-weight: 600;
            color: #334155;
        }

        .academic-field select,
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

        .academic-field select:focus,
        .mapel-row select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
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

        .btn-add-row {
            background: #ffffff;
            color: #2563eb;
            border: 1px dashed #2563eb;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 4px;
        }

        .btn-add-row:hover {
            background: #eff6ff;
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

            .academic-grid-2,
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
                <h1>Tambah Jadwal</h1>
                <p>Formulir untuk menambahkan jadwal pelajaran baru.</p>
            </div>

            <form action="{{ route('admin.jadwal_pelajaran.store') }}" method="POST">
                @csrf

                <div class="academic-grid-2">
                    <div class="academic-field">
                        <label for="kelas_id">Kelas</label>
                        <select name="kelas_id" id="kelas_id" required>
                            <option value="">Pilih kelas</option>
                            @foreach ($kelas as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->nama_kelas }} - {{ $item->tingkat }}
                                    {{ optional($item->jurusan)->kode_jurusan ?? optional($item->jurusan)->nama_jurusan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="academic-field">
                        <label for="hari">Hari</label>
                        <select name="hari" id="hari" required>
                            @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $namaHari)
                                <option value="{{ $namaHari }}">{{ $namaHari }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="academic-section-title">Mapel dan JP</div>

                <div id="mapel-list">
                    <div class="mapel-row">
                        <select name="mapel_id[]" required>
                            <option value="">Pilih mapel</option>
                            @foreach ($mapel as $item)
                                <option value="{{ $item->id }}">{{ $item->kode_mapel }} - {{ $item->nama_mapel }}</option>
                            @endforeach
                        </select>

                        <select name="guru_id[]" required>
                            <option value="">Pilih guru</option>
                            @foreach ($guru as $item)
                                <option value="{{ $item->id }}">{{ $item->kode_guru ?? $item->nip }} - {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>

                        <select name="ruang_id[]" required>
                            <option value="">Pilih ruangan</option>
                            @foreach ($ruangan as $item)
                                <option value="{{ $item->id }}">{{ $item->kode_ruang }} - {{ $item->nama_ruang }}</option>
                            @endforeach
                        </select>

                        <select name="jumlah_jp[]" class="jumlah-jp" required>
                            @for ($jp = 1; $jp <= ($jumlahJpPerHari['Senin'] ?? 10); $jp++)
                                <option value="{{ $jp }}">{{ $jp }} JP</option>
                            @endfor
                        </select>

                        <button type="button" class="btn-hapus-row" onclick="hapusBaris(this)">Hapus</button>
                    </div>
                </div>

                <button type="button" class="btn-add-row" onclick="tambahMapel()">+ Tambah Mapel</button>

                <div class="academic-actions">
                    <button type="submit" class="btn-submit">Simpan</button>
                    <a href="{{ route('admin.jadwal_pelajaran.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const jumlahJpPerHari = @json($jumlahJpPerHari);

        function perbaruiPilihanJp() {
            const jumlahMaksimal = jumlahJpPerHari[document.getElementById('hari').value] || 10;
            document.querySelectorAll('.jumlah-jp').forEach((select) => {
                const nilaiLama = Math.min(Number(select.value) || 1, jumlahMaksimal);
                select.innerHTML = '';
                for (let jp = 1; jp <= jumlahMaksimal; jp += 1) {
                    const option = new Option(`${jp} JP`, jp);
                    option.selected = jp === nilaiLama;
                    select.add(option);
                }
            });
        }

        document.getElementById('hari').addEventListener('change', perbaruiPilihanJp);

        function tambahMapel() {
            const list = document.getElementById('mapel-list');
            const barisPertama = list.querySelector('.mapel-row');
            if (barisPertama) {
                const baris = barisPertama.cloneNode(true);
                baris.querySelectorAll('select').forEach((select) => select.selectedIndex = 0);
                list.appendChild(baris);
                perbaruiPilihanJp();
            }
        }

        function hapusBaris(button) {
            const list = document.getElementById('mapel-list');
            if (list.querySelectorAll('.mapel-row').length > 1) {
                button.parentElement.remove();
            } else {
                alert('Minimal harus ada 1 mata pelajaran.');
            }
        }
    </script>
@endpush