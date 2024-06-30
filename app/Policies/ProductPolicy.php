<?php

namespace App\Policies;

use App\Models\User;

class ProductPolicy
{
    public function have(User $user): bool
    {
        return $user->role === User::ROLE_BUYER;
    }
}
