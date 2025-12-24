<?php

namespace App\Policies\Concerns;

use App\Models\User;

trait HandlesAdminAuthorization
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return null;
    }

    protected function isAdmin(User $user): bool
    {
        return $user->isAdmin();
    }
}
