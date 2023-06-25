<?php

declare(strict_types=1);

namespace Hutech\Services;

use Hutech\Repositories\CouponRepository;

include_once './Repositories/CouponRepository.php';

readonly class CouponService
{
    public function __construct(protected CouponRepository $couponRepository)
    {
    }

    public function getCoupon($value): ?array
    {
        return $this->couponRepository->getCouponByValue($value);
    }
}