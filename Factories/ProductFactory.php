<?php

declare(strict_types=1);

namespace Hutech\Factories;

use Hutech\Models\Product;

include_once './Models/Product.php';

readonly class ProductFactory
{
    public static function create($id, $name, $price, $image, $description, $category) : Product
    {
        return new Product($id, $name, $price, $image, $description, $category);
    }
}