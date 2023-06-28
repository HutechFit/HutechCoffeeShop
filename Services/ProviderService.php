<?php

declare(strict_types=1);

namespace Hutech\Services;

use Hutech\Repositories\ProviderRepository;

readonly class ProviderService
{
    public function __construct(protected ProviderRepository $providerRepository)
    {
    }

    public function add($provider): void
    {
        $this->providerRepository->add($provider);
    }

    public function isExistUser($id, $token): bool
    {
        return $this->providerRepository->isExistUser($id, $token);
    }

    public function getProviderByEmail($email): object
    {
        return $this->providerRepository->getProviderByEmail($email);
    }
}