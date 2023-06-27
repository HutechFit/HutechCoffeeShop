<?php

declare(strict_types=1);

namespace Hutech\Factories;

use Hutech\Models\Provider;

readonly class ProviderFactory
{
    public static function create($user_id, $name, $token, $description) : Provider
    {
        return new Provider($user_id, $name, $token, $description);
    }
}