<?php

declare(strict_types=1);

namespace Hutech\Utils;

use Dotenv\Dotenv;
use PDO;

class Database extends PDO
{
    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $dbDriver = $_ENV['DB_DRIVER'];
        $dbHost = $_ENV['DB_HOST'] ?? 'localhost';
        $dbName = $_ENV['DB_DATABASE'];
        $dbUser = $_ENV['DB_USER'];
        $dbPassword = $_ENV['DB_PASSWORD'] ?? '';

        $dsn = "$dbDriver:host=$dbHost;dbname=$dbName";

        parent::__construct($dsn, $dbUser, $dbPassword);
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}
