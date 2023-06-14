<?php

declare(strict_types=1);

use Hutech\Controllers\CoffeeController;
use Hutech\Controllers\HomeController;
use Hutech\Controllers\UserController;
use Hutech\Utils\Route;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

include_once './vendor/autoload.php';
include_once './Controllers/CoffeeController.php';
include_once './Controllers/UserController.php';

$route = new Route();

try {
    $route->setRoute('/', [HomeController::class, 'index'])
        ->setRoute('/manager', [CoffeeController::class, 'getAll'])
        ->setRoute('/add', [CoffeeController::class, 'add'])
        ->setRoute('/edit', [CoffeeController::class, 'edit'])
        ->setRoute('/insert', [CoffeeController::class, 'insert'])
        ->setRoute('/update', [CoffeeController::class, 'update'])
        ->setRoute('/delete', [CoffeeController::class, 'delete'])
        ->setRoute('/login', [UserController::class, 'login'])
        ->setRoute('/logout', [UserController::class, 'logout'])
        ->setRoute('/signup', [UserController::class, 'addUser'])
        ->setRoute('/register', [UserController::class, 'index'])
        ->run();
} catch (NotFoundExceptionInterface|ContainerExceptionInterface|ReflectionException $e) {
    print_r($e->getMessage());
}