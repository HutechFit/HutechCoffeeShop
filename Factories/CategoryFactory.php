<?php

namespace Hutech\Factories;

use Hutech\Models\Category;

include_once './Models/Category.php';

readonly class CategoryFactory
{
    public static function create(string $name) : Category
    {
        return new Category(null, $name);
    }

    public static function update(int $id, string $name) : Category
    {
        return new Category($id, $name);
    }
}