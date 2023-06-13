<?php

declare(strict_types=1);

namespace Hutech\Models;

use Symfony\Component\Validator\Constraints as Assert;

include_once './Models/BaseModel.php';

class Product extends BaseModel
{
    #[Assert\NotBlank(message: 'Name is required')]
    #[Assert\Length(
        min: 1,
        max: 50,
        minMessage: 'Name must be at least {{ limit }} characters long',
        maxMessage: 'Name cannot be longer than {{ limit }} characters')]
    public string $name;

    #[Assert\NotBlank(message: 'Price is required')]
    #[Assert\Range(
        minMessage: 'Price must be at least {{ limit }}',
        maxMessage: 'Price cannot be longer than {{ limit }}',
        min: 0,
        max: 1000000)]
    public int|float $price;

    #[Assert\Length(
        min: 1,
        max: 255,
        minMessage: 'Image must be at least {{ limit }} characters long',
        maxMessage: 'Image cannot be longer than {{ limit }} characters')]
    public string $image;

    #[Assert\Length(
        min: 1,
        max: 255,
        minMessage: 'Description must be at least {{ limit }} characters long',
        maxMessage: 'Description cannot be longer than {{ limit }} characters')]
    public string $description;

    public int $category;

    public function __construct(?int $id, string $name, float|int $price, string $image, string $description, int $category)
    {
        parent::__construct($id);
        $this->name = $name;
        $this->price = $price;
        $this->image = $image;
        $this->description = $description;
        $this->category = $category;
    }
}
