<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<aside class="sidebar">

    <div class="sidebar-header">
        <h2>Sistem Akademik</h2>
        <p>Wali Kelas</p>
    </div>

    <nav class="menu">

        @php
        $waliKelasPertama = null;

        if (auth()->check() && auth()->user()->guru_id) {
        $waliKelasPertama = \App\Models\WaliKelas::where('guru_id', auth()->user()->guru_id)->first();
        }
        @endphp

        <div class="menu-title">Menu Utama</div>

        <a href="{{ route('wali-kelas.dashboard') }}"
            class="{{ request()->routeIs('wali-kelas.dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-door" aria-hidden="true"></i>
            <span>Beranda</span>
        </a>

        <div class="menu-title">Akun</div>

        <a href="{{ route('password.change') }}"
            class="{{ request()->routeIs('password.change') ? 'active' : '' }}">
            <i class="bi bi-key" aria-hidden="true"></i>
            <span>Ganti Password</span>
        </a>

        <div class="menu-title">Wali Kelas</div>

        <a href="{{ $waliKelasPertama ? route('wali-kelas.siswa', $waliKelasPertama->kelas_id) : '#' }}"
            class="{{ request()->routeIs('wali-kelas.siswa') ? 'active' : '' }}">
            <i class="bi bi-people" aria-hidden="true"></i>
            <span>Data Siswa</span>
        </a>

        <a href="{{ route('wali-kelas.sakit.index') }}"
            class="{{ request()->routeIs(['wali-kelas.sakit.index', 'wali-kelas.sakit.setujui', 'wali-kelas.sakit.tolak', 'wali-kelas.sakit.*']) ? 'active' : '' }}">
            <i class="bi bi-calendar-x" aria-hidden="true"></i>
            <span>Izin Tidak Masuk</span>
        </a>

        <a href="{{ route('wali-kelas.absen.index') }}"
            class="{{ request()->routeIs('wali-kelas.absen.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-check" aria-hidden="true"></i>
            <span>Absensi Siswa</span>
        </a>

        @php
        $jadwalSaya = collect();

        if (auth()->check() && auth()->user()->guru_id) {
        $jadwalSaya = \App\Models\Jadwal_pelajaran::with([
        'kelas',
        'mataPelajaran'
        ])
        ->where('guru_id', auth()->user()->guru_id)
        ->orderBy('hari')
        ->orderBy('jam_mulai')
        ->get();
        }
        @endphp

        @if($jadwalSaya->isNotEmpty())

        <div class="menu-title">Guru Mata Pelajaran</div>

        <a href="{{ route('guru.penilaian.index') }}"
            class="{{ request()->routeIs('guru.penilaian.*') ? 'active' : '' }}">
            <i class="bi bi-clipboard2-check" aria-hidden="true"></i>
            <span>Nilai Harian</span>
        </a>

        <a href="{{ route('guru.penilaian-pjbl.index') }}"
            class="{{ request()->routeIs('guru.penilaian-pjbl.*') ? 'active' : '' }}">
            <i class="bi bi-kanban" aria-hidden="true"></i>
            <span>Penilaian PjBL</span>
        </a>

        <a href="{{ route('absensi.index') }}"
            class="{{ request()->routeIs('absensi.*') ? 'active' : '' }}">
            <i class="bi bi-journal-text" aria-hidden="true"></i>
            <span>Absensi</span>
        </a>

        @endif

    </nav>

    <form action="{{ route('logout') }}" method="POST" class="logout-form">
        @csrf

        <button type="submit">
            <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
            Logout
        </button>
    </form>

</aside>