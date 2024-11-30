<?php

declare(strict_types=1);

namespace App;

use PDO;

class Database
{
    public function getConnection(): PDO
    {
        $dsn = 'mysql:host=localhost;dbname=slimapi;charset=utf8';

        return new PDO($dsn, 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}
