<?php

declare(strict_types=1);

namespace Hutech\Controllers;

use DateTime;
use Exception;
use Hutech\Enum\PaymentMethod;
use Hutech\Factories\InvoiceFactory;
use Hutech\Factories\ItemInvoiceFactory;
use Hutech\Services\InvoiceService;
use Hutech\Services\ItemInvoiceService;

include_once './Services/InvoiceService.php';
include_once './Services/ItemInvoiceService.php';

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
date_default_timezone_set('Asia/Ho_Chi_Minh');

readonly class PaymentController
{

    public function __construct(
        protected InvoiceService $invoiceService,
        protected ItemInvoiceService $itemInvoiceService,
        protected InvoiceFactory $invoiceFactory,
        protected ItemInvoiceFactory $itemInvoiceFactory
    )
    {
    }

    public function payment(): void
    {
        $id = rand(1, 1000000);

        $paymentMethod = match ($_POST['payment-method']) {
            'striped' => PaymentMethod::STIPE,
            'paypal' => PaymentMethod::PAYPAL,
            'vnpay' => PaymentMethod::VNPAY,
            default => PaymentMethod::CASH
        };

        $total = $_POST['amount'];
        $payment_date = (new DateTime())->format('Y-m-d H:i:s');

        $invoice = $this->invoiceFactory->create($id, $total, $payment_date, $paymentMethod->value);

        $this->invoiceService->create($invoice);

        $cartData = json_decode(base64_decode($_COOKIE['cart']), true);

        foreach ($cartData as $coffee) {
            $itemInvoice = $this->itemInvoiceFactory->create($id, $coffee['id'], $coffee['quantity']);
            $this->itemInvoiceService->create($itemInvoice);
        }

        $this->sendEmailInvoice($_POST['email'] ?? '', $id, $total, $payment_date, $paymentMethod->value);

        header('Location: /hutech-coffee/cart');


//        match ($_POST['payment-method']) {
//            'striped' => $this->striped(),
//            'paypal' => $this->paypal(),
//            'vnpay' => $this->vnpay(),
//            default => header('Location: /hutech-coffee/cart')
//        };
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

//        if ($secureHash == $vnp_SecureHash && $_GET['vnp_ResponseCode'] === '00') {
//              Lưu dữ liệu đơn hàng vào CSDL
//        }

        require_once 'Views/Coffee/Payment.php';
    }

    private function vnpay(): void
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
}