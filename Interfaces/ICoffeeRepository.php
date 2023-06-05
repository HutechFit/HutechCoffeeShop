<?php

declare(strict_types=1);

namespace Hutech\Interfaces;

interface ICoffeeRepository
{
	public function getAll(): array;
}
