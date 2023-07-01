<?php

declare(strict_types=1);

namespace Hutech\Security;

use Exception;

readonly class Csrf
{
    private string $token;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['csrf_token'])) {
            $token = bin2hex(
                random_bytes(SODIUM_CRYPTO_SECRETBOX_KEYBYTES)
            );
            $_SESSION['csrf_token'] = $token;
        }

        $this->token = $_SESSION['csrf_token'];
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function validateToken($token): bool
    {
        return $token === $this->token;
    }
}