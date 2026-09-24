<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\PembagianKelasController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\Admin\SpmbController;
use App\Http\Controllers\JadwalpelajaranController;
use App\Http\Controllers\Siswa\JadwalPelajaranController as SiswaJadwalPelajaranController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Guru\PenilaianController;
use App\Http\Controllers\WaliKelasController;
use App\Http\Controllers\Admin\PenilaianPjblController;
use App\Http\Controllers\Admin\AbsensiController;
use App\Http\Controllers\Siswa\AbsensiController as SiswaAbsensiController;
use App\Http\Controllers\Admin\SakitController;
use App\Http\Controllers\Admin\IzinKeluarController;
use App\Http\Controllers\Admin\IzinPulangController;
use App\Http\Controllers\Admin\DispenController;
use App\Http\Controllers\Guru\PenilaianPjblController as GuruPenilaianPjblController;
use App\Http\Controllers\Guru\JadwalController;
use App\Http\Controllers\Guru\SesiAbsensiController;
use App\Http\Controllers\Siswa\PerizinanController;
use App\Http\Controllers\Siswa\DispenController as SiswaDispenController;
use App\Http\Controllers\Walikelas\SakitController as WaliKelasSakitController;
use App\Http\Controllers\Walikelas\AbsenController as WaliKelasAbsenController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;





Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.proses');

Route::get('/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::get('/guru/dashboard', [GuruDashboardController::class, 'index'])
    ->middleware('auth')
    ->name('guru.dashboard');

Route::get('/siswa/dashboard', [SiswaDashboardController::class, 'index'])
    ->middleware('auth')
    ->name('siswa.dashboard');

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/ganti-password', [AuthController::class, 'showChangePassword'])->middleware('auth')->name('password.change');

Route::post('/ganti-password', [AuthController::class, 'changePassword'])->middleware('auth')->name('password.update');


Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [
            AdminDashboardController::class,
            'index'
        ])->name('dashboard');
    });


Route::get('/admin/ruangan', [RuanganController::class, 'index'])->name('ruangan.index');
Route::get('/admin/ruangan/create', [RuanganController::class, 'create'])->name('ruangan.create');
Route::post('/admin/ruangan', [RuanganController::class, 'store'])->name('ruangan.store');
Route::get('/admin/ruangan/{id}/edit', [RuanganController::class, 'edit'])->name('ruangan.edit');
Route::put('/admin/ruangan/{id}', [RuanganController::class, 'update'])->name('ruangan.update');
Route::delete('/admin/ruangan/{id}', [RuanganController::class, 'destroy'])->name('ruangan.destroy');

Route::get('/admin/mata_pelajaran', [MataPelajaranController::class, 'index'])->name('mata_pelajaran.index');
Route::get('/admin/mata_pelajaran/create', [MataPelajaranController::class, 'create'])->name('mata_pelajaran.create');
Route::post('/admin/mata_pelajaran', [MataPelajaranController::class, 'store'])->name('mata_pelajaran.store');
Route::get('/admin/mata_pelajaran/{id}/edit', [MataPelajaranController::class, 'edit'])->name('mata_pelajaran.edit');
Route::put('/admin/mata_pelajaran/{id}', [MataPelajaranController::class, 'update'])->name('mata_pelajaran.update');
Route::delete('/admin/mata_pelajaran/{id}', [MataPelajaranController::class, 'destroy'])->name('mata_pelajaran.destroy');


Route::get('/admin/pembagian_kelas', [PembagianKelasController::class, 'index'])->name('pembagian_kelas.index');
Route::get('/admin/pembagian_kelas/create', [PembagianKelasController::class, 'create'])->name('pembagian_kelas.create');
Route::post('/admin/pembagian_kelas', [PembagianKelasController::class, 'store'])->name('pembagian_kelas.store');
Route::get('/admin/pembagian_kelas/{id}/edit', [PembagianKelasController::class, 'edit'])->name('pembagian_kelas.edit');
Route::put('/admin/pembagian_kelas/{id}', [PembagianKelasController::class, 'update'])->name('pembagian_kelas.update');
Route::delete('/admin/pembagian_kelas/{id}', [PembagianKelasController::class, 'destroy'])->name('pembagian_kelas.destroy');
Route::post('/admin/pembagian_kelas/import', [PembagianKelasController::class, 'import'])->name('pembagian_kelas.import');


