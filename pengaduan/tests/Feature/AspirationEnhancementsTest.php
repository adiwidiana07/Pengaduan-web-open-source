<?php

namespace Tests\Feature;

use App\Models\Aspiration;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class AspirationEnhancementsTest extends TestCase
{
    use RefreshDatabase;

    private $category;
    private $aspiration;

    protected function setUp(): void
    {
        parent::setUp();

        $this->category = Category::create([
            'nama_kategori' => 'Layanan',
            'deskripsi' => 'Kategori Layanan',
        ]);

        $this->aspiration = Aspiration::create([
            'judul' => 'Judul Aspirasi',
            'isi' => 'Isi detail aspirasi publik.',
            'category_id' => $this->category->id,
            'owner_token' => Str::uuid(),
        ]);
    }

    public function test_user_can_upvote_and_downvote_aspiration(): void
    {
        // First upvote
        $response = $this->post("/aspirasi/{$this->aspiration->id}/vote", [
            'vote_type' => 'upvote',
        ]);

        $response->assertRedirect();
        $this->assertEquals(1, $this->aspiration->fresh()->upvote);
        $this->assertEquals(0, $this->aspiration->fresh()->downvote);

        // Toggle vote (same vote type cancels it)
        $response = $this->post("/aspirasi/{$this->aspiration->id}/vote", [
            'vote_type' => 'upvote',
        ]);

        $response->assertRedirect();
        $this->assertEquals(0, $this->aspiration->fresh()->upvote);

        // Switch to downvote
        $response = $this->post("/aspirasi/{$this->aspiration->id}/vote", [
            'vote_type' => 'downvote',
        ]);

        $response->assertRedirect();
        $this->assertEquals(0, $this->aspiration->fresh()->upvote);
        $this->assertEquals(1, $this->aspiration->fresh()->downvote);
    }

    public function test_user_can_comment_on_aspiration(): void
    {
        $response = $this->post("/aspirasi/{$this->aspiration->id}/comment", [
            'isi' => 'Komentar test publik.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('comments', [
            'aspiration_id' => $this->aspiration->id,
            'isi' => 'Komentar test publik.',
        ]);
    }

    public function test_owner_can_edit_and_delete_aspiration_with_valid_token(): void
    {
        $token = (string) $this->aspiration->owner_token;

        // Try editing with token
        $response = $this->get("/aspirasi/{$this->aspiration->id}/edit?token={$token}");
        $response->assertStatus(200);

        // Try updating
        $response = $this->put("/aspirasi/{$this->aspiration->id}", [
            'judul' => 'Judul Terupdate',
            'isi' => 'Isi Terupdate',
            'category_id' => $this->category->id,
            'token' => $token,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('aspirations', [
            'id' => $this->aspiration->id,
            'judul' => 'Judul Terupdate',
        ]);

        // Try deleting
        $response = $this->delete("/aspirasi/{$this->aspiration->id}", [
            'token' => $token,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseMissing('aspirations', [
            'id' => $this->aspiration->id,
        ]);
    }

    public function test_non_owner_cannot_edit_without_valid_token(): void
    {
        $response = $this->get("/aspirasi/{$this->aspiration->id}/edit?token=invalid-token");
        $response->assertRedirect();
        
        $response = $this->put("/aspirasi/{$this->aspiration->id}", [
            'judul' => 'Judul Terupdate',
            'isi' => 'Isi Terupdate',
            'category_id' => $this->category->id,
            'token' => 'invalid-token',
        ]);
        $response->assertRedirect();
        $this->assertDatabaseHas('aspirations', [
            'id' => $this->aspiration->id,
            'judul' => 'Judul Aspirasi', // not changed
        ]);
    }
}
