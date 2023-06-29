<?php

declare(strict_types=1);

namespace Hutech\Factories;

use Hutech\Models\UserRole;

readonly class UserRoleFactory
{
    public static function create($user_id, $role_id): UserRole
    {
        return new UserRole($user_id, (int) $role_id);
    }
}