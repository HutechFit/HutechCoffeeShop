<?php

declare(strict_types=1);

namespace Hutech\Models;

use Symfony\Component\Validator\Constraints as Assert;

abstract class BaseModel
{
    #[Assert\Positive(message: 'Id must be positive')]
    public ?int $id;

    public function __construct(?int $id)
    {
        $this->id = $id;
    }
}
