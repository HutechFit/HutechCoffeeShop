<?php

declare(strict_types=1);

namespace Hutech\Repositories;

use Hutech\Models\Product;

include_once './Models/Product.php';
include_once './Repositories/BaseRepository.php';

class ProductRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('product');
    }

    public function findAll(): ?array
    {
        return $this->getAll();
    }

    public function findById($id): ?Product
    {
        return $this->getById($id);
    }

    public function add(Product $product): void
    {
        $this->insert($product);
    }

    public function modify(Product $product): void
    {
        $this->update($product);
    }

    public function remove($id): void
    {
        $this->delete($id);
    }
}