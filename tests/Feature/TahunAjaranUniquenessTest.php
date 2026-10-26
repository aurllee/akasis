<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class TahunAjaranUniquenessTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);
        DB::purge('sqlite');

        Schema::create('tahun_ajaran', function (Blueprint $table): void {
            $table->id();
            $table->string('tahun_ajaran', 9);
            $table->string('semester');
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    public function test_duplicate_year_and_semester_are_rejected(): void
    {
        $data = [
            'tahun_ajaran' => '2026/2027',
            'semester' => 'Ganjil',
        ];

        $this->post('/tahun-ajaran', $data)->assertRedirect('/tahun-ajaran');

        $this->from('/tahun-ajaran/create')
            ->post('/tahun-ajaran', $data)
            ->assertRedirect('/tahun-ajaran/create')
            ->assertSessionHasErrors([
                'tahun_ajaran' => 'Tahun ajaran dan semester tersebut sudah terdaftar.',
            ]);

        $this->assertDatabaseCount('tahun_ajaran', 1);
    }

    public function test_same_year_with_another_semester_is_allowed_and_update_can_keep_existing_pair(): void
    {
        $this->post('/tahun-ajaran', [
            'tahun_ajaran' => '2026/2027',
            'semester' => 'Ganjil',
        ])->assertRedirect('/tahun-ajaran');

        $this->put('/tahun-ajaran/1', [
            'tahun_ajaran' => '2026/2027',
            'semester' => 'Ganjil',
        ])->assertRedirect('/tahun-ajaran');

        $this->post('/tahun-ajaran', [
            'tahun_ajaran' => '2026/2027',
            'semester' => 'Genap',
        ])->assertRedirect('/tahun-ajaran');

        $this->assertDatabaseCount('tahun_ajaran', 2);
    }
}
