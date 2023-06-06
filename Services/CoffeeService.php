<?php

namespace Hutech\Services;


use Hutech\Repositories\CoffeeRepository;

include_once './Repositories/CoffeeRepository.php';

class CoffeeService
{
    protected CoffeeRepository $coffeeRepository;

    public function __construct(CoffeeRepository $coffeeRepository)
    {
        $this->coffeeRepository = $coffeeRepository;
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