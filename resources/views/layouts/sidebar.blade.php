<aside class="sidebar">



    <div class="sidebar-header">
        <h2>Sistem Akademik</h2>
        <p>Admin Sekolah</p>
    </div>



    <div class="menu">

        <div class="menu-title">
            Menu Utama
        </div>

        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>




        <div class="menu-title">
            SPMB
        </div>

        <a href="{{ route('admin.spmb.index') }}" class="{{ request()->routeIs('admin.spmb.*') ? 'active' : '' }}">
            <i class="bi bi-person-plus"></i>
            <span>Calon Siswa</span>
        </a>



        <div class="menu-title">
            Master Data
        </div>

        <a href="{{ route('jurusan.index') }}" class="{{ request()->routeIs('jurusan.*') ? 'active' : '' }}">
            <i class="bi bi-diagram-3"></i>
            <span>Jurusan</span>
        </a>

        <a href="{{ route('ruangan.index') }}" class="{{ request()->routeIs('ruangan.*') ? 'active' : '' }}">
            <i class="bi bi-building"></i>
            <span>Ruangan</span>
        </a>

        <a href="{{ route('mata_pelajaran.index') }}"
            class="{{ request()->routeIs('mata_pelajaran.*') ? 'active' : '' }}">
            <i class="bi bi-book"></i>
            <span>Mata Pelajaran</span>
        </a>

        <a href="{{ route('tahun-ajaran.index') }}" class="{{ request()->routeIs('tahun-ajaran.*') ? 'active' : '' }}">
            <i class="bi bi-calendar3"></i>
            <span>Tahun Ajaran</span>
        </a>

        <a href="{{ route('siswa.index') }}" class="{{ request()->routeIs('siswa.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i>
            <span>Siswa</span>
        </a>

        <a href="{{ route('guru.index') }}" class="{{ request()->routeIs('guru.*') ? 'active' : '' }}">
            <i class="bi bi-person-badge"></i>
            <span>Guru</span>
        </a>

        <a href="{{ route('kelas.index') }}" class="{{ request()->routeIs('kelas.*') ? 'active' : '' }}">
            <i class="bi bi-grid-3x3-gap"></i>
            <span>Kelas</span>
        </a>



        <div class="menu-title">
            Pembagian Kelas
        </div>

        <a href="{{ route('pembagian_kelas.index') }}"
            class="{{ request()->routeIs('pembagian_kelas.*') ? 'active' : '' }}">
            <i class="bi bi-diagram-2"></i>
            <span>Pembagian Kelas</span>
        </a>


        <div class="menu-title">
            Jadwal
        </div>

        <a href="{{ route('admin.jadwal_pelajaran.index') }}"
            class="{{ request()->routeIs('admin.jadwal_pelajaran.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-week"></i>
            <span>Lihat Jadwal</span>
        </a>


        <div class="menu-title">
            Presensi
        </div>

        <a href="{{ route('admin.absensi.index') }}"
            class="{{ request()->routeIs('admin.absensi.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-check"></i>
            <span>Absensi</span>
        </a>

        <a href="{{ route('admin.izin-pulang.index') }}"
            class="{{ request()->routeIs('admin.izin-pulang.*') ? 'active' : '' }}">
            <i class="bi bi-house-door"></i>
            <span>Pengajuan Izin</span>
        </a>


        <div class="menu-title">
            Penilaian
        </div>

        <a href="{{ route('admin.penilaian.mapel.index') }}"
            class="{{ request()->routeIs('admin.penilaian.mapel.*') ? 'active' : '' }}">
            <i class="bi bi-journal-check"></i>
            <span>Penilaian Mata Pelajaran</span>
        </a>

        <a href="{{ route('admin.penilaian.pjbl.index') }}"
            class="{{ request()->routeIs('admin.penilaian.pjbl.*') ? 'active' : '' }}">
            <i class="bi bi-clipboard-check"></i>
            <span>Penilaian PJBL</span>
        </a>

    </div>




    <form action="{{ route('logout') }}" method="POST" class="logout-form">
        @csrf

        <button type="submit">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
        </button>
    </form>

</aside>