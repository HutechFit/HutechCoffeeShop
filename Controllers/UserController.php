<?php

declare(strict_types=1);

class UserController
{
    public function login(): void
    {
        require_once('Views/User/Login.php');
    }

    public function index(): void
    {
        require_once('Views/User/Register.php');
    }
}
