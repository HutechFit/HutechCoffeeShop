<?php

declare(strict_types=1);

namespace Hutech\Repositories;

use PDO;

include_once './Repositories/BaseRepository.php';

class CouponRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('Coupon');
    }

    public function getCouponByValue($value): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table WHERE code = :code");
        $stmt->execute(['code' => $value]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