Route::get('/admin/jadwal_pelajaran', [JadwalpelajaranController::class, 'index'])->name('admin.jadwal_pelajaran.index');
Route::get('/admin/jadwal_pelajaran/create', [JadwalpelajaranController::class, 'create'])->name('admin.jadwal_pelajaran.create');
Route::post('/admin/jadwal_pelajaran', [JadwalpelajaranController::class, 'store'])->name('admin.jadwal_pelajaran.store');
Route::get('/admin/jadwal_pelajaran/export/excel', [JadwalpelajaranController::class, 'exportExcel'])->name('admin.jadwal_pelajaran.export_excel');
Route::get('/admin/jadwal_pelajaran/export/pdf', [JadwalpelajaranController::class, 'exportPdf'])->name('admin.jadwal_pelajaran.export_pdf');
Route::get('/admin/jadwal_pelajaran/kelas/{kelasId}/hari/{hari}/edit', [JadwalpelajaranController::class, 'editHari'])->name('admin.jadwal_pelajaran.edit_hari');
Route::put('/admin/jadwal_pelajaran/kelas/{kelasId}/hari/{hari}', [JadwalpelajaranController::class, 'updateHari'])->name('admin.jadwal_pelajaran.update_hari');
Route::delete('/admin/jadwal_pelajaran/kelas/{kelasId}/hari/{hari}', [JadwalpelajaranController::class, 'destroyHari'])->name('admin.jadwal_pelajaran.destroy_hari');
Route::get('/admin/jadwal_pelajaran/{id}/edit', [JadwalpelajaranController::class, 'edit'])->name('admin.jadwal_pelajaran.edit');
Route::put('/admin/jadwal_pelajaran/{id}', [JadwalpelajaranController::class, 'update'])->name('admin.jadwal_pelajaran.update');
Route::delete('/admin/jadwal_pelajaran/{id}', [JadwalpelajaranController::class, 'destroy'])->name('admin.jadwal_pelajaran.destroy');
Route::patch('/admin/jadwal-pelajaran/publish', [JadwalPelajaranController::class, 'publish'])
    ->name('admin.jadwal_pelajaran.publish');


Route::get('/admin/master-data', function () {
    return view('admin.master-data.index');
})->name('master-data.index');

Route::resource('tahun-ajaran', TahunAjaranController::class)->except(['show']);
Route::resource('jurusan', JurusanController::class)->except(['show']);
Route::resource('siswa', SiswaController::class)->except(['show']);
Route::resource('admin/master-data/guru', GuruController::class)
    ->except(['show'])
    ->names('guru');
Route::resource('kelas', KelasController::class)->except(['show']);


Route::middleware('auth')->prefix('wali-kelas')->name('wali-kelas.')->group(function () {
    Route::get('/dashboard', [WaliKelasController::class, 'dashboard'])->name('dashboard');
    Route::get('/', [WaliKelasController::class, 'index'])->name('index');
    Route::get('/siswa/{kelas}', [WaliKelasController::class, 'siswa'])->name('siswa');
    Route::get('/nilai/{siswa}', [WaliKelasController::class, 'nilai'])->name('nilai');
    Route::get('/absen', [WaliKelasAbsenController::class, 'index'])->name('absen.index');
});

Route::get('/wali-kelas/kelas-mengajar', [WaliKelasController::class, 'kelasMengajar'])
    ->name('wali-kelas.kelas-mengajar');


Route::middleware('auth')->prefix('wali-kelas')->name('wali-kelas.')->group(function () {
    Route::get('/izin-tidak-masuk', [WaliKelasSakitController::class, 'index'])->name('sakit.index');
    Route::patch('/izin-tidak-masuk/{sakit}/setujui', [WaliKelasSakitController::class, 'setujui'])->name('sakit.setujui');
    Route::patch('/izin-tidak-masuk/{sakit}/tolak', [WaliKelasSakitController::class, 'tolak'])->name('sakit.tolak');
});

