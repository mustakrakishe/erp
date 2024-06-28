<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function create(User $user): bool
    {
        return in_array($user->role, [
            User::ROLE_ROOT,
            User::ROLE_ADMIN,
            User::ROLE_TEAMLEAD,
        ]);
    }

    public function have(User $user): bool
    {
        return in_array($user->role, [
            User::ROLE_ROOT,
            User::ROLE_ADMIN,
            User::ROLE_TEAMLEAD,
        ]);
    }
}
