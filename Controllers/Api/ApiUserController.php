<?php

namespace Hutech\Controllers\Api;

use Firebase\JWT\JWT;
use Hutech\Enum\Role;
use Hutech\Factories\ProviderFactory;
use Hutech\Factories\UserFactory;
use Hutech\Factories\UserRoleFactory;
use Hutech\Services\ProviderService;
use Hutech\Services\UserRoleService;
use Hutech\Services\UserService;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Response;

class ApiUserController extends ApiBaseController
{
    public function __construct(
        protected UserService     $userService,
        protected UserFactory     $userFactory,
        protected ProviderService $providerService,
        protected ProviderFactory $providerFactory,
        protected UserRoleService $userRoleService,
        protected UserRoleFactory $userRoleFactory)
    {
    }

    #[Post(
        path: '/api/v1/login',
        summary: 'Đăng nhập',
        tags: ['User'],
        responses: [
            new Response(response: '200', description: 'Đăng nhập thành công'),
            new Response(response: '400', description: 'Email hoặc mật khẩu không chính xác'),
            new Response(response: '400', description: 'Tài khoản chưa được xác thực'),
            new Response(response: '405', description: 'Phương thức không được hỗ trợ')
        ]
    )]
    public function getToken(): void
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $email = htmlspecialchars($input["Email"], ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars($input["Password"], ENT_QUOTES, 'UTF-8');

        $user = $this->userService->getUser($email);

        if (!$user || !password_verify($password, $user->password)) {
            http_response_code(400);
            echo json_encode(['status' => false, 'message' => 'Email hoặc mật khẩu không chính xác'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        if (!$user->is_verify) {
            http_response_code(400);
            echo json_encode(['status' => false, 'message' => 'Tài khoản chưa được xác thực'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $user = [
            'id' => $user->id,
            'full_name' => $user->full_name,
            'email' => $user->email,
            'role' => array_map(function ($item) {
                return $item['role_id'] === 1
                    ? Role::ADMIN->name
                    : Role::USER->name;
            }, $this->userRoleService->getRoleByUserId($user->id))
        ];

        $key = 'hutech';
        $header = ['alg' => 'HS512', 'typ' => 'JWT'];
        $payload = [
            "iss" => "https://hutech-coffee.local",
            "aud" => "https://hutech-coffee.local",
            "iat" => time(),
            "exp" => time() + 3600,
            "data" => $user
        ];

        $jwt = JWT::encode($payload, $key, 'HS512', null, $header);

        echo json_encode([
            'status' => true,
            'message' => 'Đăng nhập thành công',
            'token' => $jwt,
            'expires' => time() + 3600
        ], JSON_UNESCAPED_UNICODE);

        setcookie('token', $jwt, time() + 3600, '/', '', false, true);
    }

    #[Post(
        path: '/api/v1/logout',
        summary: 'Đăng xuất',
        tags: ['User'],
        responses: [
            new Response(response: '200', description: 'Đăng xuất thành công'),
            new Response(response: '405', description: 'Phương thức không được hỗ trợ')
        ]
    )]
    public function logout(): void
    {
        setcookie('token', '', time() - 3600, '/', '', false, true);
        echo json_encode(['status' => true, 'message' => 'Đăng xuất thành công']);
    }
}