<?php

declare(strict_types=1);

namespace Hutech\Services;

use Hutech\Models\Product;
use Hutech\Repositories\ProductRepository;

include_once './Repositories/ProductRepository.php';
include_once './Models/Product.php';

readonly class ProductService
{
    public function __construct(protected ProductRepository $coffeeRepository)
    {
    }

    public function getAll(): array
    {
        return $this->coffeeRepository->getAll();
    }

    public function getById(int $id): Product|null
    {
        return $this->coffeeRepository->getById($id);
    }

    public function create(Product $coffee): void
    {
        $this->coffeeRepository->create($coffee);
    }

    public function update(Product $coffee): void
    {
        $this->coffeeRepository->update($coffee);
    }

    public function delete(int $id): void
    {
        $this->coffeeRepository->delete($id);
    }
}