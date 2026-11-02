<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        if (! $user || $user->role !== $role) {
            abort(403, $role === 'admin'
                ? 'Halaman ini khusus administrator.'
                : 'Fitur ini khusus akun masyarakat. Akun administrator tidak dapat membuat atau melaporkan aspirasi.');
        }

        return $next($request);
    }
}
