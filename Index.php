<?php

declare(strict_types=1);

use Hutech\Controllers\Api\ApiUserController;
use Hutech\Controllers\Api\ApiController;
use Hutech\Controllers\CartController;
use Hutech\Controllers\CoffeeController;
use Hutech\Controllers\HomeController;
use Hutech\Controllers\PaymentController;
use Hutech\Controllers\UserController;
use Hutech\Exceptions\InvalidRoute;
use Hutech\Utils\Route;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

require_once './vendor/autoload.php';

session_start();

$route = new Route();

try {
    $route->setRoute('/', [HomeController::class, 'index'])
        ->setRoute('/manager', [CoffeeController::class, 'getAll'], ['Auth' => ['ADMIN']])
        ->setRoute('/add', [CoffeeController::class, 'add'], ['Auth' => ['ADMIN']])
        ->setRoute('/edit', [CoffeeController::class, 'edit'], ['Auth' => ['ADMIN']])
        ->setRoute('/insert', [CoffeeController::class, 'insert'], ['Auth' => ['ADMIN']])
        ->setRoute('/update', [CoffeeController::class, 'update'], ['Auth' => ['ADMIN']])
        ->setRoute('/delete', [CoffeeController::class, 'delete'], ['Auth' => ['ADMIN']])
        ->setRoute('/order', [CartController::class, 'index'])
        ->setRoute('/addToCart', [CartController::class, 'addToCart'])
        ->setRoute('/cart', [CartController::class, 'showCart'])
        ->setRoute('/cartUpdate', [CartController::class, 'cartUpdate'])
        ->setRoute('/removeItem', [CartController::class, 'cartDelete'])
        ->setRoute('/checkout', [PaymentController::class, 'payment'])
        ->setRoute('/discount', [PaymentController::class, 'discount'])
        ->setRoute('/unDiscount', [PaymentController::class, 'unDiscount'])
        ->setRoute('/payment-result', [PaymentController::class, 'paymentResult'])
        ->setRoute('/login', [UserController::class, 'login'])
        ->setRoute('/signin', [UserController::class, 'signin'])
        ->setRoute('/logout', [UserController::class, 'logout'], ['Auth' => ['ADMIN', 'USER']])
        ->setRoute('/signup', [UserController::class, 'addUser'])
        ->setRoute('/register', [UserController::class, 'index'])
        ->setRoute('/verify-email', [UserController::class, 'verifyEmail'])
        ->setRoute('/resend', [UserController::class, 'resendEmail'])
        ->setRoute('/forgot-password', [UserController::class, 'forgotPassword'])
        ->setRoute('/send-forgot-password', [UserController::class, 'sendForgotPassword'])
        ->setRoute('/reset-password', [UserController::class, 'resetPassword'])
        ->setRoute('/change-password', [UserController::class, 'changePassword'])
        ->setRoute('/api/v1/products', [ApiController::class, 'getAllProducts'], ['Auth' => ['ADMIN']])
        ->setRoute('/api/v1/categories', [ApiController::class, 'getAllCategories'], ['Auth' => ['ADMIN']])
        ->setRoute('/api/v1/add', [ApiController::class, 'add'], ['Auth' => ['ADMIN']])
        ->setRoute('/api/v1/getById', [ApiController::class, 'getById'], ['Auth' => ['ADMIN']])
        ->setRoute('/api/v1/update', [ApiController::class, 'update'], ['Auth' => ['ADMIN']])
        ->setRoute('/api/v1/delete', [ApiController::class, 'delete'], ['Auth' => ['ADMIN']])
        ->setRoute('/api/v1/login', [ApiUserController::class, 'getToken'])
        ->setRoute('/api/v1/logout', [ApiUserController::class, 'logout'])
        ->setRoute('/api/v1/send-forgot-password', [ApiUserController::class, 'sendForgotPassword'])
        ->setRoute('/api/v1/register', [ApiUserController::class, 'addUser'])
        ->setRoute('/api/v1/resend', [ApiUserController::class, 'resendEmail'])
        ->run();
} catch (NotFoundExceptionInterface|ContainerExceptionInterface|ReflectionException $e) {
    throw new InvalidRoute();
}