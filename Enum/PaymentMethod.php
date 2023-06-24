<?php

declare(strict_types=1);

namespace Hutech\Enum;

enum PaymentMethod: string
{
    case CASH = 'Tiền mặt';
    case VNPAY = 'Ví điện tử VNPAY';
    case STIPE = 'Cổng thanh toán Stripe';
    case PAYPAL = 'Dịch vụ thanh toán PayPal';
}
