<?php

declare(strict_types=1);

namespace Hutech\Factories;

use Hutech\Models\Invoice;

readonly class InvoiceFactory
{
    public static function create($id, $total, $payment_date, $payment_method, $coupon_id = null): Invoice
    {
        return new Invoice((int)$id, (float)$total, $payment_date, $payment_method, (int) $coupon_id);
    }
}