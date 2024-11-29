<?php

declare(strict_types=1);

use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require (__DIR__) . '/../vendor/autoload.php';

$app = AppFactory::create();


$app->get('/api/products',function(Request $request, Response $response, $args){

    $body = json_encode([
        'name' => 'Product 1',
        'price' => 100
    ]);

    $response->getBody()->write($body);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
