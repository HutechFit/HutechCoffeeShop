<?php

declare(strict_types=1);

namespace Hutech\Models;

class ItemInvoice
{
    public int $product_id;
    public int $invoice_id;
    public int $quantity;

    public function __construct($invoice_id, $product_id, $quantity)
    {
        $this->product_id = $product_id;
        $this->invoice_id = $invoice_id;
        $this->quantity = $quantity;
    }

    public function __destruct()
    {
        $this->product_id = 0;
        $this->invoice_id = 0;
        $this->quantity = 0;
    }
}