<?php

declare(strict_types=1);

use Hutech\Controllers\CartController;
use Hutech\Controllers\CoffeeController;
use Hutech\Controllers\HomeController;
use Hutech\Controllers\PaymentController;
use Hutech\Controllers\UserController;
use Hutech\Utils\Route;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

require_once './vendor/autoload.php';

session_start();

$route = new Route();

try {
    $route->setRoute('/', [HomeController::class, 'index'])
        ->setRoute('/manager', [CoffeeController::class, 'getAll'], ['Auth' =>['ADMIN', 'USER']])
        ->setRoute('/add', [CoffeeController::class, 'add'], ['Auth'=>['ADMIN']])
        ->setRoute('/edit', [CoffeeController::class, 'edit'], ['Auth'=>['ADMIN']])
        ->setRoute('/insert', [CoffeeController::class, 'insert'], ['Auth'=>['ADMIN']])
        ->setRoute('/update', [CoffeeController::class, 'update'], ['Auth'=>['ADMIN']])
        ->setRoute('/delete', [CoffeeController::class, 'delete'], ['Auth'=>['ADMIN']])
        ->setRoute('/order', [CartController::class, 'index'])
        ->setRoute('/addToCart', [CartController::class, 'addToCart'])
        ->setRoute('/cart', [CartController::class, 'showCart'])
        ->setRoute('/cartUpdate', [CartController::class, 'cartUpdate'])
        ->setRoute('/removeItem', [CartController::class, 'cartDelete'])
        ->setRoute('/checkout', [PaymentController::class, 'payment'])
        ->setRoute('/discount', [PaymentController::class, 'discount'])
        ->setRoute('/payment-result', [PaymentController::class, 'paymentResult'])
        ->setRoute('/login', [UserController::class, 'login'])
        ->setRoute('/logout', [UserController::class, 'logout'], ['auth'=>['ADMIN', 'USER']])
        ->setRoute('/signup', [UserController::class, 'addUser'])
        ->setRoute('/register', [UserController::class, 'index'])
        ->run();
} catch (NotFoundExceptionInterface|ContainerExceptionInterface|ReflectionException $e) {
    print_r($e->getMessage());
}