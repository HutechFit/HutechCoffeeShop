<?php

declare(strict_types=1);

namespace Hutech\Utils;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
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

        if (str_contains($uri, '/api')) {
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
            header("Access-Control-Max-Age: 3600");
            header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

            if (!array_key_exists($uri, $this->routes) ||
                !class_exists($this->routes[$uri][0]) ||
                !method_exists($this->routes[$uri][0], $this->routes[$uri][1])) {
                http_response_code(404);
                echo json_encode('URL không hợp lệ', JSON_UNESCAPED_UNICODE);
                exit;
            }
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

                    if (!str_contains($uri, '/api')) {
                        if (!isset($_SESSION['user'])) {
                            header('Refresh: 0; url=/login');
                            exit;
                        }

                        if (!array_map(fn($role) => in_array($role, $_SESSION['user']['role']), $roles)) {
                            require_once './Views/Home/403.php';
                            exit;
                        }
                    }
                    else {
                        if (!isset(getallheaders()['authorization']) && !isset($_COOKIE['token'])) {
                            http_response_code(401);
                            echo json_encode(['message' => 'Bạn chưa đăng nhập'], JSON_UNESCAPED_UNICODE);
                            exit;
                        }

                        $decoded = JWT::decode(
                            trim(substr(getallheaders()['authorization'], 7)) ?? $_COOKIE['token'],
                            new Key('hutech', 'HS512')
                        );

                        if ($decoded->exp < time()) {
                            http_response_code(401);
                            echo json_encode(['message' => 'Phiên đăng nhập đã hết hạn']);
                            exit;
                        }

                        if (!array_map(fn($role) => in_array($role, $decoded->data->role), $roles)) {
                            http_response_code(403);
                            echo json_encode(['message' => 'Bạn không có quyền truy cập'], JSON_UNESCAPED_UNICODE);
                            exit;
                        }
                    }
                }

                if (isset($_SESSION['user']) && ($uri === '/login' || $uri === '/register')) {
                    header('Refresh: 0; url=/');
                    exit;
                }

                if ((isset($_COOKIE['token']) || isset(getallheaders()['Authorization'])) &&
                    ($uri === '/login' || $uri === '/register')) {
                    echo json_encode(['message' => 'Bạn đã đăng nhập'], JSON_UNESCAPED_UNICODE);
                    exit;
                }

                $this->register($controller, $controller);
                $instance = $this->get($controller);
                $instance->$method();
            } else {
                if(!str_contains($uri, '/api')) {
                    require_once './Views/Home/404.php';
                } else {
                    http_response_code(404);
                    echo json_encode('URL không hợp lệ', JSON_UNESCAPED_UNICODE);
                    exit;
                }
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
