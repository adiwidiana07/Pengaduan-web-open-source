<?php

namespace App\Policies;

use App\Models\Aspiration;
use App\Models\User;
use App\Support\AnonymousIdentity;

class AspirationPolicy
{
    public function create(User $user): bool
    {
        return ! $user->isAdmin();
    }

    public function update(User $user, Aspiration $aspiration): bool
    {
        return ! $user->isAdmin() && $aspiration->isAuthoredBy($user);
    }

    public function delete(User $user, Aspiration $aspiration): bool
    {
        return $this->update($user, $aspiration);
    }

    public function report(User $user, Aspiration $aspiration): bool
    {
        return ! $user->isAdmin()
            && ! $aspiration->isAuthoredBy($user)
            && ! $aspiration->reports()->where('reporter_hash', AnonymousIdentity::reporterHash($user))->exists();
    }

    // Admin hanya boleh menghapus setelah laporan mencapai ambang, bukan atas selera sendiri.
    public function moderate(User $user, Aspiration $aspiration): bool
    {
        return $user->isAdmin() && $aspiration->reachedReportThreshold();
    }

    public function dismissReports(User $user, Aspiration $aspiration): bool
    {
        return $user->isAdmin();
    }
}
