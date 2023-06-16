<?php

declare(strict_types=1);

namespace Hutech\Models;

class Product extends BaseModel
{
    public string $name;

    public int|float $price;

    public ?string $image;

    public ?string $description;

    public ?int $category_id;

    public function __construct($id, $name, $price, $image, $description, $category_id)
    {
        parent::__construct($id);
        $this->name = $name;
        $this->price = $price;
        $this->image = $image;
        $this->description = $description;
        $this->category_id = $category_id;
    }

    public function __destruct()
    {
        parent::__destruct();
        $this->name = '';
        $this->price = 0;
        $this->image = null;
        $this->description = null;
        $this->category_id = null;
    }
}
