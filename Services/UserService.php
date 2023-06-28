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

    public function getUser($email): ?object
    {
        return $this->userRepository->getUser($email);
    }

    public function setVerify($id): void
    {
        $this->userRepository->setVerify($id);
    }
}