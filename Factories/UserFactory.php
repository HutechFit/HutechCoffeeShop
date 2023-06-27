<?php

declare(strict_types=1);

namespace Hutech\Factories;

use Hutech\Models\User;

readonly class UserFactory
{
    public static function create($id, $full_name, $email, $password, $is_verify = false): User
    {
        return new User($id, $full_name, $email, $password, (bool) $is_verify);
    }
}