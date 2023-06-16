<?php

declare(strict_types=1);

namespace Hutech\Models;

abstract class BaseModel
{
    public ?int $id;

    public function __construct(?int $id)
    {
        $this->id = $id;
    }

    public function __destruct()
    {
        $this->id = null;
    }
}
