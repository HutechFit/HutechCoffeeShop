<?php

declare(strict_types=1);

namespace Hutech\Utils;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;
use ReflectionException;

class Container implements ContainerInterface
{
    private array $services = [];

    /**
     * @throws ContainerExceptionInterface
     * @throws ReflectionException
     * @throws NotFoundExceptionInterface
     */
    public function register($key, $value): static
    {
        $this->services[$key] = $this->resolveDependency($value);
        return $this;
    }

    /**
     * @throws ReflectionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function resolveDependency($item): mixed
    {
        if (is_callable($item)) {
            return $item();
        }

        return $this->getInstance(new ReflectionClass($item));
    }

    /**
     * @throws ReflectionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function getInstance($item): mixed
    {
        $constructor = $item->getConstructor();

        if (is_null($constructor) || $constructor->getNumberOfRequiredParameters() === 0) {
            return $item->newInstance();
        }

        $params = [];

        foreach ($constructor->getParameters() as $param) {
            $params = $param->getType()
                ? [...$params, $this->get($param->getType()->getName())]
                : $params;
        }

        return $item->newInstanceArgs($params);
    }

    /**
     * @throws ReflectionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function get($id): mixed
    {
        if (!$this->has($id)) {
            $this->services[$id] = $this->resolveDependency($id);
        }

        return $this->services[$id];
    }

    public function has($id): bool
    {
        return isset($this->services[$id]);
    }
}
