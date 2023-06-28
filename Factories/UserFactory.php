<?php

declare(strict_types=1);

namespace Hutech\Factories;

use Hutech\Models\User;

readonly class UserFactory
{
    public static function create($id, $full_name, $email, $password, $is_verify = 0): User
    {
        return new User($id, $full_name, $email, $password, (int)$is_verify);
    }
}