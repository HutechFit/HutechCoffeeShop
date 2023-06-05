<?php

declare(strict_types=1);

namespace Hutech\Routing;

class Route
{
    protected static array $routes = [];

    public static function add($url, $callback): void
    {
        self::$routes[trim($url, '/')] = $callback;
    }

    public static function dispatch(): void
    {
        $url = trim($_GET['uri'] ?? '/', '/');

        $matched = false;

        foreach (self::$routes as $route => $callback) {
            if (preg_match("#^$route$#", $url, $params)) {
                array_shift($params);

                if (is_string($callback)) {
                    $callback = explode('@', $callback);
                    $controller = $callback[0];
                    $method = $callback[1];
                    $controllerPath = "./Controllers/$controller.php";

                    if (!file_exists($controllerPath) && !method_exists($controller, $method)) {
                        require_once './Views/Home/404.php';
                        return;
                    }

                    require_once $controllerPath;
                    call_user_func_array([new $controller(), $method], array_values($params));
                } else {
                    call_user_func_array($callback, array_values($params));
                }

                $matched = true;
                break;
            }
        }

        if (!$matched) {
            require_once './Views/Home/404.php';
        }
    }
}
