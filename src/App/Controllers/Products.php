<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Repositories\ProductRepository;



class Products
{
    public function __construct(private ProductRepository $repository) {}

    public function show(Request $request, Response $response, string $id): Response
    {
        $data = $request->getAttribute('product');

        $response->getBody()->write(json_encode($data));

        return $response;
    }
}
