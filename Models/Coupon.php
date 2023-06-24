<?php

declare(strict_types=1);

namespace Hutech\Models;

class Coupon extends BaseModel
{
    public string $code;
    public string $expired;

    public float $value;

    public function __construct($id, $code, $expired, $value)
    {
        parent::__construct($id);
        $this->code = $code;
        $this->expired = $expired;
        $this->value = $value;
    }

    public function __destruct()
    {
        parent::__destruct();
        $this->code = '';
        $this->expired = '';
        $this->value = 0;
    }
}