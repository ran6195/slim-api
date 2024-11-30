<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;
use App\Repositories\ProductRepository;
use \Slim\Exception\HttpNotFoundException;


class GetProduct
{

    public function __construct(private ProductRepository $repository) {}
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $routeContext = RouteContext::fromRequest($request);
        $route = $routeContext->getRoute();
        $id = $route->getArgument('id');

        $repository = $this->repository;
        $data = $repository->getProductById((int)$id);

        if ($data === false) {
            throw new HttpNotFoundException($request, 'Product not found');
        }

        $request = $request->withAttribute('product', $data);

        return $handler->handle($request);
    }
}
