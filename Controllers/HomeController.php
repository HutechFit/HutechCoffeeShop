<?php

declare(strict_types=1);

namespace Hutech\Controllers;

use Hutech\Services\ProductService;
use Hutech\Utils\Logging;

readonly class HomeController
{
    private Logging $logging;
    public function __construct(
        protected ProductService $productService
    )
    {
        $this->logging = new Logging();
    }

    public function index(): void
    {
        $this->logging->info('Truy cập vào trang chủ', ['user' => $_SERVER['REMOTE_ADDR']]);
        $products = $this->productService->getAll();
        require_once 'Views/Home/Home.php';
    }
}
