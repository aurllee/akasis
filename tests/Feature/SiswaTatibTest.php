<?php

namespace Tests\Feature;

use Tests\TestCase;

class SiswaTatibTest extends TestCase
{
    public function test_rekap_pelanggaran_requires_authentication(): void
    {
        $this->get('/siswa/tatib')
            ->assertRedirect('/login');
    }
}
