<?php

declare(strict_types=1);

use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


require dirname(__DIR__) . '/vendor/autoload.php';

$app = AppFactory::create();


$app->get('/api/products', function (Request $request, Response $response, $args) {

    $database = new App\Database;

    $repository = new App\Repositories\ProductRepository($database);

    $data = $repository->getAll();

    $response->getBody()->write(json_encode($data));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
