<?php

namespace Tests\Feature;

use App\Models\Aspiration;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    private Aspiration $aspiration;

    protected function setUp(): void
    {
        parent::setUp();

        $category = Category::create(['nama_kategori' => 'Layanan']);
        $this->aspiration = Aspiration::create(['judul' => 'Jalan berlubang', 'isi' => 'Isi', 'category_id' => $category->id]);
    }

    public function test_guest_can_read_aspiration_and_sees_login_and_register_buttons(): void
    {
        $this->get("/aspirasi/{$this->aspiration->id}")
            ->assertOk()
            ->assertSee('Masuk untuk ikut berdiskusi')
            ->assertSee(route('login'))
            ->assertSee(route('register'))
            ->assertDontSee('Kirim Komentar');
    }

    public function test_guest_cannot_comment(): void
    {
        $this->post("/aspirasi/{$this->aspiration->id}/comment", ['isi' => 'Halo'])->assertRedirect('/login');
        $this->assertDatabaseCount('comments', 0);
    }

    public function test_admin_cannot_comment(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->get("/aspirasi/{$this->aspiration->id}")->assertOk()->assertDontSee('Kirim Komentar');
        $this->actingAs($admin)->post("/aspirasi/{$this->aspiration->id}/comment", ['isi' => 'Halo'])->assertForbidden();
    }

    public function test_user_comment_gets_a_fresh_random_token_each_time(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post("/aspirasi/{$this->aspiration->id}/comment", ['isi' => 'Pertama'])->assertRedirect();
        $this->actingAs($user)->post("/aspirasi/{$this->aspiration->id}/comment", ['isi' => 'Kedua'])->assertRedirect();

        $tokens = Comment::pluck('owner_token')->map(fn ($t) => (string) $t);
        $this->assertCount(2, $tokens->unique());
        $this->assertFalse($tokens->contains((string) $user->id));
    }

    public function test_login_from_aspiration_page_returns_user_to_it(): void
    {
        User::factory()->create(['email' => 'warga@example.com']);

        $this->get("/aspirasi/{$this->aspiration->id}");
        $this->post('/login', ['email' => 'warga@example.com', 'password' => 'password'])
            ->assertRedirect("/aspirasi/{$this->aspiration->id}");
    }

    public function test_admin_login_after_viewing_aspiration_still_goes_to_dashboard(): void
    {
        User::factory()->admin()->create(['email' => 'admin@example.com']);

        $this->get("/aspirasi/{$this->aspiration->id}");
        $this->post('/login', ['email' => 'admin@example.com', 'password' => 'password'])
            ->assertRedirect('/dashboard');
    }

    public function test_register_from_aspiration_page_returns_user_to_it(): void
    {
        $this->get("/aspirasi/{$this->aspiration->id}");
        $this->post('/register', [
            'name' => 'Warga',
            'email' => 'baru@example.com',
            'password' => 'rahasia-kuat-123',
            'password_confirmation' => 'rahasia-kuat-123',
        ])->assertRedirect("/aspirasi/{$this->aspiration->id}");
    }
}
