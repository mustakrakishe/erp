<?php

namespace App\Policies;

use App\Models\User;
use App\Services\UserService;

class UserPolicy
{
    public function __construct(
        protected readonly UserService $userService,
    ) {
    }

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

    public function see(User $user, User $userToSee): bool
    {
        return $user->is($userToSee)
            || $this->userService->containsInSubordinateTree($user, $userToSee);
    }

    public function update(User $user, User $userToUpdate): bool
    {
        $hasRightRole = in_array($user->role, [
            User::ROLE_ROOT,
            User::ROLE_ADMIN,
            User::ROLE_TEAMLEAD,
        ]);

        if (!$hasRightRole) {
            return false;
        }

        return $user->is($userToUpdate)
            || $this->userService->containsInSubordinateTree($user, $userToUpdate);
    }

    public function delete(User $user, User $userToDelete): bool
    {
        $hasRightRole = in_array($user->role, [
            User::ROLE_ROOT,
            User::ROLE_ADMIN,
            User::ROLE_TEAMLEAD,
        ]);

        if (!$hasRightRole) {
            return false;
        }

        return $this->userService->containsInSubordinateTree($user, $userToDelete)
            && $userToDelete->subordinates()->doesntExist();
    }
}
