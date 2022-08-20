<?php

require_once '../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Classes\Repositories\PropertyRepository;
use Simplon\Mysql\MysqlException;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$propertyRepository = new PropertyRepository();

try {
    $propertyRepository->saveAllFromApi();
} catch (MysqlException $e) {
    echo 'An error occurred: ' . $e->getMessage();
}
