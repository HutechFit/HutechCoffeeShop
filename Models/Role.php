<?php

declare(strict_types=1);

namespace Hutech\Models;

class Role
{
    public int $id;
    public string $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function __destruct()
    {
        $this->id = 0;
        $this->name = '';
    }
}