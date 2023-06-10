<?php

declare(strict_types=1);

namespace Hutech\Models;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use Hutech\Repositories\CategoryRepository;

include_once './Models/BaseModel.php';

#[Entity(repositoryClass: CategoryRepository::class)]
#[Table(name: 'categories')]
class Category extends BaseModel
{
    #[Column(name: 'name', length: 50)]
    public string $name;

    #[OneToMany(mappedBy: 'category', targetEntity: Product::class)]
    public Collection $products;

    public function __construct($id, $name)
    {
        parent::__construct($id);
        $this->name = $name;
        $this->products = new ArrayCollection();
    }
}