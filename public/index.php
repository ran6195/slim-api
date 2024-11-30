<?php

declare(strict_types=1);

use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use DI\ContainerBuilder;
use Slim\Handlers\Strategies\RequestResponseArgs;


define('APP_ROOT', dirname(__DIR__));

require APP_ROOT . '/vendor/autoload.php';


$buidler = new ContainerBuilder;

$container = $buidler->addDefinitions(require APP_ROOT . '/config/definitions.php')->build();


AppFactory::setContainer($container);

$app = AppFactory::create();

$collector = $app->getRouteCollector();
$collector->setDefaultInvocationStrategy(new RequestResponseArgs());

$error_middleware = $app->addErrorMiddleware(true, true, true);

$error_handler = $error_middleware->getDefaultErrorHandler();
$error_handler->forceContentType('application/json');

$app->get('/api/products', function (Request $request, Response $response) {

    $repository = $this->get(App\Repositories\ProductRepository::class);

    $data = $repository->getAll();

    $response->getBody()->write(json_encode($data));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/api/products/{id:[0-9]+}', function (Request $request, Response $response, string $id) {

    $repository = $this->get(App\Repositories\ProductRepository::class);

    $data = $repository->getProductById((int)$id);

    if ($data === false) {
        throw new \Slim\Exception\HttpNotFoundException($request);
    }

    $response->getBody()->write(json_encode($data));

    return $response->withHeader('Content-Type', 'application/json');
});
$app->run();
