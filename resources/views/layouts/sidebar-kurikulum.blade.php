<aside class="sidebar">
    <div class="sidebar-header">
        <h2>Sistem Akademik</h2>
        <p>Panel Kurikulum</p>
    </div>

    <nav class="menu">
        <div class="menu-title">Menu Utama</div>
<<<<<<< HEAD
        <a href="{{ route('kurikulum.dashboard') }}" class="{{ request()->routeIs('kurikulum.dashboard', 'admin.dashboard', 'dashboard') ? 'active' : '' }}">
=======
        <a href="{{ route('kurikulum.dashboard') }}" class="{{ request()->routeIs('kurikulum.dashboard') ? 'active' : '' }}">
>>>>>>> 2dc084253c21c89355dff0c0ec75be353e7becb4
            <i class="bi bi-speedometer2" aria-hidden="true"></i>
            <span>Dashboard</span>
        </a>

        <div class="menu-title">Pembagian Kelas</div>
        <a href="{{ route('guru.index') }}" class="{{ request()->routeIs('guru.*') ? 'active' : '' }}">
            <i class="bi bi-person-badge" aria-hidden="true"></i>
            <span>Data Guru</span>
        </a>
        <a href="{{ route('siswa.index') }}" class="{{ request()->routeIs('siswa.*') ? 'active' : '' }}">
            <i class="bi bi-people" aria-hidden="true"></i>
            <span>Data Siswa</span>
        </a>
        <a href="{{ route('admin.spmb.index') }}" class="{{ request()->routeIs('admin.spmb.*') ? 'active' : '' }}">
            <i class="bi bi-person-plus" aria-hidden="true"></i>
            <span>Calon Siswa SPMB</span>
        </a>
        <a href="{{ route('pembagian_kelas.index') }}" class="{{ request()->routeIs('pembagian_kelas.*') ? 'active' : '' }}">
            <i class="bi bi-person-lines-fill" aria-hidden="true"></i>
            <span>Plotting Siswa</span>
        </a>
        <a href="{{ route('kelas.index') }}" class="{{ request()->routeIs('kelas.*') ? 'active' : '' }}">
            <i class="bi bi-grid-3x3-gap" aria-hidden="true"></i>
            <span>Kelas & Wali Kelas</span>
        </a>

        <div class="menu-title">Kurikulum dan KBM</div>
        <a href="{{ route('mata_pelajaran.index') }}" class="{{ request()->routeIs('mata_pelajaran.*') ? 'active' : '' }}">
            <i class="bi bi-book" aria-hidden="true"></i>
            <span>Mata Pelajaran</span>
        </a>
        <a href="{{ route('admin.jadwal_pelajaran.index') }}" class="{{ request()->routeIs('admin.jadwal_pelajaran.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-week" aria-hidden="true"></i>
            <span>Jadwal KBM</span>
        </a>

        <div class="menu-title">Penilaian Proyek</div>
        <a href="{{ route('kurikulum.pjbl.index') }}" class="{{ request()->routeIs('kurikulum.pjbl.*', 'admin.penilaian.pjbl.*') ? 'active' : '' }}">
            <i class="bi bi-kanban" aria-hidden="true"></i>
            <span>Laporan PjBL</span>
        </a>
        <a href="{{ route('kurikulum.rapor.index') }}" class="{{ request()->routeIs('kurikulum.rapor.*', 'admin.rapor.*') ? 'active' : '' }}">
            <i class="bi bi-journal-check" aria-hidden="true"></i>
            <span>Rapor Siswa</span>
        </a>

        <div class="menu-title">Pengaturan</div>
        <a href="{{ route('tahun-ajaran.index') }}" class="{{ request()->routeIs('tahun-ajaran.*') ? 'active' : '' }}">
            <i class="bi bi-calendar3" aria-hidden="true"></i>
            <span>Tahun Ajaran</span>
        </a>

        <div class="menu-title">Akun</div>
        <a href="{{ route('password.change') }}" class="{{ request()->routeIs('password.change') ? 'active' : '' }}">
            <i class="bi bi-key" aria-hidden="true"></i>
            <span>Ganti Password</span>
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