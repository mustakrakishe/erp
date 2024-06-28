<?php

namespace App\Services;

use App\Models\User;

class RoleService
{
    public static function getSubordinateRole(string $role): ?string
    {
        $roleId = array_search($role, User::ROLES_ALL, true);

        return User::ROLES_ALL[$roleId + 1] ?? null;
    }

    public static function hasHigherPriority(string $roleA, string $roleB): bool
    {
        $roleIds = array_flip(User::ROLES_ALL);

        return $roleIds[$roleA] < $roleIds[$roleB];
    }
}
