<?php

namespace App\Support;

use App\Models\User;
use RuntimeException;

final class AnonymousIdentity
{
    public static function authorHash(User $user): string
    {
        return self::hash('author', $user);
    }

    // Purpose differs from authorHash so a report row cannot be joined to the reporter's own aspirations.
    public static function reporterHash(User $user): string
    {
        return self::hash('reporter', $user);
    }

    private static function hash(string $purpose, User $user): string
    {
        return hash_hmac('sha256', $purpose.'|'.$user->getKey(), self::key());
    }

    private static function key(): string
    {
        $key = (string) config('pengaduan.identity_key');

        if ($key === '') {
            throw new RuntimeException('IDENTITY_HASH_KEY belum diatur. Jalankan: php artisan identity:key');
        }

        return str_starts_with($key, 'base64:') ? base64_decode(substr($key, 7)) : $key;
    }
}
