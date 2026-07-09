<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test guest cannot access dashboard.
     */
    public function test_guest_is_redirected_to_login()
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    /**
     * Test login page loads successfully.
     */
    public function test_login_page_loads()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Masuk');
    }

    /**
     * Test admin can login with valid credentials.
     */
    public function test_admin_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'admin@pengaduan.id',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@pengaduan.id',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test admin cannot login with invalid credentials.
     */
    public function test_admin_cannot_login_with_invalid_credentials()
    {
        User::factory()->create([
            'email' => 'admin@pengaduan.id',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@pengaduan.id',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Test logged in admin can logout.
     */
    public function test_logged_in_admin_can_logout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    /**
     * Test authenticated admin can access dashboard routes.
     */
    public function test_authenticated_admin_can_access_dashboard_routes()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('/dashboard/kategori');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('/dashboard/statistik');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('/dashboard/profil');
        $response->assertStatus(200);
    }
}
