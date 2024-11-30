<?php

declare(strict_types=1);

use App\Middleware\AddJsonResponseHeader;
use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use DI\ContainerBuilder;
use Slim\Handlers\Strategies\RequestResponseArgs;
use App\Controllers\ProductIndex;
use App\Controllers\Products;



define('APP_ROOT', dirname(__DIR__));

require APP_ROOT . '/vendor/autoload.php';


$buidler = new ContainerBuilder;

$container = $buidler->addDefinitions(require APP_ROOT . '/config/definitions.php')->build();


AppFactory::setContainer($container);

$app = AppFactory::create();

$collector = $app->getRouteCollector();
$collector->setDefaultInvocationStrategy(new RequestResponseArgs());

$app->addBodyParsingMiddleware();

$error_middleware = $app->addErrorMiddleware(true, true, true);

$error_handler = $error_middleware->getDefaultErrorHandler();
$error_handler->forceContentType('application/json');

$app->add(new AddJsonResponseHeader);

$app->get('/api/products', ProductIndex::class);

$app->get('/api/products/{id:[0-9]+}', Products::class . ':show')->add(App\Middleware\GetProduct::class);

$app->post('/api/products', [Products::class, 'create']);


$app->run();
