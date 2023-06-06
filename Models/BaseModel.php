<?php

declare(strict_types=1);

namespace Hutech\Models;

abstract class BaseModel
{
    public int $id;

    public function getId(): int
    {
        return $this->id;
    }
}
