<?php

namespace Tests\Feature;

use App\Models\Aspiration;
use App\Models\Category;
use App\Models\User;
use App\Support\AnonymousIdentity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AspirationEnhancementsTest extends TestCase
{
    use RefreshDatabase;

    private Category $category;

    private User $owner;

    private Aspiration $aspiration;

    protected function setUp(): void
    {
        parent::setUp();

        $this->category = Category::create(['nama_kategori' => 'Layanan']);
        $this->owner = User::factory()->create();

        $this->aspiration = new Aspiration([
            'judul' => 'Judul Aspirasi',
            'isi' => 'Isi detail aspirasi publik.',
            'category_id' => $this->category->id,
        ]);
        $this->aspiration->author_hash = AnonymousIdentity::authorHash($this->owner);
        $this->aspiration->save();
    }

    public function test_user_can_upvote_and_downvote_aspiration(): void
    {
        $this->post("/aspirasi/{$this->aspiration->id}/vote", ['vote_type' => 'upvote'])->assertRedirect();
        $this->assertEquals(1, $this->aspiration->fresh()->upvote);

        // Same vote type again cancels it.
        $this->post("/aspirasi/{$this->aspiration->id}/vote", ['vote_type' => 'upvote'])->assertRedirect();
        $this->assertEquals(0, $this->aspiration->fresh()->upvote);

        $this->post("/aspirasi/{$this->aspiration->id}/vote", ['vote_type' => 'downvote'])->assertRedirect();
        $this->assertEquals(0, $this->aspiration->fresh()->upvote);
        $this->assertEquals(1, $this->aspiration->fresh()->downvote);
    }

    public function test_logged_in_user_can_comment_on_aspiration(): void
    {
        $this->actingAs($this->owner)->post("/aspirasi/{$this->aspiration->id}/comment", ['isi' => 'Komentar test publik.'])->assertRedirect();

        $this->assertDatabaseHas('comments', [
            'aspiration_id' => $this->aspiration->id,
            'isi' => 'Komentar test publik.',
        ]);
    }

    public function test_owner_can_edit_and_delete_own_aspiration(): void
    {
        $this->actingAs($this->owner)->get("/aspirasi/{$this->aspiration->id}/edit")->assertOk();

        $this->actingAs($this->owner)->put("/aspirasi/{$this->aspiration->id}", [
            'judul' => 'Judul Terupdate',
            'isi' => 'Isi Terupdate',
            'category_id' => $this->category->id,
        ])->assertRedirect("/aspirasi/{$this->aspiration->id}");

        $this->assertDatabaseHas('aspirations', ['id' => $this->aspiration->id, 'judul' => 'Judul Terupdate']);

        $this->actingAs($this->owner)->delete("/aspirasi/{$this->aspiration->id}")->assertRedirect('/my-aspirations');
        $this->assertDatabaseMissing('aspirations', ['id' => $this->aspiration->id]);
    }

    public function test_other_user_cannot_edit_or_delete(): void
    {
        $stranger = User::factory()->create();

        $this->actingAs($stranger)->get("/aspirasi/{$this->aspiration->id}/edit")->assertForbidden();
        $this->actingAs($stranger)->put("/aspirasi/{$this->aspiration->id}", [
            'judul' => 'Dibajak',
            'isi' => 'Dibajak',
            'category_id' => $this->category->id,
        ])->assertForbidden();
        $this->actingAs($stranger)->delete("/aspirasi/{$this->aspiration->id}")->assertForbidden();

        $this->assertDatabaseHas('aspirations', ['id' => $this->aspiration->id, 'judul' => 'Judul Aspirasi']);
    }

    public function test_guest_is_redirected_to_login_for_write_actions(): void
    {
        $this->get('/aspirasi/create')->assertRedirect('/login');
        $this->get("/aspirasi/{$this->aspiration->id}/edit")->assertRedirect('/login');
        $this->delete("/aspirasi/{$this->aspiration->id}")->assertRedirect('/login');
        $this->get('/my-aspirations')->assertRedirect('/login');
    }

    public function test_my_aspirations_lists_only_own_aspirations(): void
    {
        $stranger = User::factory()->create();
        $other = new Aspiration(['judul' => 'Milik orang lain', 'isi' => 'x', 'category_id' => $this->category->id]);
        $other->author_hash = AnonymousIdentity::authorHash($stranger);
        $other->save();

        $this->actingAs($this->owner)->get('/my-aspirations')
            ->assertOk()
            ->assertSee('Judul Aspirasi')
            ->assertDontSee('Milik orang lain');
    }
}
