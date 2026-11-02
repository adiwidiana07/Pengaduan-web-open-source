<?php

namespace Tests\Feature;

use App\Models\Aspiration;
use App\Models\Category;
use App\Models\User;
use App\Support\AnonymousIdentity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

// phpunit.xml sets REPORT_THRESHOLD=3 so the threshold is reachable in tests.
class ReportTest extends TestCase
{
    use RefreshDatabase;

    private User $author;

    private User $admin;

    private Aspiration $aspiration;

    protected function setUp(): void
    {
        parent::setUp();

        $this->author = User::factory()->create();
        $this->admin = User::factory()->admin()->create();
        $category = Category::create(['nama_kategori' => 'Layanan']);

        $this->aspiration = new Aspiration(['judul' => 'Aspirasi bermasalah', 'isi' => 'Isi', 'category_id' => $category->id]);
        $this->aspiration->author_hash = AnonymousIdentity::authorHash($this->author);
        $this->aspiration->save();
    }

    private function reportAs(User $user, string $alasan = 'spam')
    {
        return $this->actingAs($user)
            ->from("/aspirasi/{$this->aspiration->id}")
            ->post("/aspirasi/{$this->aspiration->id}/report", ['alasan' => $alasan, 'catatan' => 'Isinya iklan']);
    }

    public function test_user_can_report_once_and_reporter_is_stored_as_hash(): void
    {
        $reporter = User::factory()->create();

        $this->reportAs($reporter)->assertSessionHas('success');
        $this->reportAs($reporter)->assertSessionHas('error');

        $this->assertSame(1, $this->aspiration->reports()->count());
        $report = $this->aspiration->reports()->first();
        $this->assertSame(AnonymousIdentity::reporterHash($reporter), $report->reporter_hash);
        $this->assertArrayNotHasKey('reporter_hash', $report->toArray());
    }

    public function test_author_cannot_report_own_aspiration(): void
    {
        $this->reportAs($this->author)->assertSessionHas('error');
        $this->assertSame(0, $this->aspiration->reports()->count());
    }

    public function test_invalid_reason_is_rejected(): void
    {
        $this->reportAs(User::factory()->create(), 'bukan-alasan')->assertSessionHasErrors('alasan', null, 'report');
        $this->assertSame(0, $this->aspiration->reports()->count());
    }

    public function test_guest_and_admin_cannot_report(): void
    {
        $this->post("/aspirasi/{$this->aspiration->id}/report", ['alasan' => 'spam'])->assertRedirect('/login');
        $this->reportAs($this->admin)->assertForbidden();
    }

    public function test_admin_cannot_delete_below_threshold(): void
    {
        $this->reportAs(User::factory()->create());
        $this->reportAs(User::factory()->create());

        $this->actingAs($this->admin)
            ->from("/dashboard/aspirasi/{$this->aspiration->id}")
            ->delete("/dashboard/aspirasi/{$this->aspiration->id}")
            ->assertSessionHas('error');

        $this->assertModelExists($this->aspiration);
    }

    public function test_admin_can_delete_once_threshold_is_reached(): void
    {
        foreach (User::factory()->count(3)->create() as $reporter) {
            $this->reportAs($reporter);
        }

        $this->actingAs($this->admin)->get('/dashboard/laporan')->assertOk()->assertSee('Aspirasi bermasalah');

        $this->actingAs($this->admin)
            ->delete("/dashboard/aspirasi/{$this->aspiration->id}")
            ->assertRedirect('/dashboard/laporan');

        $this->assertModelMissing($this->aspiration);
        $this->assertDatabaseCount('reports', 0);
    }

    public function test_regular_user_cannot_use_admin_delete(): void
    {
        foreach (User::factory()->count(3)->create() as $reporter) {
            $this->reportAs($reporter);
        }

        $this->actingAs($this->author)->delete("/dashboard/aspirasi/{$this->aspiration->id}")->assertForbidden();
        $this->assertModelExists($this->aspiration);
    }

    public function test_admin_can_dismiss_reports(): void
    {
        $this->reportAs(User::factory()->create());

        $this->actingAs($this->admin)
            ->from('/dashboard/laporan')
            ->delete("/dashboard/laporan/{$this->aspiration->id}")
            ->assertRedirect('/dashboard/laporan');

        $this->assertSame(0, $this->aspiration->reports()->count());
        $this->assertModelExists($this->aspiration);
    }
}
