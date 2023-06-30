<?php

declare(strict_types=1);

namespace Hutech\Controllers;

use Hutech\Enum\PaymentMethod;
use Hutech\Factories\CouponFactory;
use Hutech\Factories\InvoiceFactory;
use Hutech\Factories\ItemInvoiceFactory;
use Hutech\Security\Csrf;
use Hutech\Services\CouponService;
use Hutech\Services\InvoiceService;
use Hutech\Services\ItemInvoiceService;

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
date_default_timezone_set('Asia/Ho_Chi_Minh');

readonly class PaymentController
{

    public function __construct(
        protected InvoiceService     $invoiceService,
        protected ItemInvoiceService $itemInvoiceService,
        protected CouponService      $couponService,
        protected InvoiceFactory     $invoiceFactory,
        protected ItemInvoiceFactory $itemInvoiceFactory,
        protected CouponFactory      $couponFactory,
        protected Csrf               $csrf
    )
    {
    }

    public function payment(): void
    {
        if (!isset($_POST['csrf_token']) || !$this->csrf->validateToken($_POST['csrf_token'])) {
            $_SESSION['csrf_error'] = 'Token không hợp lệ';
            header('Location: /hutech-coffee/cart');
            exit;
        }
        unset($_SESSION['csrf_token']);

        match ($_POST['payment-method']) {
            'striped' => $this->striped(),
            'paypal' => $this->paypal(),
            'vnpay' => $this->vnpay(),
            default => header('Location: /hutech-coffee/cart')
        };
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

    private function vnpay(): never
    {
        $vnp_TxnRef = strval(rand(1, 1000000));
        $vnp_Amount = $_POST['amount'];
        $vnp_Locale = 'vn';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_HashSecret = "NOFIDXGIVCXRMPYNIWMBKTUDJSHUENMO";

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => "CQEZCMP9",
            "vnp_Amount" => strval($vnp_Amount * 100),
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => "Thanh toan GD: " . $vnp_TxnRef,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => "https://hutech-coffee.local/payment-result",
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => date('YmdHis', strtotime('+15 minutes', strtotime(date("YmdHis"))))
        ];

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
        $vnpSecureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;

        header('Location: ' . $vnp_Url);
        die();
    }

    public function discount(): void
    {
        if (!isset($_POST['csrf_token']) || !$this->csrf->validateToken($_POST['csrf_token'])) {
            $_SESSION['csrf_error'] = 'Token không hợp lệ';
            header('Location: /hutech-coffee/register');
            exit;
        }

        unset($_SESSION['csrf_token']);

        $discount = $_POST['code'] ?? '';

        $coupon = $this->couponService->getCoupon($discount);

        if (empty($discount)) {
            $_SESSION['discount_error'] = 'Mã giảm giá không được để trống';
            header('Location: /hutech-coffee/cart');
            exit;
        }

        if (isset($_COOKIE['discount'])) {
            $_SESSION['discount_error'] = 'Bạn đã sử dụng mã giảm giá rồi';
            header('Location: /hutech-coffee/cart');
            exit;
        }

        if (empty($coupon)) {
            $_SESSION['discount_error'] = 'Mã giảm giá không tồn tại';
            header('Location: /hutech-coffee/cart');
            exit;
        }

        if (date('Y-m-d') > date('Y-m-d', strtotime($coupon[0]['expired']))) {
            $_SESSION['discount_error'] = 'Mã giảm giá đã hết hạn';
            header('Location: /hutech-coffee/cart');
            exit;
        }

        $cartData = json_decode(base64_decode($_COOKIE['cart']), true);
        $total = 0;

        foreach ($cartData as $coffee) {
            $total += $coffee['price'] * $coffee['quantity'];
        }

        $total = match ($coupon[0]['value'] <=> 100) {
            -1 => $total * (1 - $coupon[0]['value'] / 100),
            0 => 0,
            1 => $total - $coupon[0]['value']
        };

        setcookie('discount', base64_encode(json_encode($coupon)),[
            'expires' => time() + 86400,
            'path' => '/',
            'secure' => true,
            'samesite' => 'Strict',
            'domain' => 'hutech-coffee.local'
        ]);

        $_SESSION['total'] = $total;
        $_SESSION['discount'] = $coupon[0]['code'];
        $_SESSION['value'] = match ($coupon[0]['value'] <=> 100) {
            -1 => $coupon[0]['value'] . '%',
            0 => '100%',
            1 => number_format($coupon[0]['value']) . 'đ',
        };

        header('Location: /hutech-coffee/cart');
    }

    public function unDiscount(): void
    {
        if (isset($_SESSION['total'])) {
            unset($_SESSION['total']);
        }

        if (isset($_SESSION['discount'])) {
            unset($_SESSION['discount']);
        }

        if (isset($_SESSION['value'])) {
            unset($_SESSION['value']);
        }

        setcookie('discount', '',[
            'expires' => time() - 86400,
            'path' => '/',
            'secure' => true,
            'samesite' => 'Strict',
            'domain' => 'hutech-coffee.local'
        ]);
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

        if ($secureHash == $vnp_SecureHash && $_GET['vnp_ResponseCode'] === '00') {
            $this->saveBill($_GET['vnp_TxnRef'], PaymentMethod::VNPAY->name, $_GET['vnp_Amount'] / 100, date('Y-m-d H:i:s', strtotime($_GET['vnp_PayDate'])));
        }

        if (isset($_SESSION['total'])) {
            unset($_SESSION['total']);
        }


        if (isset($_SESSION['discount'])) {
            unset($_SESSION['discount']);
        }

        if (isset($_SESSION['value'])) {
            unset($_SESSION['value']);
        }

        setcookie('cart', '', [
            'expires' => time() + 86400,
            'path' => '/',
            'secure' => true,
            'samesite' => 'Strict',
            'domain' => 'hutech-coffee.local'
        ]);

        setcookie('discount', '', [
            'expires' => time() + 86400,
            'path' => '/',
            'secure' => true,
            'samesite' => 'Strict',
            'domain' => 'hutech-coffee.local'
        ]);

        require_once 'Views/Coffee/Payment.php';
    }

    private function saveBill($id, $payment, $total, $payment_date): void
    {
        $paymentMethod = match ($payment) {
            PaymentMethod::STIPE->name => PaymentMethod::STIPE->value,
            PaymentMethod::PAYPAL->name => PaymentMethod::PAYPAL->value,
            PaymentMethod::VNPAY->name => PaymentMethod::VNPAY->value,
            default => PaymentMethod::CASH->value
        };

        $invoice = $this->invoiceFactory->create($id, $total, $payment_date, $paymentMethod);

        $this->invoiceService->create($invoice);

        $cartData = json_decode(base64_decode($_COOKIE['cart']), true);

        foreach ($cartData as $coffee) {
            $itemInvoice = $this->itemInvoiceFactory->create($id, $coffee['id'], $coffee['quantity']);
            $this->itemInvoiceService->create($itemInvoice);
        }

        $this->sendEmailInvoice($_POST['email'] ?? '', $id, $total, $payment_date, $paymentMethod);

        header('Location: /hutech-coffee/cart');
    }

    private function sendEmailInvoice($email, $id, $total, $payment_date, $payment_method): void
    {
        $to = $email;
        $subject = 'Thông tin đơn hàng';
        $message = file_get_contents('./Views/Templates/EmailInvoice.php');

        $headers = [
            'From' => 'Hutech Coffee <nguyenxuannhan.dev@gmail.com>',
            'Reply-To' => 'nd.anh@hutech.edu.vn',
            'Content-type' => 'text/html; charset=UTF-8',
            'MIME-Version' => '1.0',
            'X-Priority' => '1',
            'X-Mailer' => 'PHP/' . phpversion()
        ];

        $message = str_replace('{{id}}', strval($id), $message);
        $message = str_replace('{{total}}', strval($total), $message);
        $message = str_replace('{{payment_date}}', strval($payment_date), $message);
        $message = str_replace('{{payment_method}}', strval($payment_method), $message);
        $message = str_replace('{{email}}', strval($email), $message);

        $success = mail($to, $subject, $message, $headers);

        if (!$success) {
            $errorMessage = error_get_last()['message'];
            $_SESSION['payment_error'] = $errorMessage;
        }
    }
}