<?php

declare(strict_types=1);

namespace Hutech\Factories;

use Hutech\Models\ItemInvoice;

readonly class ItemInvoiceFactory
{
    public static function create($invoice_id, $product_id, $quantity) : ItemInvoice
    {
        return new ItemInvoice((int) $invoice_id, (int) $product_id, (int) $quantity);
    }
}