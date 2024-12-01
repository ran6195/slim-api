<?php

declare(strict_types=1);

namespace App;

use PDO;

class Database
{

    public function __construct(private string $host, private string $dbname, private string  $user, private string  $password) {}
    public function getConnection(): PDO
    {
        $dsn = 'mysql:host=localhost;dbname=test;charset=utf8';

        return new PDO($dsn, 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}
