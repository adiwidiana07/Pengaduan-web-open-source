<?php

namespace Tests\Feature;

use App\Models\Aspiration;
use App\Models\Category;
use App\Models\User;
use App\Support\AnonymousIdentity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AspirationPublicSubmissionTest extends TestCase
{
    use RefreshDatabase;

    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = Category::create(['nama_kategori' => 'Layanan']);
    }

    public function test_logged_in_user_can_submit_and_it_is_stored_without_user_id(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/aspirasi', [
            'judul' => 'Aspirasi publik',
            'isi' => 'Isi aspirasi publik',
            'category_id' => $this->category->id,
        ]);

        $aspiration = Aspiration::firstOrFail();
        $response->assertRedirect("/aspirasi/{$aspiration->id}");

        $this->assertFalse(Schema::hasColumn('aspirations', 'user_id'));
        $this->assertSame(AnonymousIdentity::authorHash($user), $aspiration->author_hash);
        $this->assertNotSame((string) $user->id, $aspiration->author_hash);
    }

    public function test_guest_cannot_submit(): void
    {
        $this->post('/aspirasi', [
            'judul' => 'Aspirasi tamu',
            'isi' => 'Isi',
            'category_id' => $this->category->id,
        ])->assertRedirect('/login');

        $this->assertDatabaseCount('aspirations', 0);
    }

    public function test_admin_cannot_create_aspirations(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->get('/aspirasi/create')->assertForbidden();
        $this->actingAs($admin)->post('/aspirasi', [
            'judul' => 'x',
            'isi' => 'x',
            'category_id' => $this->category->id,
        ])->assertForbidden();
    }
}
