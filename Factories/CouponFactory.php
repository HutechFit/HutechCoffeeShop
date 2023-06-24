<?php

declare(strict_types=1);

namespace Hutech\Factories;

use Hutech\Models\Coupon;

readonly class CouponFactory
{
    public static function create($id, $code, $expired, $value): Coupon
    {
        return new Coupon((int) $id, $code, $expired, (float) $value);
    }
}