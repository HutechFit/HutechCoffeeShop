<?php

declare(strict_types=1);

namespace Hutech\Controllers;

use Hutech\Services\ProductService;

include_once './Services/ProductService.php';
include_once './Services/CategoryService.php';

readonly class CartController
{
    public function __construct(protected ProductService $coffeeService)
    {
    }

    public function index(): void
    {
        $coffees = $this->coffeeService->getAll();
        require_once 'Views/Coffee/Order.php';
    }

    public function addToCart(): void
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];

            $cart = [
                'id' => $id,
                'name' => $name,
                'price' => $price,
                'quantity' => $quantity
            ];

            if (isset($_COOKIE['cart'])) {
                $cartData = json_decode(base64_decode($_COOKIE['cart']), true);
                if (is_array($cartData) && array_key_exists($id, $cartData)) {
                    $cart['quantity'] += $cartData[$id]['quantity'];
                }
                $cartData[$id] = $cart;
            } else {
                $cartData = [$id => $cart];
            }

            $encodedCartData = base64_encode(json_encode($cartData));
            setcookie('cart', $encodedCartData, time() + 86400, '/');
        }

        header('Location: /hutech-coffee/order');
    }
}
