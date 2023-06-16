<?php

declare(strict_types=1);

namespace Hutech\Factories;

use Hutech\Models\Category;

readonly class CategoryFactory
{
    public static function create($id, $name) : Category
    {
        return new Category((int) $id, $name);
    }
}