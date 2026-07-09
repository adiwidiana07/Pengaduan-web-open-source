<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AspirationPublicSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_can_submit_an_aspiration_and_be_redirected_to_the_public_index(): void
    {
        $category = Category::create([
            'nama_kategori' => 'Layanan',
            'deskripsi' => 'Test category',
        ]);

        $response = $this->post('/aspirasi', [
            'judul' => 'Aspirasi publik',
            'isi' => 'Isi aspirasi publik',
            'category_id' => $category->id,
        ]);

        $response->assertRedirectContains('/success');
        $this->assertDatabaseHas('aspirations', [
            'judul' => 'Aspirasi publik',
        ]);
    }
}
