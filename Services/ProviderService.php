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
}