<?php

declare(strict_types=1);

namespace Hutech\Enum;

enum Role: int
{
    case ADMIN = 1;
    case USER = 2;
}
