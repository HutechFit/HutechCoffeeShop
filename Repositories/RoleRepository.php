<?php

declare(strict_types=1);

namespace Hutech\Repositories;

class RoleRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('Role');
    }

    public function getRoleById($id): object
    {
        return $this->getById($id);
    }
}