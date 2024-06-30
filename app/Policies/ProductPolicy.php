<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use App\Services\UserService;

class ProductPolicy
{
    public function __construct(
        protected readonly UserService $userService,
    ) {
    }

    public function have(User $user): bool
    {
        return $user->role === User::ROLE_BUYER;
    }

    public function create(User $user): bool
    {
        return $user->role === User::ROLE_BUYER;
    }

    public function see(User $user, Product $product): bool
    {
        return $user->id === $product->owner_id
            || $this->userService->containsInSubordinateTree($user, $product->owner);
    }

    public function update(User $user, Product $product): bool
    {
        return $user->role === User::ROLE_BUYER
            && $user->id === $product->owner_id;
    }
}