Route::prefix('admin')->group(function () {
    Route::get('/spmb/calon-siswa', [SpmbController::class, 'index'])->name('admin.spmb.index');
    Route::get('/spmb/calon-siswa/create', [SpmbController::class, 'create'])->name('admin.spmb.create');
    Route::post('/spmb/calon-siswa', [SpmbController::class, 'store'])->name('admin.spmb.store');
    Route::get('/spmb/calon-siswa/{id}', [SpmbController::class, 'show'])->name('admin.spmb.show');
    Route::get('/spmb/calon-siswa/{id}/edit', [SpmbController::class, 'edit'])->name('admin.spmb.edit');
    Route::put('/spmb/calon-siswa/{id}', [SpmbController::class, 'update'])->name('admin.spmb.update');
    Route::delete('/spmb/calon-siswa/{id}', [SpmbController::class, 'destroy'])->name('admin.spmb.destroy');
    Route::put('/spmb/calon-siswa/{id}/dokumen/{dokumenId}/verifikasi', [SpmbController::class, 'verifikasiDokumen'])->name('admin.spmb.dokumen.verifikasi');
    Route::put('/spmb/calon-siswa/{id}/verifikasi-daftar-ulang', [SpmbController::class, 'verifikasiDaftarUlang'])->name('admin.spmb.daftar-ulang.verifikasi');
});


Route::middleware('auth')->group(function () {

    Route::get(
        '/guru/penilaian',
        [PenilaianController::class, 'index']
    )->name('guru.penilaian.index');

    Route::get(
        '/guru/penilaian/{jadwal}/input',
        [PenilaianController::class, 'create']
    )->name('guru.penilaian.create');

    Route::post(
        '/guru/penilaian/{jadwal}',
        [PenilaianController::class, 'store']
    )->name('guru.penilaian.store');

    Route::get(
        '/guru/penilaian/{jadwalId}/detail_penilaian',
        [PenilaianController::class, 'detail']
    )->name('guru.penilaian.detail');

    Route::get(
        '/guru/penilaian/{jadwal}/siswa/{siswa}/edit',
        [PenilaianController::class, 'editSiswa']
    )->name('guru.penilaian.editSiswa');

    Route::put(
        '/guru/penilaian/{jadwal}/siswa/{siswa}/update',
        [PenilaianController::class, 'updateSiswa']
    )->name('guru.penilaian.updateSiswa');
});

