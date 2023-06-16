<?php

declare(strict_types=1);

namespace Hutech\Models;

class Category extends BaseModel
{
    public string $name;

    public function __construct(?int $id, string $name)
    {
        parent::__construct($id);
        $this->name = $name;
    }

    public function __destruct()
    {
        parent::__destruct();
        $this->name = '';
    }
}