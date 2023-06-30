<?php

declare(strict_types=1);

namespace Hutech\Models;

use DateTime;

class Invoice extends BaseModel
{
    public float $total;

    public string $payment_date;

    public string $payment_method;

    public ?int $coupon_id;

    public function __construct($id, $total, $payment_date, $payment_method, $coupon_id)
    {
        parent::__construct($id);
        $this->total = $total;
        $this->payment_date = $payment_date;
        $this->payment_method = $payment_method;
        $this->coupon_id = $coupon_id;
    }

    public function __destruct()
    {
        parent::__destruct();
        $this->total = 0;
        $this->payment_date = (new DateTime())->format('Y-m-d H:i:s');
        $this->payment_method = '';
        $this->coupon_id = 0;
    }
}