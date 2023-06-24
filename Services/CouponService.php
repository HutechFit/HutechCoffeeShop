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

    public function isExistCoupon($value): bool
    {
        return $this->couponRepository->isExistCode($value);
    }
}