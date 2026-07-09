<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryCrudTest extends TestCase
{
    use RefreshDatabase;

    private $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    public function test_admin_can_store_category(): void
    {
        $response = $this->actingAs($this->admin)->post('/dashboard/kategori', [
            'nama_kategori' => 'Kategori Baru',
            'deskripsi' => 'Deskripsi Kategori Baru',
        ]);

        $response->assertRedirect('/dashboard/kategori');
        $this->assertDatabaseHas('categories', [
            'nama_kategori' => 'Kategori Baru',
        ]);
    }

    public function test_admin_can_update_category(): void
    {
        $category = Category::create([
            'nama_kategori' => 'Kategori Lama',
            'deskripsi' => 'Deskripsi Lama',
        ]);

        $response = $this->actingAs($this->admin)->put("/dashboard/kategori/{$category->id}", [
            'nama_kategori' => 'Kategori Baru',
            'deskripsi' => 'Deskripsi Baru',
        ]);

        $response->assertRedirect('/dashboard/kategori');
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'nama_kategori' => 'Kategori Baru',
        ]);
    }

    public function test_admin_can_delete_category(): void
    {
        $category = Category::create([
            'nama_kategori' => 'Kategori Hapus',
        ]);

        $response = $this->actingAs($this->admin)->delete("/dashboard/kategori/{$category->id}");

        $response->assertRedirect('/dashboard/kategori');
        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }
}
