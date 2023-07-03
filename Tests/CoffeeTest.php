<?php

declare(strict_types=1);

use Hutech\Exceptions\InvalidRoute;
use PHPUnit\Framework\TestCase;

class CoffeeTest extends TestCase
{
    public function testCoffee()
    {
        $this->expectException(InvalidRoute::class);
        $this->expectExceptionMessage('Invalid route');
        $this->expectExceptionCode(500);
        throw new InvalidRoute();
    }

    public function testPasswordRegex()
    {
        $this->assertMatchesRegularExpression('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', 'Password1');
    }
}