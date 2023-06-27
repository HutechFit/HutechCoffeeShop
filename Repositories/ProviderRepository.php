<?php

declare(strict_types=1);

namespace Hutech\Repositories;

class ProviderRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('Provider');
    }

    public function add($provider): void
    {
        $this->insert($provider);
    }
}