<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $admin = User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@pengaduan.id')],
            [
                'name' => 'Administrator',
                'password' => bcrypt(env('ADMIN_PASSWORD', 'password')),
            ]
        );

        // role sengaja tidak mass-assignable, jadi diset langsung.
        $admin->forceFill(['role' => User::ROLE_ADMIN])->save();
    }
}
