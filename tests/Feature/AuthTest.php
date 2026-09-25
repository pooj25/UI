<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create([
            'email'    => 'admin@test.com',
            'password' => bcrypt('password123'),
            'role'     => 'admin',
        ]);
    }

    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    public function test_authenticated_user_redirected_from_login(): void
    {
        $user = $this->admin();
        $response = $this->actingAs($user)->get('/login');
        $response->assertRedirect(route('dashboard'));
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = $this->admin();
        $response = $this->post('/login', [
            'email'    => 'admin@test.com',
            'password' => 'password123',
        ]);
        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fails_with_invalid_credentials(): void
    {
        $this->admin();
        $response = $this->post('/login', [
            'email'    => 'admin@test.com',
            'password' => 'wrongpassword',
        ]);
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_requires_email(): void
    {
        $response = $this->post('/login', ['password' => 'password123']);
        $response->assertSessionHasErrors('email');
    }

    public function test_login_requires_valid_email_format(): void
    {
        $response = $this->post('/login', ['email' => 'notanemail', 'password' => 'password']);
        $response->assertSessionHasErrors('email');
    }

    public function test_unauthenticated_user_cannot_access_dashboard(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_unauthenticated_user_cannot_access_fabrics(): void
    {
        $response = $this->get('/fabrics');
        $response->assertRedirect('/login');
    }

    public function test_unauthenticated_user_cannot_access_lay_models(): void
    {
        $response = $this->get('/lay-models');
        $response->assertRedirect('/login');
    }

    public function test_user_can_logout(): void
    {
        $user = $this->admin();
        $this->actingAs($user)->post('/logout');
        $this->assertGuest();
    }

    public function test_dashboard_accessible_when_authenticated(): void
    {
        $user = $this->admin();
        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.index');
    }
}
