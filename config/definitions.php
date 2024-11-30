<?php

use App\Database;

return [
    Database::class => function ($container) {
        return new Database(
            host: 'localhost',
            dbname: 'slimapi',
            user: 'root',
            password: ''
        );
    }
];
