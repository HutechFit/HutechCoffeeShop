<?php

declare(strict_types=1);

namespace Hutech\Controllers;

use Hutech\Security\Csrf;
use Hutech\Services\ProductService;

readonly class CartController
{
    public function __construct(
        protected ProductService $coffeeService,
        protected Csrf $csrf
    )
    {
    }

    public function index(): void
    {
        $coffees = $this->coffeeService->getAll();
        require_once 'Views/Coffee/Order.php';
    }

    public function showCart(): void
    {
        if (isset($_COOKIE['cart'])) {
            $cartData = json_decode(base64_decode($_COOKIE['cart']), true);
            $cart = [];
            foreach ($cartData as $coffee) {
                $cart[] = $coffee;
            }
        }

        $token = $this->csrf->getToken();
        require_once 'Views/Coffee/Cart.php';
    }

    public function addToCart(): void
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $price = $_POST['price'];
            $image = $_POST['image'];
            $quantity = $_POST['quantity'];

            $cart = [
                'id' => $id,
                'name' => $name,
                'price' => $price,
                'image' => $image,
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

    public function cartUpdate(): void
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $quantity = $_POST['quantity'];

            if (isset($_COOKIE['cart'])) {
                $cartData = json_decode(base64_decode($_COOKIE['cart']), true);
                if (is_array($cartData) && array_key_exists($id, $cartData)) {
                    $cartData[$id]['quantity'] = $quantity;
                }
            }

            $encodedCartData = base64_encode(json_encode($cartData));
            setcookie('cart', $encodedCartData, time() + 86400, '/');
        }

        header('Location: /hutech-coffee/cart');
    }

    public function cartDelete(): void
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];

            if (isset($_COOKIE['cart'])) {
                $cartData = json_decode(base64_decode($_COOKIE['cart']), true);

                if (count($cartData) == 1) {
                    setcookie('cart', '', time() - 86400, '/');
                }

                if (is_array($cartData) && array_key_exists($id, $cartData)) {
                    unset($cartData[$id]);
                }

            }

            $encodedCartData = base64_encode(json_encode($cartData));
            setcookie('cart', $encodedCartData, time() + 86400, '/');
        }

        header('Location: /hutech-coffee/cart');
    }
}