Route::prefix('admin')->name('admin.')->group(function () {



    Route::get('/penilaian/mapel', [
        \App\Http\Controllers\Admin\PenilaianMapelController::class,
        'index'
    ])->name('penilaian.mapel.index');

    Route::get('/penilaian/mapel/kelas/{kelasId}', [
        \App\Http\Controllers\Admin\PenilaianMapelController::class,
        'kelas'
    ])->name('penilaian.mapel.kelas');

    Route::get('/penilaian/mapel/kelas/{kelasId}/siswa/search', [
        \App\Http\Controllers\Admin\PenilaianMapelController::class,
        'searchSiswa'
    ])->name('penilaian.mapel.siswa.search');

    Route::get('/penilaian/mapel/kelas/{kelasId}/mapel/{mapelId}', [
        \App\Http\Controllers\Admin\PenilaianMapelController::class,
        'mapel'
    ])->name('penilaian.mapel.mapel');

    Route::get('/penilaian/mapel/kelas/{kelasId}/mapel/{mapelId}/create', [
        \App\Http\Controllers\Admin\PenilaianMapelController::class,
        'create'
    ])->name('penilaian.mapel.create');

    Route::post('/penilaian/mapel/kelas/{kelasId}/mapel/{mapelId}', [
        \App\Http\Controllers\Admin\PenilaianMapelController::class,
        'store'
    ])->name('penilaian.mapel.store');

    Route::get('/penilaian/mapel/kelas/{kelasId}/mapel/{mapelId}/{id}/edit', [
        \App\Http\Controllers\Admin\PenilaianMapelController::class,
        'edit'
    ])->name('penilaian.mapel.edit');

    Route::put('/penilaian/mapel/kelas/{kelasId}/mapel/{mapelId}/{id}', [
        \App\Http\Controllers\Admin\PenilaianMapelController::class,
        'update'
    ])->name('penilaian.mapel.update');

    Route::delete('/penilaian/mapel/kelas/{kelasId}/mapel/{mapelId}/{id}', [
        \App\Http\Controllers\Admin\PenilaianMapelController::class,
        'destroy'
    ])->name('penilaian.mapel.destroy');



    Route::get(
        '/penilaian/pjbl',
        [
            PenilaianPjblController::class,
            'index'
        ]
    )->name('penilaian.pjbl.index');



    Route::get(
        '/penilaian/pjbl/kelas/{kelasId}',
        [
            PenilaianPjblController::class,
            'kelas'
        ]
    )->name('penilaian.pjbl.kelas');



    Route::get(
        '/penilaian/pjbl/kelas/{kelasId}/pjbl/{pjblId}',
        [
            PenilaianPjblController::class,
            'penilaian'
        ]
    )->name('penilaian.pjbl.penilaian');



    Route::get(
        '/penilaian/pjbl/kelas/{kelasId}/pjbl/{pjblId}/create',
        [
            PenilaianPjblController::class,
            'create'
        ]
    )->name('penilaian.pjbl.create');

    Route::get(
        '/penilaian/pjbl/waktu/edit',
        [PenilaianPjblController::class, 'waktuEdit']
    )->name('penilaian.pjbl.waktu.edit');

    Route::put(
        '/penilaian/pjbl/waktu',
        [PenilaianPjblController::class, 'waktuUpdate']
    )->name('penilaian.pjbl.waktu.update');



    Route::post(
        '/penilaian/pjbl/kelas/{kelasId}/pjbl/{pjblId}',
        [
            PenilaianPjblController::class,
            'store'
        ]
    )->name('penilaian.pjbl.store');



    Route::get(
        '/penilaian/pjbl/kelas/{kelasId}/pjbl/{pjblId}/{id}/edit',
        [
            PenilaianPjblController::class,
            'edit'
        ]
    )->name('penilaian.pjbl.edit');



    Route::put(
        '/penilaian/pjbl/kelas/{kelasId}/pjbl/{pjblId}/{id}',
        [
            PenilaianPjblController::class,
            'update'
        ]
    )->name('penilaian.pjbl.update');



    Route::delete(
        '/penilaian/pjbl/kelas/{kelasId}/pjbl/{pjblId}/{id}',
        [
            PenilaianPjblController::class,
            'destroy'
        ]
    )->name('penilaian.pjbl.destroy');



    Route::get(
        '/absensi',
        [AbsensiController::class, 'index']
    )->name('absensi.index');

    Route::get(
        '/absensi/{id}',
        [AbsensiController::class, 'show']
    )->name('absensi.show');




    Route::get(
        '/sakit',
        [SakitController::class, 'index']
    )->name('sakit.index');

    Route::get(
        '/sakit/{id}',
        [SakitController::class, 'show']
    )->name('sakit.show');




    Route::get(
        '/izin-keluar',
        [IzinKeluarController::class, 'index']
    )->name('izin-keluar.index');

    Route::get(
        '/izin-keluar/{id}',
        [IzinKeluarController::class, 'show']
    )->name('izin-keluar.show');




    Route::get(
        '/izin-pulang',
        [IzinPulangController::class, 'index']
    )->name('izin-pulang.index');

    Route::get(
        '/izin-pulang/{id}',
        [IzinPulangController::class, 'show']
    )->name('izin-pulang.show');




    Route::get(
        '/dispen',
        [DispenController::class, 'index']
    )->name('dispen.index');

    Route::get(
        '/dispen/{id}',
        [DispenController::class, 'show']
    )->name('dispen.show');
});

