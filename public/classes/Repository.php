<?php

namespace App\Classes;

use Simplon\Mysql\MysqlException;

class Repository extends Db
{
    /**
     * @var string
     */
    protected string $table;

    /**
     * @var string
     */
    protected string $class;

    /**
     * @return array
     * @throws \Exception
     */
    public function get(): array
    {
        $models = [];

        $query = 'SELECT * FROM `' . $this->table . '`';

        try {
            $rows = $this->connection->fetchRowMany($query);
        } catch (MysqlException $e) {
            return [];
        }

        if (empty($rows)) {
            return [];
        }

        foreach ($rows as $row) {
            $models[] = new $this->class($row);
        }

        return $models;
    }

    /**
     * @return int
     * @throws MysqlException
     */
    public function count(array $where = []): int
    {
        try {
            $result = $this->connection->fetchRow('SELECT COUNT(*) as `count` FROM ' . $this->table .
                ' WHERE 1 ' . $where['query'], $where['params']);
        } catch (MysqlException $e) {
            return 0;
        }

        return $result['count'];
    }

    /**
     * @param array $data
     * @return bool
     * @throws MysqlException
     */
    public function insertOrUpdate(array $data): bool
    {
        return (bool)$this->connection->replaceMany($this->table, $data);
    }
}
