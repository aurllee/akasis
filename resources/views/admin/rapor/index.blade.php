@extends('layouts.app')

@section('title', 'Monitoring Rapor Digital')

@section('content')
<style>
    .monitoring-page {
        color: #1e293b;
    }

    .monitoring-heading {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 24px;
    }

    .monitoring-heading h3 {
        font-size: 25px;
        font-weight: 750;
        margin-bottom: 6px;
    }

    .monitoring-heading p {
        color: #64748b;
        margin: 0;
    }

    .monitor-card {
        background: #fff;
        border: 1px solid #e8edf3;
        border-radius: 14px;
        box-shadow: 0 3px 12px rgba(15, 23, 42, .035);
    }

    .filter-card {
        padding: 18px;
        margin-bottom: 22px;
    }

    .search-wrap {
        position: relative;
    }

    .search-wrap .bi-search {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }

    .search-wrap input {
        padding-left: 40px;
        min-height: 44px;
    }

    .filter-card .form-select {
        min-height: 44px;
    }

    .stat-card {
        padding: 18px;
        height: 100%;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .stat-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
        flex-shrink: 0;
    }

    .stat-label {
        color: #64748b;
        font-size: 13px;
        margin-bottom: 3px;
    }

    .stat-value {
        font-size: 25px;
        line-height: 1.2;
        font-weight: 750;
        margin: 0;
    }

    .monitor-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        border-bottom: 1px solid #e2e8f0;
        margin: 26px 0 18px;
        padding-bottom: 12px;
    }

    .monitor-tabs .nav-link {
        border: 1px solid #e2e8f0;
        border-radius: 9px;
        color: #475569;
        font-weight: 600;
        padding: 10px 14px;
    }

    .monitor-tabs .nav-link.active {
        background: #1d4ed8;
        border-color: #1d4ed8;
        color: #fff;
    }

    .section-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 15px;
    }

    .section-heading h5 {
        font-size: 17px;
        font-weight: 750;
        margin: 0;
    }

    .section-heading p {
        color: #64748b;
        font-size: 13px;
        margin: 4px 0 0;
    }

    .record-card {
        border: 1px solid #e5eaf1;
        border-radius: 12px;
        background: #fff;
        padding: 16px;
        margin-bottom: 12px;
    }

    .record-title {
        font-weight: 700;
        font-size: 15px;
        margin-bottom: 4px;
    }

    .record-meta {
        color: #64748b;
        font-size: 13px;
        line-height: 1.7;
    }

    .record-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
        margin-top: 14px;
    }

    .record-field {
        border-radius: 9px;
        background: #f8fafc;
        padding: 10px 12px;
        min-width: 0;
    }

    .record-field span {
        display: block;
        color: #64748b;
        font-size: 12px;
        margin-bottom: 4px;
    }

    .record-field strong {
        font-size: 14px;
        overflow-wrap: anywhere;
    }

    .detail-panel {
        background: #f8fafc;
        border-radius: 10px;
        padding: 16px;
        margin-top: 15px;
    }

    .detail-panel h6 {
        font-weight: 750;
        margin-bottom: 12px;
    }

    .detail-table {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 9px;
        overflow: hidden;
    }

    .detail-table .table {
        margin-bottom: 0;
    }

    .class-summary-card {
        padding: 18px;
        height: 100%;
    }

    .class-summary-card h6 {
        font-weight: 750;
        font-size: 16px;
        margin-bottom: 14px;
    }

    .class-score {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 9px 0;
        border-bottom: 1px solid #eef2f7;
        font-size: 13px;
    }

    .class-score:last-child {
        border-bottom: 0;
    }

    .class-score span {
        color: #64748b;
    }

    .class-score strong {
        text-align: right;
    }

    .revision-reason {
        margin-top: 12px;
        border-radius: 9px;
        padding: 12px;
        background: #f8fafc;
        color: #475569;
        white-space: normal;
        overflow-wrap: anywhere;
    }

    .empty-state {
        text-align: center;
        padding: 38px 18px;
        color: #64748b;
        border: 1px dashed #cbd5e1;
        border-radius: 12px;
        background: #fff;
    }

    .empty-state i {
        display: block;
        font-size: 28px;
        margin-bottom: 8px;
        color: #94a3b8;
    }

    @media (max-width: 767.98px) {
        .monitoring-heading h3 {
            font-size: 22px;
        }

        .record-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .stat-card {
            padding: 14px;
            gap: 10px;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            font-size: 18px;
        }

        .stat-value {
            font-size: 22px;
        }
    }

    @media (max-width: 420px) {
        .record-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container-fluid py-4 monitoring-page">
    <div class="monitoring-heading">
        <div>
            <h3>Monitoring Rapor Digital</h3>
            <p>Pantau status rapor, rekap nilai kelas, dan permintaan revisi.</p>
        </div>
    </div>

    <form id="filterRaporForm" action="{{ route('admin.rapor.index') }}" method="GET" class="monitor-card filter-card">
        <div class="row g-3 align-items-end">
            <div class="col-lg-4 col-md-6">
                <label for="cari" class="form-label fw-semibold">Pencarian</label>
                <div class="search-wrap">
                    <i class="bi bi-search"></i>
                    <input type="text" name="cari" id="cari" class="form-control"
                        value="{{ $cari }}" autocomplete="off"
                        placeholder="Cari siswa, NIS, mapel, atau guru...">
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <label for="tahun_ajaran_id" class="form-label fw-semibold">Tahun Ajaran</label>
                <select name="tahun_ajaran_id" id="tahun_ajaran_id" class="form-select">
                    <option value="">Semua Tahun Ajaran</option>
                    @foreach ($tahunAjaran as $ta)
                        <option value="{{ $ta->id }}"
                            @selected((string) $tahunAjaranId === (string) $ta->id)>
                            {{ $ta->tahun_ajaran }} - {{ $ta->semester }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-lg-2 col-md-6">
                <label for="semester" class="form-label fw-semibold">Semester</label>
                <select name="semester" id="semester" class="form-select">
                    <option value="">Semua</option>
                    <option value="Ganjil" @selected($semester === 'Ganjil')>Ganjil</option>
                    <option value="Genap" @selected($semester === 'Genap')>Genap</option>
                </select>
            </div>

            <div class="col-lg-3 col-md-6">
                <label for="kelas_id" class="form-label fw-semibold">Kelas</label>
                <select name="kelas_id" id="kelas_id" class="form-select">
                    <option value="">Semua Kelas</option>
                    @foreach ($kelas as $itemKelas)
                        <option value="{{ $itemKelas->id }}"
                            @selected((string) $kelasId === (string) $itemKelas->id)>
                            {{ $itemKelas->tingkat }} {{ $itemKelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    <div class="row g-3">
        <div class="col-6 col-xl-3">
            <div class="monitor-card stat-card">
                <div class="stat-icon bg-primary-subtle text-primary"><i class="bi bi-files"></i></div>
                <div>
                    <div class="stat-label">Total Rapor</div>
                    <p class="stat-value">{{ $statistik->total ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="monitor-card stat-card">
                <div class="stat-icon bg-secondary-subtle text-secondary"><i class="bi bi-file-earmark"></i></div>
                <div>
                    <div class="stat-label">Draft</div>
                    <p class="stat-value">{{ $statistik->draft ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="monitor-card stat-card">
                <div class="stat-icon bg-warning-subtle text-warning"><i class="bi bi-arrow-repeat"></i></div>
                <div>
                    <div class="stat-label">Perlu Revisi</div>
                    <p class="stat-value">{{ $statistik->perlu_revisi ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="monitor-card stat-card">
                <div class="stat-icon bg-success-subtle text-success"><i class="bi bi-check-circle"></i></div>
                <div>
                    <div class="stat-label">Final</div>
                    <p class="stat-value">{{ $statistik->final ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <ul class="nav monitor-tabs" id="monitoringRaporTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tab-daftar" data-bs-toggle="tab"
                data-bs-target="#panel-daftar" type="button" role="tab">
                <i class="bi bi-people me-1"></i> Daftar Rapor
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-rekap" data-bs-toggle="tab"
                data-bs-target="#panel-rekap" type="button" role="tab">
                <i class="bi bi-bar-chart me-1"></i> Rekap Kelas
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-revisi" data-bs-toggle="tab"
                data-bs-target="#panel-revisi" type="button" role="tab">
                <i class="bi bi-arrow-repeat me-1"></i> Permintaan Revisi
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="panel-daftar" role="tabpanel" aria-labelledby="tab-daftar">
            <div class="section-heading">
                <div>
                    <h5>Daftar Rapor Siswa</h5>
                    <p>Pilih detail untuk melihat nilai dan catatan rapor.</p>
                </div>
                <span class="badge text-bg-light">{{ $rapor->total() }} data</span>
            </div>

            @forelse ($rapor as $item)
                <div class="record-card">
                    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                        <div>
                            <div class="record-title">{{ $item->nama_siswa ?? 'Siswa tidak ditemukan' }}</div>
                            <div class="record-meta">
                                NIS: {{ $item->nis ?? '-' }} ·
                                Kelas {{ $item->tingkat }} {{ $item->nama_kelas }} ·
                                {{ $item->tahun_ajaran ?? '-' }} · {{ $item->semester }}
                            </div>
                            <div class="record-meta">Wali kelas: {{ $item->nama_wali_kelas ?? '-' }}</div>
                        </div>
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            @if ($item->status === 'final')
                                <span class="badge text-bg-success">Final</span>
                            @elseif ($item->status === 'perlu_revisi')
                                <span class="badge text-bg-warning">Perlu Revisi</span>
                            @else
                                <span class="badge text-bg-secondary">{{ ucfirst($item->status ?? 'Tidak diketahui') }}</span>
                            @endif
                            <button class="btn btn-sm btn-outline-primary" type="button"
                                data-bs-toggle="collapse" data-bs-target="#detailRapor{{ $item->id }}"
                                aria-expanded="false">
                                <i class="bi bi-chevron-down me-1"></i>Detail Rapor
                            </button>
                        </div>
                    </div>

                    <div class="record-grid">
                        <div class="record-field">
                            <span>Status Rapor</span>
                            <strong>{{ ucfirst(str_replace('_', ' ', $item->status ?? '-')) }}</strong>
                        </div>
                        <div class="record-field">
                            <span>Tanggal Finalisasi</span>
                            <strong>{{ $item->finalized_at ? \Carbon\Carbon::parse($item->finalized_at)->format('d-m-Y H:i') : '-' }}</strong>
                        </div>
                        <div class="record-field">
                            <span>Jumlah Mata Pelajaran</span>
                            <strong>{{ $item->detail_nilai->count() }}</strong>
                        </div>
                        <div class="record-field">
                            <span>Catatan Wali Kelas</span>
                            <strong>{{ $item->catatan_wali_kelas ? 'Sudah diisi' : 'Belum diisi' }}</strong>
                        </div>
                    </div>

                    <div class="collapse" id="detailRapor{{ $item->id }}">
                        <div class="detail-panel">
                            <div class="row g-3">
                                <div class="col-12">
                                    <h6>Nilai Mata Pelajaran</h6>
                                    <div class="detail-table table-responsive">
                                        <table class="table table-sm table-hover align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="px-3">Mata Pelajaran</th>
                                                    <th>Nilai Mapel</th>
                                                    <th>Nilai PjBL</th>
                                                    <th>Nilai Akhir</th>
                                                    <th>Status</th>
                                                    <th>Deskripsi Capaian</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($item->detail_nilai as $nilai)
                                                    <tr>
                                                        <td class="px-3">{{ $nilai->nama_mapel ?? '-' }}</td>
                                                        <td>{{ $nilai->nilai_mapel ?? '-' }}</td>
                                                        <td>{{ $nilai->nilai_pjbl ?? '-' }}</td>
                                                        <td class="fw-semibold">{{ $nilai->nilai_akhir ?? '-' }}</td>
                                                        <td>
                                                            @if (($nilai->status ?? '') === 'aman')
                                                                <span class="badge text-bg-success">Aman</span>
                                                            @elseif (($nilai->status ?? '') === 'perlu_revisi')
                                                                <span class="badge text-bg-warning">Perlu Revisi</span>
                                                            @else
                                                                {{ ucfirst($nilai->status ?? '-') }}
                                                            @endif
                                                        </td>
                                                        <td style="min-width: 220px; white-space: normal;">{{ $nilai->deskripsi_capaian ?? '-' }}</td>
                                                    </tr>
                                                @empty
                                                    <tr><td colspan="6" class="text-center text-muted py-3">Belum ada detail nilai.</td></tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="bg-white border rounded-3 p-3 h-100">
                                        <div class="small text-muted mb-1">Deskripsi Capaian Rapor</div>
                                        <div>{{ $item->deskripsi_capaian ?: 'Belum diisi.' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="bg-white border rounded-3 p-3 h-100">
                                        <div class="small text-muted mb-1">Catatan Wali Kelas</div>
                                        <div>{{ $item->catatan_wali_kelas ?: 'Belum diisi.' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="bi bi-folder2-open"></i>
                    <div class="fw-semibold">Belum ada data rapor</div>
                    <div class="small">Coba ubah kata kunci atau filter pencarian.</div>
                </div>
            @endforelse

            @if ($rapor->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $rapor->appends(request()->query())->links() }}
                </div>
            @endif
        </div>

        <div class="tab-pane fade" id="panel-rekap" role="tabpanel" aria-labelledby="tab-rekap">
            <div class="section-heading">
                <div>
                    <h5>Rekap Rapor per Kelas</h5>
                    <p>Ringkasan jumlah rapor dan rata-rata nilai akhir yang sudah final.</p>
                </div>
            </div>

            <div class="row g-3">
                @forelse ($rekapKelas as $rekap)
                    <div class="col-md-6 col-xl-4">
                        <div class="monitor-card class-summary-card">
                            <h6><i class="bi bi-mortarboard me-2 text-primary"></i>Kelas {{ $rekap->tingkat }} {{ $rekap->nama_kelas }}</h6>
                            <div class="class-score"><span>Total Rapor</span><strong>{{ $rekap->jumlah_rapor }}</strong></div>
                            <div class="class-score"><span>Draft</span><strong>{{ $rekap->jumlah_draft }}</strong></div>
                            <div class="class-score"><span>Perlu Revisi</span><strong>{{ $rekap->jumlah_revisi }}</strong></div>
                            <div class="class-score"><span>Final</span><strong>{{ $rekap->jumlah_final }}</strong></div>
                            <div class="class-score">
                                <span>Rata-rata Nilai Final</span>
                                <strong class="text-primary">
                                    {{ $rekap->rata_rata_nilai !== null ? number_format($rekap->rata_rata_nilai, 2, ',', '.') : '-' }}
                                </strong>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-state">
                            <i class="bi bi-bar-chart"></i>
                            <div class="fw-semibold">Belum ada rekap kelas</div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="tab-pane fade" id="panel-revisi" role="tabpanel" aria-labelledby="tab-revisi">
            <div class="section-heading">
                <div>
                    <h5>Monitoring Permintaan Revisi</h5>
                    <p>Daftar permintaan revisi rapor yang diajukan wali kelas.</p>
                </div>
                <span class="badge text-bg-light">{{ $permintaanRevisi->total() }} data</span>
            </div>

            @forelse ($permintaanRevisi as $revisi)
                <div class="record-card">
                    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                        <div>
                            <div class="record-title">{{ $revisi->nama_siswa ?? 'Siswa tidak ditemukan' }}</div>
                            <div class="record-meta">
                                NIS: {{ $revisi->nis ?? '-' }} ·
                                Kelas {{ $revisi->tingkat }} {{ $revisi->nama_kelas }}
                            </div>
                            <div class="record-meta">
                                {{ $revisi->nama_mapel ?? '-' }} ·
                                Guru tujuan: {{ $revisi->nama_guru ?? '-' }}
                            </div>
                        </div>
                        <div class="text-md-end">
                            @if ($revisi->status === 'menunggu')
                                <span class="badge text-bg-warning">Menunggu</span>
                            @elseif ($revisi->status === 'selesai')
                                <span class="badge text-bg-success">Selesai</span>
                            @else
                                <span class="badge text-bg-secondary">{{ ucfirst($revisi->status ?? 'Tidak diketahui') }}</span>
                            @endif
                            <div class="record-meta mt-2">
                                {{ $revisi->semester }} · {{ $revisi->tahun_ajaran ?? '-' }}
                            </div>
                        </div>
                    </div>
                    <div class="revision-reason">
                        <div class="small fw-semibold text-muted mb-1">Alasan Revisi</div>
                        {{ $revisi->alasan_revisi ?? '-' }}
                    </div>
                    <div class="record-meta mt-2">
                        <i class="bi bi-clock me-1"></i>
                        Diajukan: {{ $revisi->created_at ? \Carbon\Carbon::parse($revisi->created_at)->format('d-m-Y H:i') : '-' }}
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <div class="fw-semibold">Belum ada permintaan revisi</div>
                </div>
            @endforelse

            @if ($permintaanRevisi->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $permintaanRevisi->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('filterRaporForm');
    const search = document.getElementById('cari');
    const filters = form.querySelectorAll('select');
    let searchTimer;

    search.addEventListener('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function () {
            form.requestSubmit();
        }, 450);
    });

    filters.forEach(function (filter) {
        filter.addEventListener('change', function () {
            form.requestSubmit();
        });
    });

    const activeTabKey = 'adminMonitoringRaporActiveTab';
    const savedTab = sessionStorage.getItem(activeTabKey);
    if (savedTab) {
        const tabButton = document.querySelector('[data-bs-target="' + savedTab + '"]');
        if (tabButton && window.bootstrap) {
            bootstrap.Tab.getOrCreateInstance(tabButton).show();
        }
    }

    document.querySelectorAll('#monitoringRaporTabs [data-bs-toggle="tab"]').forEach(function (tab) {
        tab.addEventListener('shown.bs.tab', function (event) {
            sessionStorage.setItem(activeTabKey, event.target.getAttribute('data-bs-target'));
        });
    });
});
</script>
@endsection