Route::get('/guru/jadwal', [JadwalController::class, 'index'])
    ->middleware('auth')
    ->name('guru.jadwal.index');

Route::middleware(['auth'])->group(function () {

    Route::get(
        '/guru/penilaian-pjbl',
        [GuruPenilaianPjblController::class, 'index']
    )->name('guru.penilaian-pjbl.index');

    Route::get(
        '/guru/penilaian-pjbl/{pjbl}/nilai',
        [GuruPenilaianPjblController::class, 'nilai']
    )->name('guru.penilaian-pjbl.nilai');

    Route::get(
        '/guru/penilaian-pjbl/riwayat',
        [GuruPenilaianPjblController::class, 'riwayat']
    )->name('guru.penilaian-pjbl.riwayat');

    Route::get(
        '/guru/penilaian-pjbl/riwayat/{penguji}/detail',
        [GuruPenilaianPjblController::class, 'riwayatDetail']
    )->name('guru.penilaian-pjbl.riwayat.detail');

    Route::post(
        '/guru/penilaian-pjbl/{pjbl}/nilai',
        [GuruPenilaianPjblController::class, 'simpan']
    )->name('guru.penilaian-pjbl.simpan');


    Route::get(
        '/guru/absen',
        [SesiAbsensiController::class, 'index']
    )->name('absensi.index');

    Route::get(
        '/guru/absen/{jadwal}',
        [SesiAbsensiController::class, 'show']
    )->name('absensi.show');

    Route::post(
        '/guru/absen/{jadwal}/buka',
        [SesiAbsensiController::class, 'buka']
    )->name('absensi.buka');
});





Route::middleware(['auth'])->group(function () {
    Route::get('/siswa/jadwal', [SiswaJadwalPelajaranController::class, 'index'])
        ->name('siswa.jadwal.index');

    Route::get('/siswa/jadwal/export/excel', [JadwalpelajaranController::class, 'exportExcel'])
        ->name('siswa.jadwal.export_excel');

    Route::get('/siswa/jadwal/export/pdf', [JadwalpelajaranController::class, 'exportPdf'])
        ->name('siswa.jadwal.export_pdf');

    Route::get('/siswa/nilai', [\App\Http\Controllers\Siswa\NilaiController::class, 'index'])
        ->name('siswa.nilai.index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/siswa/absensi', [SiswaAbsensiController::class, 'index'])
        ->name('siswa.absensi.index');
    Route::post('/siswa/absensi', [SiswaAbsensiController::class, 'store'])
        ->name('siswa.absensi.submit');
});

Route::middleware(['auth'])->prefix('siswa')->name('siswa.')->group(function () {

    Route::get('/perizinan', [PerizinanController::class, 'index'])
        ->name('perizinan.index');

    Route::get('/perizinan/create', [PerizinanController::class, 'create'])
        ->name('perizinan.create');

    Route::post('/perizinan', [PerizinanController::class, 'store'])
        ->name('perizinan.store');

    Route::get('/perizinan/{id}/edit', [PerizinanController::class, 'edit'])
        ->name('perizinan.edit');

    Route::put('/perizinan/{id}', [PerizinanController::class, 'update'])
        ->name('perizinan.update');

    Route::delete('/perizinan/{id}', [PerizinanController::class, 'destroy'])
        ->name('perizinan.destroy');
});
Route::middleware(['auth'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {

        Route::get(
            '/dispen',
            [SiswaDispenController::class, 'index']
        )->name('dispen.index');

        Route::get(
            '/dispen/create',
            [SiswaDispenController::class, 'create']
        )->name('dispen.create');

        Route::get(
            '/dispen/{id}/edit',
            [SiswaDispenController::class, 'edit']
        )->name('dispen.edit');

        Route::post(
            '/dispen',
            [SiswaDispenController::class, 'store']
        )->name('dispen.store');

        Route::put(
            '/dispen/{id}',
            [SiswaDispenController::class, 'update']
        )->name('dispen.update');

        Route::get(
            '/dispen/{id}',
            [SiswaDispenController::class, 'show']
        )->name('dispen.show');
    });
