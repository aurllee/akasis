<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<aside class="sidebar">
    <div class="sidebar-header">
        <h2>Sistem Akademik</h2>
        <p>Panel Guru</p>
    </div>

    <nav class="menu">
        <div class="menu-title">Menu Utama</div>
        <a href="{{ route('guru.dashboard') }}" class="{{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-door" aria-hidden="true"></i>
            <span>Dashboard</span>
        </a>

        <div class="menu-title">Akun</div>
        <a href="{{ route('password.change') }}" class="{{ request()->routeIs('password.change') ? 'active' : '' }}">
            <i class="bi bi-key" aria-hidden="true"></i>
            <span>Ganti Password</span>
        </a>

        <div class="menu-title">Penilaian</div>
        <a href="{{ route('guru.penilaian.index') }}"
            class="{{ request()->routeIs('guru.penilaian.*') ? 'active' : '' }}">
            <i class="bi bi-pencil-square" aria-hidden="true"></i>
            <span>Input Nilai</span>
        </a>
        <a href="{{ route('guru.penilaian-pjbl.index') }}"
            class="{{ request()->routeIs('guru.penilaian-pjbl.*') ? 'active' : '' }}">
            <i class="bi bi-journal-check" aria-hidden="true"></i>
            <span>Penilaian PjBL</span>
        </a>

        <div class="menu-title">Jadwal pelajaran</div>
        <a href="{{ route('guru.jadwal.index') }}" class="{{ request()->routeIs('guru.jadwal.*') ? 'active' : '' }}">
            <i class="bi bi-calendar3" aria-hidden="true"></i>
            <span>Lihat Jadwal</span>
        </a>

        <div class="menu-title">Absensi</div>
        <a href="{{ route('absensi.index') }}" class="{{ request()->routeIs('absensi.*') ? 'active' : '' }}">
            <i class="bi bi-check2-square" aria-hidden="true"></i>
            <span>Lihat Absensi</span>
        </a>

        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit">
                <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
                <span>Logout</span>
            </button>
        </form>
    </nav>
</aside>