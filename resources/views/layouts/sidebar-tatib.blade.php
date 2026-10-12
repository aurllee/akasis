<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<aside class="sidebar">
    <div class="sidebar-header">
        <h2>Sistem Akademik</h2>
        <p>Panel Tatib</p>
    </div>

    <nav class="menu">
        <div class="menu-title">Menu Utama</div>
        <a href="{{ route('tatib.dashboard') }}" class="{{ request()->routeIs('tatib.dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-door" aria-hidden="true"></i>
            <span>Dashboard</span>
        </a>

        <div class="menu-title">Akun</div>
        <a href="{{ route('password.change') }}" class="{{ request()->routeIs('password.change') ? 'active' : '' }}">
            <i class="bi bi-key" aria-hidden="true"></i>
            <span>Ganti Password</span>
        </a>

        <div class="menu-title">Tatib</div>
        <a href="{{ route('tatib.dashboard') }}" class="{{ request()->routeIs('tatib.dashboard') ? 'active' : '' }}">
            <i class="bi bi-person-lines-fill" aria-hidden="true"></i>
            <span>Daftar Pelanggaran</span>
        </a>
        <a href="{{ route('tatib.dashboard') }}" class="{{ request()->routeIs('tatib.dashboard') ? 'active' : '' }}">
            <i class="bi bi-clipboard-check" aria-hidden="true"></i>
            <span>Riwayat Siswa</span>
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