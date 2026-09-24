<?php

namespace Tests\Feature;

use Tests\TestCase;

class WaliKelasDashboardTest extends TestCase
{
    public function test_wali_kelas_dashboard_route_exists_and_shows_required_profile_info(): void
    {
        $this->assertNotNull(route('wali-kelas.dashboard'));

        $jadwalMengajar = collect([
            (object) [
                'kelas' => (object) [
                    'nama_kelas' => 'XII-1',
                    'tingkat' => 'XII',
                    'jurusan' => (object) ['nama_jurusan' => 'TKJ'],
                ],
                'mataPelajaran' => (object) ['nama_mapel' => 'Bahasa Indonesia'],
            ],
        ]);

        $html = view('wali-kelas.dashboard', [
            'guru' => (object) ['nama' => 'Sri Wahyuni'],
            'waliKelas' => collect([
                (object) [
                    'kelas' => (object) [
                        'tingkat' => 'XII',
                        'nama_kelas' => 'XII-1',
                        'jurusan' => (object) ['nama_jurusan' => 'TKJ'],
                    ],
                ],
            ]),
            'jadwalMengajar' => $jadwalMengajar,
            'username' => 'sriwahyuni',
        ])->render();

        $this->assertStringContainsString('Ganti Password', $html);
        $this->assertStringContainsString('sriwahyuni', $html);
        $this->assertStringContainsString('Sri Wahyuni', $html);
        $this->assertStringContainsString('Bahasa Indonesia', $html);
        $this->assertStringContainsString('Wali Kelas', $html);
    }

    public function test_wali_kelas_izin_tidak_masuk_view_uses_consistent_academic_ui(): void
    {
        $html = view('wali-kelas.sakit.index', [
            'data' => collect(),
        ])->render();

        $this->assertStringContainsString('Izin Tidak Masuk Siswa', $html);
        $this->assertStringContainsString('data-card-header', $html);
        $this->assertStringContainsString('status-badge', $html);
        $this->assertStringContainsString('Belum ada pengajuan izin tidak masuk siswa.', $html);
    }

    public function test_wali_kelas_izin_tidak_masuk_has_search_and_status_filter_controls(): void
    {
        $html = view('wali-kelas.sakit.index', [
            'data' => collect(),
        ])->render();

        $this->assertStringContainsString('name="search"', $html);
        $this->assertStringContainsString('name="status"', $html);
        $this->assertStringContainsString('Cari Siswa', $html);
    }
}
