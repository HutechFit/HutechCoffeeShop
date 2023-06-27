<?php

declare(strict_types=1);

namespace Hutech\Services;

use Hutech\Repositories\UserRepository;

readonly class UserService
{
    public function __construct(protected UserRepository $userRepository)
    {
    }

    public function add($user): void
    {
        $this->userRepository->add($user);
    }
}