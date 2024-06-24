<?php
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once "vendor/autoload.php";

$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: array(__DIR__ . "/src/model"),
    isDevMode: true,
);

Dotenv\Dotenv::createImmutable(__DIR__)->safeLoad();

$connection = DriverManager::getConnection([
    'driver' => 'pdo_pgsql',
    'host' => $_ENV['POSTGRES_HOST'],
    'port' => $_ENV['POSTGRES_PORT'],
    'user' => $_ENV['POSTGRES_USER'],
    'password' => $_ENV['POSTGRES_PASSWORD'],
    'dbname' => $_ENV['POSTGRES_DB'],
], $config);

$entityManager = new EntityManager($connection, $config);
