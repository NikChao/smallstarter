<?php

namespace Db;

class Persistence
{
    protected $pdo;

    public function __construct()
    {
        $host = 'localhost';
        $port = 5432;
        $dbname = 'oldschool';
        $user = 'postgres';

        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user";

        $pdo = new \PDO($dsn);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $this->pdo = $pdo;
    }

    public function execute(string $query, array $params): void
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
    }
}
