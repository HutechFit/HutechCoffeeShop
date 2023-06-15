<?php

declare(strict_types=1);

namespace Hutech\Factories;

use Hutech\Models\Product;

readonly class ProductFactory
{
    public static function create($name, $price, $image, $description, $category_id) : Product
    {
        return new Product(null, $name, (float) $price, $image, $description, (int) $category_id);
    }

    public static function update($id, $name, $price, $image, $description, $category_id) : Product
    {
        return new Product((int) $id, $name, (float)  $price, $image, $description, (int) $category_id);
    }
}