<?php

declare(strict_types=1);

namespace Hutech\Services;

use Hutech\Repositories\RoleRepository;

readonly class RoleService
{
    public function __construct(protected RoleRepository $roleRepository)
    {
    }

    public function getRoleById($id): object
    {
        return $this->roleRepository->getRoleById($id);
    }
}