<?php

declare(strict_types=1);

namespace Hutech\Services;

use Hutech\Models\Product;
use Hutech\Repositories\ProductRepository;

include_once './Models/Product.php';
include_once './Repositories/ProductRepository.php';

readonly class ProductService
{
    public function __construct(protected ProductRepository $productRepository)
    {
    }

    public function getAll(): ?array
    {
        return $this->productRepository->findAll();
    }

    public function getById(int $id): ?object
    {
        return $this->productRepository->findById($id);
    }

    public function create(Product $product): void
    {
        $this->productRepository->add($product);
    }

    public function delete(int $id): void
    {
        $this->productRepository->remove($id);
    }

    public function update(Product $product): void
    {
        $this->productRepository->update($product);
    }

}