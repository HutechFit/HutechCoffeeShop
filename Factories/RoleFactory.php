<?php

declare(strict_types=1);

namespace Hutech\Factories;

use Hutech\Models\Role;

readonly class RoleFactory
{
    public static function create($id, $name): Role
    {
        return new Role((int) $id, $name);
    }
}