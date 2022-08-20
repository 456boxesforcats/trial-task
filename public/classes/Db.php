<?php

namespace App\Classes;

use Simplon\Mysql\Mysql;
use Simplon\Mysql\PDOConnector;

class Db
{
    /**
     * @var Mysql
     */
    protected Mysql $connection;

    public function __construct()
    {
        $this->connection = $this->connect();
    }

    /**
     * @return Mysql
     * @throws \Exception
     */
    protected function connect()
    {
        $pdo = new PDOConnector(
            $_ENV['DB_HOST'],
            $_ENV['DB_USER'],
            $_ENV['DB_PASSWORD'],
            $_ENV['DB_DATABASE']
        );

        $pdoConnection = $pdo->connect('utf8mb4', []);

        return new Mysql($pdoConnection);
    }
}
