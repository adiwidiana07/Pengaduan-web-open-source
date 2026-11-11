<?php

namespace Database\Seeders;

use App\Models\Aspiration;
use App\Models\Category;
use App\Models\User;
use App\Support\AnonymousIdentity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

// Skenario uji ambang laporan: satu aspirasi dengan tepat 50 laporan.
class ReportThresholdSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['nama_kategori' => 'Lingkungan'],
            ['deskripsi' => 'Aspirasi seputar lingkungan dan fasilitas umum.']
        );

        // owner_token tidak mass-assignable, jadi lewat forceFill.
        // Buat user dulu: #1 jadi penulis aspirasi, sisanya 49 pelapor anonim.
        $users = User::factory()->count(50)->create();

        // author_hash tidak mass-assignable, jadi lewat forceFill.
        $aspiration = (new Aspiration)->forceFill([
            'category_id' => $category->id,
            'judul' => 'Uji ambang laporan: papan informasi rusak',
            'isi' => 'Papan informasi di taman kota sudah rusak sejak lama dan belum diperbaiki.',
            'author_hash' => AnonymousIdentity::authorHash($users[0]),
            'upvote' => 12,
            'downvote' => 3,
        ]);
        $aspiration->save();

        // (aspiration_id, reporter_hash) unik, jadi butuh 50 user berbeda
        // untuk mewakili 50 pelapor anonim.
        $reasons = array_keys(config('pengaduan.report_reasons'));

        $users->each(function (User $user, int $i) use ($aspiration, $reasons) {
            $aspiration->reports()->create([
                'reporter_hash' => AnonymousIdentity::reporterHash($user),
                'alasan' => Arr::random($reasons),
                'catatan' => $i % 3 === 0 ? 'Contoh catatan pelapor #'.($i + 1) : null,
            ]);
        });

        $this->command?->info(
            'Aspirasi #'.$aspiration->id.' kini punya '.$aspiration->reports()->count().' laporan.'
        );
    }
}
