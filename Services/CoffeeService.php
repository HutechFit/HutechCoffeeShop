<?php

namespace Hutech\Services;

use Hutech\Repositories\CoffeeRepository;

include_once './Repositories/CoffeeRepository.php';

readonly class CoffeeService
{
    public function __construct(protected CoffeeRepository $coffeeRepository)
    {
    }

    public function getAll(): array
    {
        return $this->coffeeRepository->getAll();
    }

    public function getById($id): object
    {
        return $this->coffeeRepository->getById($id);
    }
}