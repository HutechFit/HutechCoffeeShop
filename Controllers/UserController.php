<?php

declare(strict_types=1);

namespace Hutech\Controllers;

use Exception;
use Hutech\Enum\LoginProvider;
use Hutech\Factories\ProviderFactory;
use Hutech\Factories\UserFactory;
use Hutech\Services\ProviderService;
use Hutech\Services\UserService;

readonly class UserController
{

    public function __construct(
        protected UserService     $userService,
        protected UserFactory     $userFactory,
        protected ProviderService $providerService,
        protected ProviderFactory $providerFactory)
    {
    }

    public function login(): void
    {
        require_once 'Views/User/Login.php';
    }

    public function index(): void
    {
        require_once 'Views/User/Register.php';
    }

    /**
     * @throws Exception
     */
    public function addUser(): void
    {
        $id = uniqid('user_');
        $full_name = $_POST['Name'];
        $email = $_POST['Email'];
        $password = password_hash($_POST['Password'], PASSWORD_ARGON2ID);

        $user = $this->userFactory->create($id, $full_name, $email, $password);

        if (!$this->validate($user, $_POST['RePassword'])) {
            header('Location: /hutech-coffee/register');
            exit;
        }

        $this->userService->add($user);

        $this->providerService->add(
            $this->providerFactory->create(
                user_id: $id,
                name: LoginProvider::LOCAL->name,
                token: bin2hex(random_bytes(SODIUM_CRYPTO_SECRETBOX_KEYBYTES)),
                description: LoginProvider::LOCAL->value
            )
        );

        // handle send email verification here

        header('Location: /hutech-coffee/login');
    }

    private function validate($user, $confirmPassword): bool
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

        if (!filter_var(
            $user->password,
            FILTER_VALIDATE_REGEXP,
            ['options' => [
                'regexp' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/'
            ]
            ])) {
            $_SESSION['password_error'] = 'Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường và số';
        }

        if ($user->password !== $confirmPassword) {
            $_SESSION['password_confirm_error'] = 'Mật khẩu không khớp';
        }

        if (isset($_SESSION['full_name_error'])
            || isset($_SESSION['email_error'])
            || isset($_SESSION['password_error'])
            || isset($_SESSION['password_confirm_error'])) {
            return false;
        }

        return true;
    }
}
