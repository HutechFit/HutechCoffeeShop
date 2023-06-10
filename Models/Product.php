<?php

declare(strict_types=1);

namespace Hutech\Models;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Hutech\Repositories\ProductRepository;

include_once './Models/BaseModel.php';

#[Entity(repositoryClass: ProductRepository::class)]
#[Table(name: 'products')]
class Product extends BaseModel
{
    #[Column(length: 50)]
    public string $name;

    #[Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    public int|float $price;

    #[Column(length: 255, nullable: true)]
    public string $image;

    #[Column(length: 255, nullable: true)]
    public string $description;

    #[ManyToOne(targetEntity: Category::class, inversedBy: 'products')]
    #[JoinColumn(name: 'category_id', referencedColumnName: 'id')]
    public Category|null $category;

    /**
     * @param int $id
     * @param string $name
     * @param float|int $price
     * @param string $image
     * @param string $description
     * @param Category|null $category
     */
    public function __construct(
        int $id,
        string $name,
        float|int $price,
        string $image,
        string $description,
        ?Category $category
    )
    {
        parent::__construct($id);
        $this->name = $name;
        $this->price = $price;
        $this->image = $image;
        $this->description = $description;
        $this->category = $category;
    }
}
