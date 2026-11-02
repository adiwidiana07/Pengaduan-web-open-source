<?php

namespace Tests\Feature;

use App\Models\Aspiration;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use App\Support\AnonymousIdentity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnonymityAndRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_creates_a_regular_user_even_if_role_is_posted(): void
    {
        $this->post('/register', [
            'name' => 'Warga',
            'email' => 'warga@example.com',
            'password' => 'rahasia-kuat-123',
            'password_confirmation' => 'rahasia-kuat-123',
            'role' => 'admin',
        ])->assertRedirect('/my-aspirations');

        $user = User::where('email', 'warga@example.com')->firstOrFail();
        $this->assertSame(User::ROLE_USER, $user->role);
        $this->assertAuthenticatedAs($user);
    }

    public function test_regular_user_login_goes_to_my_aspirations(): void
    {
        User::factory()->create(['email' => 'warga@example.com']);

        $this->post('/login', ['email' => 'warga@example.com', 'password' => 'password'])
            ->assertRedirect('/my-aspirations');
    }

    public function test_regular_user_cannot_access_dashboard(): void
    {
        $user = User::factory()->create();

        foreach (['/dashboard', '/dashboard/aspirasi', '/dashboard/laporan', '/dashboard/kategori', '/dashboard/statistik'] as $url) {
            $this->actingAs($user)->get($url)->assertForbidden();
        }
    }

    public function test_admin_pages_never_show_author_identity(): void
    {
        $author = User::factory()->create(['name' => 'Budi Penulis Rahasia', 'email' => 'budi.rahasia@example.com']);
        $admin = User::factory()->admin()->create();
        $category = Category::create(['nama_kategori' => 'Layanan']);

        $aspiration = new Aspiration(['judul' => 'Jalan rusak', 'isi' => 'Tolong diperbaiki', 'category_id' => $category->id]);
        $aspiration->author_hash = AnonymousIdentity::authorHash($author);
        $aspiration->save();
        Comment::create(['aspiration_id' => $aspiration->id, 'isi' => 'Setuju', 'owner_token' => 'b3a1c2d4-0000-4000-8000-000000000000']);

        $hash = $aspiration->author_hash;
        $pages = ['/dashboard', '/dashboard/aspirasi', "/dashboard/aspirasi/{$aspiration->id}", '/dashboard/laporan'];

        foreach ($pages as $url) {
            $this->actingAs($admin)->get($url)
                ->assertOk()
                ->assertDontSee('Budi Penulis Rahasia')
                ->assertDontSee('budi.rahasia@example.com')
                ->assertDontSee($hash)
                ->assertDontSee(substr($hash, 0, 8))
                ->assertDontSee('b3a1c2d4');
        }

        $this->assertArrayNotHasKey('author_hash', $aspiration->toArray());
    }

    public function test_public_page_does_not_leak_any_token_prefix(): void
    {
        $author = User::factory()->create();
        $category = Category::create(['nama_kategori' => 'Layanan']);
        $aspiration = new Aspiration(['judul' => 'Lampu jalan', 'isi' => 'Mati', 'category_id' => $category->id]);
        $aspiration->author_hash = AnonymousIdentity::authorHash($author);
        $aspiration->save();

        $this->get("/aspirasi/{$aspiration->id}")
            ->assertOk()
            ->assertDontSee(substr($aspiration->author_hash, 0, 8));
    }

    public function test_author_and_reporter_hashes_differ_for_the_same_user(): void
    {
        $user = User::factory()->create();

        $this->assertNotSame(AnonymousIdentity::authorHash($user), AnonymousIdentity::reporterHash($user));
    }

    public function test_failed_logins_for_one_email_do_not_block_another_email_on_same_ip(): void
    {
        User::factory()->create(['email' => 'b@example.com']);

        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', ['email' => 'a@example.com', 'password' => 'salah']);
        }
        $this->post('/login', ['email' => 'a@example.com', 'password' => 'salah'])->assertStatus(429);

        $this->post('/login', ['email' => 'b@example.com', 'password' => 'password'])->assertRedirect('/my-aspirations');
    }
}
