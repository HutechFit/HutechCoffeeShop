<?php

declare(strict_types=1);

namespace Hutech\Models;

class UserRole
{
    public string $user_id;
    public int $role_id;

    public function __construct(string $user_id, int $role_id)
    {
        $this->user_id = $user_id;
        $this->role_id = $role_id;
    }

    public function __destruct()
    {
        $this->user_id = '';
        $this->role_id = 0;
    }
}