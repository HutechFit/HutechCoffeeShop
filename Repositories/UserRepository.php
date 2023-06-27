<?php

declare(strict_types=1);

namespace Hutech\Repositories;

class UserRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('User');
    }

    public function add($user): void
    {
        $this->insert($user);
    }
}