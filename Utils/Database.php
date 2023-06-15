<?php

declare(strict_types=1);

use Dotenv\Dotenv;

$pdo = createDatabaseConnection();

function createDatabaseConnection(): PDO
{
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();

    $dbDriver = $_ENV['DB_DRIVER'];
    $dbHost = $_ENV['DB_HOST'] ?? 'localhost';
    $dbName = $_ENV['DB_DATABASE'];
    $dbUser = $_ENV['DB_USER'];
    $dbPassword = $_ENV['DB_PASSWORD'] ?? '';

    $dsn = "$dbDriver:host=$dbHost;dbname=$dbName";

    $pdo = new PDO($dsn, $dbUser, $dbPassword) or die('Không thể kết nối đến database');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;
}