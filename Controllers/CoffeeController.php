<?php

declare(strict_types=1);

namespace Hutech\Controllers;

use Hutech\Services\CoffeeService;

include_once './Services/CoffeeService.php';

readonly class CoffeeController
{
    public function __construct(protected CoffeeService $coffeeService)
    {}

    public function getAll() : void
    {
        $coffees = $this->coffeeService->getAll();
        require_once './Views/Coffee/Manager.php';
    }

    public function add(): void
    {
        require_once './Views/Coffee/Add.php';
    }

    public function edit(): void
    {
        $coffee = $this->coffeeService->getById($_GET['id']);
        require_once './Views/Coffee/Edit.php';
    }
}
