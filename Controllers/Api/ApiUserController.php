<?php

declare(strict_types=1);

namespace Hutech\Controllers\Api;

use Exception;
use Firebase\JWT\JWT;
use Hutech\Enum\LoginProvider;
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
        $this->validMethod('POST');
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

    #[Post(
        path: '/api/v1/send-forgot-password',
        summary: 'Gửi email khôi phục mật khẩu',
        tags: ['User'],
        responses: [
            new Response(response: '200', description: 'Đăng ký thành công'),
            new Response(response: '400', description: 'Email không hợp lệ'),
            new Response(response: '405', description: 'Phương thức không được hỗ trợ')
        ]
    )]
    public function sendForgotPassword(): void
    {
        $this->validMethod('POST');
        $input = json_decode(file_get_contents('php://input'), true);
        $email = htmlspecialchars($input['Email'], ENT_QUOTES, 'UTF-8');
        $id = $this->userService->getUser($email)->id;

        if (!$id) {
            http_response_code(400);
            echo json_encode(['status' => false, 'message' => 'Email không hợp lệ'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $provider = $this->providerService->getProviderByEmail($email);

        if (is_null($provider->token)) {
            http_response_code(400);
            echo json_encode(['status' => false, 'message' => 'Token không hợp lệ'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $subject = 'Khôi phục mật khẩu';
        $message = file_get_contents('./Views/Templates/EmailForgotPassword.php');

        $headers = [
            'From' => 'Hutech Coffee <nguyenxuannhan.dev@gmail.com>',
            'Reply-To' => 'nd.anh@hutech.edu.vn',
            'Content-type' => 'text/html; charset=UTF-8',
            'MIME-Version' => '1.0',
            'X-Priority' => '1',
            'X-Mailer' => 'PHP/' . phpversion()
        ];

        $message = str_replace('{{id}}', $id, $message);
        $message = str_replace('{{token}}', $provider->token, $message);

        $success = mail($email, $subject, $message, $headers);

        if (!$success) {
            http_response_code(500);
            echo json_encode(['status' => false, 'message' => 'Gửi email thất bại'], JSON_UNESCAPED_UNICODE);
            exit;
        } else{
            echo json_encode(['status' => true, 'message' => 'Gửi email thành công'], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * @throws Exception
     */
    #[Post(
        path: '/api/v1/register',
        summary: 'Đăng ký',
        tags: ['User'],
        responses: [
            new Response(response: '200', description: 'Đăng ký thành công'),
            new Response(response: '400', description: 'Email đã tồn tại'),
            new Response(response: '405', description: 'Phương thức không được hỗ trợ')
        ]
    )]
    public function addUser(): void
    {
        $this->validMethod('POST');
        $input = json_decode(file_get_contents('php://input'), true);
        $id = uniqid('user_');
        $full_name = htmlspecialchars( $input['Name'], ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars( $input['Email'], ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars( $input['Password'], ENT_QUOTES, 'UTF-8');

        if ($password !==  $input['RePassword']) {
            http_response_code(400);
            echo json_encode(['status' => false, 'message' => 'Mật khẩu không khớp'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $password = password_hash($password, PASSWORD_ARGON2ID);

        $user = $this->userFactory->create($id, $full_name, $email, $password);

        if (!$this->validate($user)) {
            http_response_code(400);
            echo json_encode(['status' => false, $_SESSION['errors']], JSON_UNESCAPED_UNICODE);
            unset($_SESSION['errors']);
            exit;
        }

        $this->userService->add($user);

        $token = bin2hex(random_bytes(SODIUM_CRYPTO_SECRETBOX_KEYBYTES));

        $this->providerService->add(
            $this->providerFactory->create(
                user_id: $id,
                name: LoginProvider::LOCAL->name,
                token: $token,
                description: LoginProvider::LOCAL->value
            )
        );

        $this->userRoleService->add(
            $this->userRoleFactory->create(
                user_id: $id,
                role_id: Role::USER->value
            )
        );

        $this->sendVerifyEmail($id, $email, $token);

        echo json_encode(['status' => true, 'message' => 'Đăng ký thành công'], JSON_UNESCAPED_UNICODE);
    }

    private function sendVerifyEmail($id, $email, $token): void
    {
        $to = $email;
        $subject = 'Xác thực tài khoản';
        $message = file_get_contents('./Views/Templates/EmailVerify.php');

        $headers = [
            'From' => 'Hutech Coffee <nguyenxuannhan.dev@gmail.com>',
            'Reply-To' => 'nd.anh@hutech.edu.vn',
            'Content-type' => 'text/html; charset=UTF-8',
            'MIME-Version' => '1.0',
            'X-Priority' => '1',
            'X-Mailer' => 'PHP/' . phpversion()
        ];

        $message = str_replace('{{id}}', $id, $message);
        $message = str_replace('{{token}}', $token, $message);

        $success = mail($to, $subject, $message, $headers);

        if (!$success) {
            $errorMessage = error_get_last()['message'];
            http_response_code(500);
            echo json_encode(['status' => false, 'message' => $errorMessage], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    #[Post(
        path: '/api/v1/resend',
        summary: 'Gửi lại email xác thực',
        tags: ['User'],
        responses: [
            new Response(response: '200', description: 'Gửi lại email thành công'),
            new Response(response: '400', description: 'Email không tồn tại'),
            new Response(response: '405', description: 'Phương thức không được hỗ trợ')
        ]
    )]
    public function resendEmail(): void
    {
        $this->validMethod('POST');
        $input = json_decode(file_get_contents('php://input'), true);
        $email = htmlspecialchars($input['Email'], ENT_QUOTES, 'UTF-8');

        $provider = $this->providerService->getProviderByEmail($email);

        if (is_null($provider->token)) {
            http_response_code(400);
            echo json_encode(['status' => false, 'message' => 'Tài khoản đã được xác thực'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $this->sendVerifyEmail($this->userService->getUser($email)->id, $email, $provider->token);
    }

    private function validate($user): bool
    {
        if (!strlen($user->full_name) || strlen($user->full_name) > 50) {
            $errors[] = 'Họ tên không được để trống và không quá 50 ký tự';
        }

        if (!strlen($user->email) || strlen($user->email) > 50) {
            $errors[] = ['Email không được để trống và không quá 50 ký tự'];
        }

        if (!filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = ['Email không hợp lệ'];
        }

        if (!is_null($this->userService->getUser($user->email))) {
            $errors[] = ['Email đã tồn tại'];
        }

        if (!filter_var(
            $user->password,
            FILTER_VALIDATE_REGEXP,
            ['options' => [
                'regexp' => '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/'
            ]
            ])) {
            $errors[] = 'Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ và số';
        }

        if (count($errors)) {
            $_SESSION['errors'] = $errors;
            return false;
        }

        return true;
    }
}