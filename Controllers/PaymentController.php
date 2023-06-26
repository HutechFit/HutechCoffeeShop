<?php

declare(strict_types=1);

namespace Hutech\Controllers;

use Hutech\Enum\PaymentMethod;
use Hutech\Factories\CouponFactory;
use Hutech\Factories\InvoiceFactory;
use Hutech\Factories\ItemInvoiceFactory;
use Hutech\Services\CouponService;
use Hutech\Services\InvoiceService;
use Hutech\Services\ItemInvoiceService;

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
date_default_timezone_set('Asia/Ho_Chi_Minh');

readonly class PaymentController
{

    public function __construct(
        protected InvoiceService $invoiceService,
        protected ItemInvoiceService $itemInvoiceService,
        protected CouponService $couponService,
        protected InvoiceFactory $invoiceFactory,
        protected ItemInvoiceFactory $itemInvoiceFactory,
        protected CouponFactory $couponFactory
    )
    {
    }

    /**
     * Xử lý thanh toán
     * @return void
     */
    public function payment(): void
    {
        match ($_POST['payment-method']) {
            'striped' => $this->striped(),
            'paypal' => $this->paypal(),
            'vnpay' => $this->vnpay(),
            default => header('Location: /hutech-coffee/cart')
        };
    }

    /**
     * Xử lý mã giảm giá
     * @return void
     */
    public function discount(): void
    {
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

        setcookie('discount', base64_encode(json_encode($coupon)), time() + 86400, '/');

        $_SESSION['total'] = $total;
        $_SESSION['discount'] = $coupon[0]['code'];
        $_SESSION['value'] = match ($coupon[0]['value'] <=> 100) {
            -1 => $coupon[0]['value'] . '%',
            0 => '100%',
            1 => number_format($coupon[0]['value']) . 'đ',
        };

        header('Location: /hutech-coffee/cart');
    }

    /**
     * Trả về kết quả thanh toán
     * @return void
     */
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
              $this->saveBill($_GET['vnp_TxnRef'], 'vnpay', $_GET['vnp_Amount'] / 100, date('Y-m-d H:i:s', strtotime($_GET['vnp_PayDate'])));
        }

        # Huỷ toàn bộ giỏ hàng
        unset($_SESSION['cart']);
        unset($_SESSION['total']);
        unset($_SESSION['discount']);
        unset($_SESSION['value']);
        unset($_SESSION['discount_error']);
        unset($_SESSION['error']);
        setcookie('cart', '', time() - 86400, '/');
        setcookie('discount', '', time() - 86400, '/');

        require_once 'Views/Coffee/Payment.php';
    }

    /**
     * Xử lý thanh toán bằng VNPAY
     * @return never
     */
    private function vnpay(): never
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

        $inputData = [
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

        # Tạo chữ ký điện tử
        $vnpSecureHash =   hash_hmac('sha512', $hashData, $vnp_HashSecret);
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;

        header('Location: ' . $vnp_Url);
        die();
    }

    /**
     * Xử lý thanh toán bằng Stripe
     * @return void
     */
    private function striped(): void
    {
        $_SESSION['payment_error'] = 'Stripe đang được phát triển';
        header('Location: /hutech-coffee/cart');
    }

    /**
     * Xử lý thanh toán bằng Paypal
     * @return void
     */
    private function paypal(): void
    {
        $_SESSION['payment_error'] = 'Paypal đang được phát triển';
        header('Location: /hutech-coffee/cart');
    }

    /**
     * Gửi email thông tin đơn hàng
     * @param $email
     * @param $id
     * @param $total
     * @param $payment_date
     * @param $payment_method
     * @return void
     */
    private function sendEmailInvoice($email, $id, $total, $payment_date, $payment_method): void
    {
        $to = $email;
        $subject = 'Thông tin đơn hàng';
        $message = file_get_contents('./Views/Templates/EmailInvoice.php');

        $headers = [
            # Địa chỉ email của người gửi
            'From' => 'Hutech Coffee <nguyenxuannhan.dev@gmail.com>',
            # Địa chỉ email trả lời
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

    /**
     * Lưu thông tin đơn hàng vào database
     * @param $id
     * @param $payment
     * @param $total
     * @param $payment_date
     * @return void
     */
    private function saveBill($id, $payment, $total, $payment_date): void
    {
        $paymentMethod = match ($payment) {
            'striped' => PaymentMethod::STIPE,
            'paypal' => PaymentMethod::PAYPAL,
            'vnpay' => PaymentMethod::VNPAY,
            default => PaymentMethod::CASH
        };

        $invoice = $this->invoiceFactory->create($id, $total, $payment_date, $paymentMethod->value);

        $this->invoiceService->create($invoice);

        $cartData = json_decode(base64_decode($_COOKIE['cart']), true);

        foreach ($cartData as $coffee) {
            $itemInvoice = $this->itemInvoiceFactory->create($id, $coffee['id'], $coffee['quantity']);
            $this->itemInvoiceService->create($itemInvoice);
        }

        $this->sendEmailInvoice($_POST['email'] ?? '', $id, $total, $payment_date, $paymentMethod->value);

        header('Location: /hutech-coffee/cart');
    }
}