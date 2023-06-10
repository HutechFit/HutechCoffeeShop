<?php

declare(strict_types=1);

use Doctrine\DBAL\DriverManager;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Dotenv\Dotenv;

require_once './vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$migration = new PhpFile('migrations.php');

$paths = ['./Models'];

$param = [
    'dbname' => $_ENV['DB_DATABASE'],
    'user' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASSWORD'] ?? '',
    'host' => $_ENV['DB_HOST'],
    'driver' => $_ENV['DB_DRIVER'],
];

$config = ORMSetup::createAttributeMetadataConfiguration($paths, true);

try {
    $conn = DriverManager::getConnection($param, $config);
    $entityManager = new EntityManager($conn, $config);
    return DependencyFactory::fromEntityManager($migration, new ExistingEntityManager($entityManager));
} catch (Exception $e) {
    echo $e->getMessage();
}
