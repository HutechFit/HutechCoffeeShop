<?php

declare(strict_types=1);

namespace Hutech\Services;

use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Hutech\Interfaces\ICoffeeRepository;
use Hutech\Repositories\CoffeeRepository;
use function DI\autowire;
use function DI\create;

class CoffeeService
{
    protected ICoffeeRepository $coffeeRepository;

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __construct()
    {
        $container = new Container();
        $container->set(ICoffeeRepository::class, create(CoffeeRepository::class));
        $container->set(CoffeeService::class, autowire(CoffeeService::class));
        $this->coffeeRepository = $container->get(ICoffeeRepository::class);
    }

    public function getAll(): array
	{
		return $this->coffeeRepository->getAll();
	}
}
