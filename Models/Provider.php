<?php

declare(strict_types=1);

namespace Hutech\Models;

class Provider
{
    public string $user_id;
    public string $name;
    public string $token;
    public string $description;

    public function __construct($user_id, $name, $token, $description)
    {
        $this->user_id = $user_id;
        $this->name = $name;
        $this->token = $token;
        $this->description = $description;
    }

    public function __destruct()
    {
        $this->user_id = '';
        $this->name = '';
        $this->token = '';
        $this->description = '';
    }
}