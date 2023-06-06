<?php

declare(strict_types=1);

class CoffeeController
{
    public function getAll() : void
    {
        require_once './Views/Coffee/Manager.php';
    }

    public function add(): void
    {
        require_once './Views/Coffee/Add.php';
    }
}
