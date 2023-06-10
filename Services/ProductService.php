<?php

declare(strict_types=1);

namespace Hutech\Services;

use Hutech\Repositories\ProductRepository;

include_once './Repositories/ProductRepository.php';

readonly class ProductService
{
    public function __construct(protected ProductRepository $coffeeRepository)
    {
    }

    public function getAll(): array
    {
        return $this->coffeeRepository->findAll();
    }

}