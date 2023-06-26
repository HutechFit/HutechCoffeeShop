<?php

namespace Hutech\Security;

use Exception;

class Csrf
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
            $token = bin2hex(random_bytes(32));
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