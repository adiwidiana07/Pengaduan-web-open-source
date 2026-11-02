<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class IdentityKeyCommand extends Command
{
    protected $signature = 'identity:key {--show : Tampilkan kunci tanpa menulis ke .env} {--force : Timpa kunci yang sudah ada}';

    protected $description = 'Buat IDENTITY_HASH_KEY untuk menyamarkan identitas penulis dan pelapor';

    public function handle(): int
    {
        $key = 'base64:'.base64_encode(random_bytes(32));

        if ($this->option('show')) {
            $this->line($key);

            return self::SUCCESS;
        }

        $path = $this->laravel->environmentFilePath();

        if (! is_file($path)) {
            $this->error('File .env tidak ditemukan.');

            return self::FAILURE;
        }

        $env = file_get_contents($path);
        $hasValue = preg_match('/^IDENTITY_HASH_KEY=(.+)$/m', $env, $match) && trim($match[1]) !== '';

        if ($hasValue && ! $this->option('force')) {
            $this->warn('IDENTITY_HASH_KEY sudah ada. Menggantinya membuat semua pengguna kehilangan akses ke aspirasi mereka.');
            $this->warn('Gunakan --force jika memang ingin menimpa.');

            return self::FAILURE;
        }

        $env = preg_match('/^IDENTITY_HASH_KEY=.*$/m', $env)
            ? preg_replace('/^IDENTITY_HASH_KEY=.*$/m', 'IDENTITY_HASH_KEY='.$key, $env)
            : rtrim($env).PHP_EOL.PHP_EOL.'IDENTITY_HASH_KEY='.$key.PHP_EOL;

        file_put_contents($path, $env);

        $this->info('IDENTITY_HASH_KEY berhasil dibuat. Simpan cadangannya di tempat aman.');

        return self::SUCCESS;
    }
}
