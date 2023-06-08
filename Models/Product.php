<?php

declare(strict_types=1);

namespace Hutech\Models;

include_once './Models/BaseModel.php';

class Product extends BaseModel
{
	public string $name;
	public int|float $price;
	public string $image;
	public string $description;
    public string $category;

	public function __construct($id, $name, $price, $image, $description, $category)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->image = $image;
        $this->description = $description;
        $this->category = $category;
    }
}
