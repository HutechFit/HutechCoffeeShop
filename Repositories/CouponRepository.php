<?php

declare(strict_types=1);

namespace Hutech\Repositories;

include_once './Repositories/BaseRepository.php';

use PDO;

class CouponRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('Coupon');
    }

    public function isExistCode($value): bool
    {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table WHERE value = :value");
        $stmt->execute(['value' => $value]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result !== false;
    }
}
