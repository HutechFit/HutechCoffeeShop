<?php

declare(strict_types=1);

namespace Hutech\Controllers;

use Hutech\Services\CoffeeService;

include_once './Services/CoffeeService.php';

class CoffeeController
{
    protected CoffeeService $coffeeService;

    public function __construct(CoffeeService $coffeeService)
    {
        $this->coffeeService = $coffeeService;
    }

    public function getAll() : void
    {
        $coffees = $this->coffeeService->getAll();
        require_once './Views/Coffee/Manager.php';
    }

    public function add(): void
    {
        require_once './Views/Coffee/Add.php';
    }
}
