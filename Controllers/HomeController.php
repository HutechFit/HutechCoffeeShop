<?php

declare(strict_types=1);

namespace Hutech\Controllers;

use Hutech\Services\ProductService;

readonly class HomeController
{
    public function __construct(protected ProductService $productService)
    {
    }

	public function index(): void
	{
        $products = $this->productService->getAll();
		require_once 'Views/Home/Home.php';
	}
}
