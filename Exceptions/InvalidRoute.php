<?php

declare(strict_types=1);

namespace Hutech\Exceptions;

use Exception;
use Throwable;

final class InvalidRoute extends Exception implements Throwable
{
    public function __construct($message = 'Invalid route', $code = 500, $previous = null)
    {
        parent::__construct($message, $code, $previous);
        print_r($this->getMessage());
    }
}