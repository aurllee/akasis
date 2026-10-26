<?php

namespace Tests\Feature;


use Tests\TestCase;

class ExampleTest extends TestCase
{
    
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    
public function test_guru_index_renders_generated_account_credentials_from_session(): void
{
    $this->withSession([
        'username' => '123456789',
        'password_awal' => 'rahasia123',
    ]);

    $html = view('admin.master-data.guru.index', [
        'gurus' => new \Illuminate\Pagination\LengthAwarePaginator(
            collect([]),
            0,
            10,
            1,
            [
                'path' => '/',
                'pageName' => 'page',
            ]
        ),
    ])->render();

    $this->assertStringContainsString('Username:', $html);
    $this->assertStringContainsString('123456789', $html);
    $this->assertStringContainsString('rahasia123', $html);
}


public function test_tatib_create_requires_authentication(): void
{
    $response = $this->get('/tatib/data-pelanggaran/create');

    $response->assertRedirect('/login');
}


public function test_tatib_store_rejects_empty_form(): void
{
    $user = new \App\Models\User([
        'username' => 'tester',
        'role_id' => 1,
    ]);

    $response = $this->actingAs($user)
        ->from('/tatib/data-pelanggaran/create')
        ->post('/tatib/data-pelanggaran', []);

    $response->assertRedirect('/tatib/data-pelanggaran/create');
    $response->assertSessionHasErrors(['tanggal', 'siswa']);
}


public function test_tatib_student_search_returns_empty_for_short_query(): void
{
    $user = new \App\Models\User([
        'username' => 'tester',
        'role_id' => 1,
    ]);

    $response = $this->actingAs($user)
        ->getJson('/tatib/siswa/search?q=a');

    $response->assertOk();
    $response->assertExactJson([]);
}


public function test_tatib_student_search_returns_empty_for_unmatched_query(): void
{
    $user = new \App\Models\User([
        'username' => 'tester',
        'role_id' => 1,
    ]);

    $response = $this->actingAs($user)
        ->getJson('/tatib/siswa/search?q=zztesttidakada987');

    $response->assertOk();
    $response->assertExactJson([]);
}


}
