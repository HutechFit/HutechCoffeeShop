<?php

declare(strict_types=1);

namespace Hutech\Controllers;

use Hutech\Services\ProductService;

include_once './Services/ProductService.php';
include_once './Services/CategoryService.php';

class CartController
{
    public function __construct(protected ProductService $coffeeService)
    {
    }

    public function index(): void
    {
        $coffees = $this->coffeeService->getAll();
        require_once 'Views/Coffee/Order.php';
    }
}
