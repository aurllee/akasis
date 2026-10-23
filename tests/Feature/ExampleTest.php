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
        $html = view('admin.master-data.guru.index', ['gurus' => collect([])])
            ->with('username', '123456789')
            ->with('password_awal', 'rahasia123')
            ->render();

        $this->assertStringContainsString('Username', $html);
        $this->assertStringContainsString('123456789', $html);
        $this->assertStringContainsString('rahasia123', $html);
    }
}
