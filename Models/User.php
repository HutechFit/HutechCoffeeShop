<?php

declare(strict_types=1);

namespace Hutech\Models;

class User
{
    public string $id;
    public string $full_name;

    public string $email;
    public string $password;
    public bool $is_verify;

    public function __construct($id, $full_name, $email, $password, $is_verify)
    {
        $this->id = $id;
        $this->full_name = $full_name;
        $this->email = $email;
        $this->password = $password;
        $this->is_verify = $is_verify;
    }

    public function __destruct()
    {
        $this->id = '';
        $this->full_name = '';
        $this->email = '';
        $this->password = '';
        $this->is_verify = false;
    }
}