<?php

declare(strict_types=1);

namespace Hutech\Services;

use Hutech\Repositories\ProductRepository;

readonly class ProductService
{
    public function __construct(protected ProductRepository $productRepository)
    {
    }

    public function getAll(): ?array
    {
        return $this->productRepository->findAll();
    }

    public function getById($id): ?object
    {
        return $this->productRepository->findById($id);
    }

    public function create($product): void
    {
        $this->productRepository->add($product);
    }

    public function delete($id): void
    {
        $this->productRepository->remove($id);
    }

    public function update($product): void
    {
        $this->productRepository->modify($product);
    }
}