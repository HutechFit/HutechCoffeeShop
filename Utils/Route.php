<?php

declare(strict_types=1);

namespace Hutech\Utils;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionException;

class Route extends Container
{
    private array $routes = [];
    private array $middleware = [];

    public function setRoute($uri, $action): static
    {
        $this->routes[$uri] = $action;
        return $this;
    }

    public function addMiddleware($middleware): static
    {
        $this->middleware[] = $middleware;
        return $this;
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws ReflectionException
     */
    public function run(): void
    {
        $uri = str_replace('/' . str_replace('/', '', explode('/', $_SERVER['REQUEST_URI'])[1]), '', $_SERVER['REQUEST_URI']);

        if (str_contains($uri, '?')) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }

        if (array_key_exists($uri, $this->routes)) {

            $action = $this->routes[$uri];

            if (is_array($action)) {
                $controller = $action[0];
                $method = $action[1];

                if (!class_exists($controller) || !method_exists($controller, $method)) {
                    require_once './Views/Home/404.php';
                    die;
                }

                $this->register($controller, $controller);
                $instance = $this->get($controller);
                $instance->$method();
            } else {
                if (is_callable($action)) {
                    $callbackId = get_class((object)$action) . "_" . uniqid();
                    $this->register($callbackId, $action);
                    $this->get($callbackId);
                }
            }
        } else {
            require_once './Views/Home/404.php';
        }
    }
}
