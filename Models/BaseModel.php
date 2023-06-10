<?php

declare(strict_types=1);

namespace Hutech\Models;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

abstract class BaseModel
{
    #[Id, Column(type: Types::INTEGER), GeneratedValue]
    public int $id;

    /**
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }
}
