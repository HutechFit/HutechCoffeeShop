<?php

declare(strict_types=1);

namespace Hutech\Factories;

use Hutech\Models\Coffee;

class CoffeeFactory
{
    public static function create($id, $name, $price, $image, $description, $category) : Coffee
    {
        return new Coffee($id, $name, $price, $image, $description, $category);
    }
}