<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public static function containsInSubordinateTree(User $superior, User $subordinate): bool
    {
        if ($superior->cannot('have', User::class)) {
            return false;
        }

        return $superior->is(
            static::findSuperiorWithRole($subordinate, $superior->role)
        );
    }

    protected static function findSuperiorWithRole(User $user, string $role): ?User
    {
        if ($user->superior_id === null) {
            return null;
        }

        if (!RoleService::hasHigherPriority($role, $user->role)) {
            return null;
        }

        $subordinate = clone $user;

        while ($subordinate->superior_id) {
            if ($subordinate->superior->role === $role) {
                return $subordinate->superior;
            }

            $subordinate = $subordinate->superior;
        }

        return null;
    }
}
