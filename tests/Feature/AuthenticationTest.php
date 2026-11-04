<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('SIM P3M PKTJ');
    }

    public function test_admin_can_authenticate_and_redirects_to_admin_dashboard(): void
    {
        $response = $this->post('/login', [
            'login' => 'admin@pktj.ac.id',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/admin/dashboard');
    }

    public function test_dosen_can_authenticate_and_redirects_to_dosen_dashboard(): void
    {
        $response = $this->post('/login', [
            'login' => 'dosen@pktj.ac.id',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dosen/dashboard');
    }

    public function test_reviewer_can_authenticate_and_redirects_to_reviewer_dashboard(): void
    {
        $response = $this->post('/login', [
            'login' => 'reviewer@pktj.ac.id',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/reviewer/dashboard');
    }

    public function test_user_can_authenticate_using_nidn_nip(): void
    {
        $response = $this->post('/login', [
            'login' => '0612048001',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dosen/dashboard');
    }

    public function test_deactivated_user_cannot_authenticate(): void
    {
        $user = User::where('email', 'dosen@pktj.ac.id')->first();
        $user->update(['status_aktif' => false]);

        $response = $this->post('/login', [
            'login' => 'dosen@pktj.ac.id',
            'password' => 'password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors(['login']);
    }

    public function test_users_cannot_authenticate_with_invalid_password(): void
    {
        $response = $this->post('/login', [
            'login' => 'admin@pktj.ac.id',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_user_can_logout(): void
    {
        $user = User::where('role', 'dosen')->first();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/login');
    }

    public function test_dosen_accessing_admin_area_is_redirected_to_dosen_dashboard(): void
    {
        $dosen = User::where('role', 'dosen')->first();

        $response = $this->actingAs($dosen)->get('/admin/dashboard');

        $response->assertRedirect('/dosen/dashboard');
    }

    public function test_authenticated_admin_visiting_login_is_redirected_to_admin_dashboard(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/login');

        $response->assertRedirect('/admin/dashboard');
    }

    public function test_authenticated_dosen_visiting_login_is_redirected_to_dosen_dashboard(): void
    {
        $dosen = User::where('role', 'dosen')->first();

        $response = $this->actingAs($dosen)->get('/login');

        $response->assertRedirect('/dosen/dashboard');
    }

    public function test_authenticated_reviewer_visiting_login_is_redirected_to_reviewer_dashboard(): void
    {
        $reviewer = User::where('role', 'reviewer')->first();

        $response = $this->actingAs($reviewer)->get('/login');

        $response->assertRedirect('/reviewer/dashboard');
    }
}
