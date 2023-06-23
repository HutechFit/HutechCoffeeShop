<?php

declare(strict_types=1);

namespace Hutech\Controllers;

use Hutech\Services\ProductService;
use JetBrains\PhpStorm\NoReturn;

include_once './Services/ProductService.php';
include_once './Services/CategoryService.php';

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
date_default_timezone_set('Asia/Ho_Chi_Minh');

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

    public function showCart(): void
    {
        if (isset($_COOKIE['cart'])) {
            $cartData = json_decode(base64_decode($_COOKIE['cart']), true);
            $cart = [];
            foreach ($cartData as $coffee) {
                $cart[] = $coffee;
            }
        }

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

    public function payment(): void
    {
        match ($_POST['payment-method']) {
            'striped' => $this->striped(),
            'paypal' => $this->paypal(),
            'vnpay' => $this->vnpay(),
            default => header('Location: /hutech-coffee/cart')
        };
    }

    public function paymentResult(): void
    {
        $vnp_SecureHash = $_GET['vnp_SecureHash'] ?? '';
        $vnp_HashSecret = "NOFIDXGIVCXRMPYNIWMBKTUDJSHUENMO";
        $vnp_ResponseCode = $_GET['vnp_ResponseCode'] ?? '';
        $inputData = [];

        foreach ($_GET as $key => $value) {
            if (str_starts_with($key, "vnp_")) {
                $inputData[$key] = $value;
            }
        }

        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";

        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

//        if ($secureHash == $vnp_SecureHash) {
//            if ($_GET['vnp_ResponseCode'] == '00')
//            {
//                // Lưu dữ liệu đơn hàng vào CSDL
//            }
//        }

        require_once 'Views/Coffee/Payment.php';
    }

    #[NoReturn] private function vnpay(): void
    {
        $vnp_TxnRef = strval(rand(1, 1000000));
        $vnp_Amount = $_POST['amount'];
        $vnp_Locale = 'vn';

        # Địa chỉ IP của khách hàng
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        # Địa chỉ của merchant
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";

        # Chuỗi bí mật (Secret Key)
        $vnp_HashSecret = "NOFIDXGIVCXRMPYNIWMBKTUDJSHUENMO";

        $inputData = array(
            "vnp_Version" => "2.1.0",

            # Mã định danh merchant kết nối (Terminal Id)
            "vnp_TmnCode" => "CQEZCMP9",

            "vnp_Amount" => strval($vnp_Amount * 100),
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => "Thanh toan GD: " . $vnp_TxnRef,
            "vnp_OrderType" => "other",

            # Địa chỉ nhận kết quả trả về của merchant
            "vnp_ReturnUrl" => "https://hutech-coffee.local/payment-result",
            "vnp_TxnRef" => $vnp_TxnRef,

            # Thời gian cho phép thanh toán (tính theo giây)
            "vnp_ExpireDate"=> date('YmdHis', strtotime('+15 minutes', strtotime(date("YmdHis"))))
        );

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashData = "";

        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;

        # Tạo chữ ký điện tử
        $vnpSecureHash =   hash_hmac('sha512', $hashData, $vnp_HashSecret);
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;

        header('Location: ' . $vnp_Url);
        die();
    }

    private function striped(): void
    {
        $_SESSION['payment_error'] = 'Stripe đang được phát triển';
        header('Location: /hutech-coffee/cart');
    }

    private function paypal(): void
    {
        $_SESSION['payment_error'] = 'Paypal đang được phát triển';
        header('Location: /hutech-coffee/cart');
    }
}
