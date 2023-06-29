<?php

declare(strict_types=1);

namespace Hutech\Services;

use Hutech\Repositories\UserRoleRepository;

readonly class UserRoleService
{
    public function __construct(protected UserRoleRepository $userRoleRepository)
    {
    }

    public function add($user_role): void
    {
        $this->userRoleRepository->add($user_role);
    }

    public function getRoleByUserId($user_id): array
    {
        return $this->userRoleRepository->getRoleByUserId($user_id);
    }
}