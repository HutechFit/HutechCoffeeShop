<?php

declare(strict_types=1);

namespace Hutech\Controllers;

use Exception;
use Hutech\Enum\LoginProvider;
use Hutech\Enum\Role;
use Hutech\Factories\ProviderFactory;
use Hutech\Factories\UserFactory;
use Hutech\Factories\UserRoleFactory;
use Hutech\Security\Csrf;
use Hutech\Services\ProviderService;
use Hutech\Services\UserRoleService;
use Hutech\Services\UserService;

readonly class UserController
{

    public function __construct(
        protected UserService     $userService,
        protected UserFactory     $userFactory,
        protected ProviderService $providerService,
        protected ProviderFactory $providerFactory,
        protected UserRoleService $userRoleService,
        protected UserRoleFactory $userRoleFactory,
        protected Csrf $csrf)
    {
    }

    public function login(): void
    {
        $token = $this->csrf->getToken();
        require_once 'Views/User/Login.php';
    }

    public function logout(): void
    {
        session_destroy();
        header('Location: /');
    }

    public function index(): void
    {
        $token = $this->csrf->getToken();
        require_once 'Views/User/Register.php';
    }

    /**
     * @throws Exception
     */
    public function addUser(): void
    {
        if (!isset($_POST['csrf_token']) || !$this->csrf->validateToken($_POST['csrf_token'])) {
            $_SESSION['csrf_error'] = 'Token không hợp lệ';
            header('Location: /hutech-coffee/register');
            exit;
        }

        $id = uniqid('user_');
        $full_name = $_POST['Name'];
        $email = $_POST['Email'];
        $password = $_POST['Password'];

        if ($password !== $_POST['RePassword']) {
            $_SESSION['password_confirm_error'] = 'Mật khẩu không khớp';
            header('Location: /hutech-coffee/register');
            exit;
        }

        $password = password_hash($password, PASSWORD_ARGON2ID);

        $user = $this->userFactory->create($id, $full_name, $email, $password);

        if (!$this->validate($user)) {
            header('Location: /hutech-coffee/register');
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

        header('Location: /hutech-coffee/login');
    }

    private function validate($user): bool
    {
        if (!strlen($user->full_name) || strlen($user->full_name) > 50) {
            $_SESSION['full_name_error'] = 'Họ tên không được để trống và không quá 50 ký tự';
        }

        if (!strlen($user->email) || strlen($user->email) > 50) {
            $_SESSION['email_error'] = ['Email không được để trống và không quá 50 ký tự'];
        }

        if (!filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['email_error'] = ['Email không hợp lệ'];
        }

        if (!is_null($this->userService->getUser($user->email))) {
            $_SESSION['email_error'] = ['Email đã tồn tại'];
        }

        if (!filter_var(
            $user->password,
            FILTER_VALIDATE_REGEXP,
            ['options' => [
                'regexp' => '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/'
            ]
            ])) {
            $_SESSION['password_error'] = 'Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ và số';
        }

        if (isset($_SESSION['full_name_error'])
            || isset($_SESSION['email_error'])
            || isset($_SESSION['password_error'])) {
            return false;
        }

        return true;
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
            $_SESSION['register_error'] = $errorMessage;
        }
    }

    public function verifyEmail(): void
    {
        $token = $_GET['token'] ?? '';
        $userId = $_GET['user_id'] ?? '';

        $isExistUser = $this->providerService->isExistUser($userId, $token);

        if ($isExistUser) {
            $this->userService->setVerify($userId);
        }

        require_once './Views/Coffee/Verify.php';
    }

    public function signin(): void
    {
        if (!isset($_POST['csrf_token']) || !$this->csrf->validateToken($_POST['csrf_token'])) {
            $_SESSION['csrf_error'] = 'Token không hợp lệ';
            header('Location: /hutech-coffee/register');
            exit;
        }

        $email = $_POST['Email'];
        $password = $_POST['Password'];

        $user = $this->userService->getUser($email);

        if (is_null($user) || !password_verify($password, $user->password)) {
            $_SESSION['account_error'] = 'Thông tin đăng nhập không chính xác';
            header('Location: /login');
            exit;
        }

        if (!$user->is_verify) {
            $_SESSION['verify_error'] = 'Tài khoản chưa được xác thực. Vui lòng kiểm tra email';
            header('Location: /login');
            exit;
        }

        $_SESSION['user'] = [
            'id' => $user->id,
            'full_name' => $user->full_name,
            'email' => $user->email,
            'role' => array_map(function ($item) {
                return $item['role_id'] === 1
                    ? Role::ADMIN->name
                    : Role::USER->name;
            }, $this->userRoleService->getRoleByUserId($user->id))
        ];

        header('Location: /');
    }

    public function resendEmail(): void
    {
        $email = $_POST['Email'];

        $provider = $this->providerService->getProviderByEmail($email);

        if (is_null($provider->token)) {
            $_SESSION['token_resend_error'] = 'Token không tồn tại';
            header('Location: /hutech-coffee/login');
            exit;
        }

        $this->sendVerifyEmail($this->userService->getUser($email)->id, $email, $provider->token);

        header('Location: /hutech-coffee/login');
    }
}
