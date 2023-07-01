<?php

declare(strict_types=1);

namespace Hutech\Controllers;

use Hutech\Security\Csrf;
use Hutech\Services\ProductService;

readonly class CartController
{
    public function __construct(
        protected ProductService $coffeeService,
        protected Csrf           $csrf
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
            $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
            $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
            $price = htmlspecialchars($_POST['price'], ENT_QUOTES, 'UTF-8');
            $image = htmlspecialchars($_POST['image'], ENT_QUOTES, 'UTF-8');
            $quantity = htmlspecialchars($_POST['quantity'], ENT_QUOTES, 'UTF-8');

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
            setcookie('cart', $encodedCartData, [
                'expires' => time() + 86400,
                'path' => '/',
                'secure' => true,
                'samesite' => 'Strict',
                'domain' => 'hutech-coffee.local'
            ]);
        }

        header('Location: /hutech-coffee/order');
    }

    public function cartUpdate(): void
    {
        if (isset($_POST['id'])) {
            $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
            $quantity = htmlspecialchars($_POST['quantity'], ENT_QUOTES, 'UTF-8');

            if (isset($_COOKIE['cart'])) {
                $cartData = json_decode(base64_decode($_COOKIE['cart']), true);
                if (is_array($cartData) && array_key_exists($id, $cartData)) {
                    $cartData[$id]['quantity'] = $quantity;
                }
            }

            $encodedCartData = base64_encode(json_encode($cartData));
            setcookie('cart', $encodedCartData, [
                'expires' => time() + 86400,
                'path' => '/',
                'secure' => true,
                'samesite' => 'Strict',
                'domain' => 'hutech-coffee.local'
            ]);
        }

        header('Location: /hutech-coffee/cart');
    }

    public function cartDelete(): void
    {
        if (isset($_POST['id'])) {
            $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');

            if (isset($_COOKIE['cart'])) {
                $cartData = json_decode(base64_decode($_COOKIE['cart']), true);

                if (count($cartData) == 1) {
                    setcookie('cart', '', time() - 86400, '/');
                    if (isset($_SESSION['total'])) {
                        unset($_SESSION['total']);
                    }

                    if (isset($_SESSION['discount'])) {
                        unset($_SESSION['discount']);
                    }

                    if (isset($_SESSION['value'])) {
                        unset($_SESSION['value']);
                    }

                }

                if (is_array($cartData) && array_key_exists($id, $cartData)) {
                    unset($cartData[$id]);
                }

            }

            $encodedCartData = base64_encode(json_encode($cartData));
            setcookie('cart', $encodedCartData, [
                'expires' => time() + 86400,
                'path' => '/',
                'secure' => true,
                'samesite' => 'Strict',
                'domain' => 'hutech-coffee.local'
            ]);
        }

        header('Location: /hutech-coffee/cart');
    }
}
