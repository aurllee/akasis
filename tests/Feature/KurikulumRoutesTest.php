<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Guru;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class KurikulumRoutesTest extends TestCase
{
    public function test_kurikulum_dashboard_route_exists(): void
    {
        $this->assertTrue(Route::has('kurikulum.dashboard'));
    }

    public function test_dashboard_can_query_guru_with_user_account(): void
    {
        $sql = Guru::whereHas('user')->toSql();

        $this->assertStringContainsString('users', $sql);
        $this->assertStringContainsString('guru_id', $sql);
    }

    public function test_role_eight_user_is_redirected_to_kurikulum_dashboard(): void
    {
        $user = new User([
            'username' => 'kurikulum',
            'role_id' => 8,
        ]);

        Auth::shouldReceive('attempt')
            ->once()
            ->with(['username' => 'kurikulum', 'password' => 'secret'])
            ->andReturnTrue();
        Auth::shouldReceive('user')->zeroOrMoreTimes()->andReturn($user);

        $this->post(route('login.proses'), [
            'username' => 'kurikulum',
            'password' => 'secret',
        ])->assertRedirect(route('kurikulum.dashboard'));
    }

    public function test_kurikulum_sidebar_alias_routes_exist(): void
    {
        $this->assertTrue(Route::has('kurikulum.pjbl.index'));
        $this->assertTrue(Route::has('kurikulum.kbm.index'));
        $this->assertTrue(Route::has('kurikulum.rapor.index'));
    }
}
