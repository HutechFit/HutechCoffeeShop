<?php

declare(strict_types=1);

use DI\DependencyException;
use DI\NotFoundException;
use Hutech\Services\CoffeeService;

require_once './Services/CoffeeService.php';

class CoffeeController
{
    protected CoffeeService $coffeeService;

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __construct()
    {
        global $container;
        $this->coffeeService = $container->get(CoffeeService::class);
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
