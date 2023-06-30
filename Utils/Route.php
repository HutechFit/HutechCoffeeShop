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

    public function setRoute($uri, $action, $middleware = []): Route
    {
        $this->routes[$uri] = $action;
        $this->middleware[$uri] = $middleware;
        return $this;
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws ReflectionException
     */
    public function run(): void
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';

        if (str_contains($uri, '?')) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }

        if (!array_key_exists($uri, $this->routes)) {
            require_once './Views/Home/404.php';
        }

        $action = $this->routes[$uri];

        if (is_array($action)) {
            $controller = $action[0];
            $method = $action[1];

            if (class_exists($controller) && method_exists($controller, $method)) {
                if (!empty($this->middleware[$uri]) && array_keys($this->middleware[$uri])[0] === 'Auth') {
                    $roles = $this->middleware[$uri][array_keys($this->middleware[$uri])[0]];

                    if (!isset($_SESSION['user'])) {
                        header('Refresh: 0; url=/login');
                        exit;
                    }

//                    die(var_dump(array_map(fn($role) => in_array($role, $_SESSION['user']['role']), $roles)));

                    if (!array_map(fn($role) => in_array($role, $_SESSION['user']['role']), $roles)) {
                        require_once './Views/Home/403.php';
                        exit;
                    }
                }

                if (isset($_SESSION['user']) && $uri === '/login') {
                    header('Refresh: 0; url=/');
                    exit;
                }

                $this->register($controller, $controller);
                $instance = $this->get($controller);
                $instance->$method();
            } else {
                require_once './Views/Home/404.php';
            }

        } else {
            if (is_callable($action)) {
                $callbackId = get_class((object)$action) . "_" . uniqid();
                $this->register($callbackId, $action);
                $this->get($callbackId);
            }
        }
    }
}
