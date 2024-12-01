<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Repositories\TableRepository;

class Tables
{
    public function __construct(private TableRepository $repository) {}

    public function show(Request $request, Response $response): Response
    {
        $data = $this->repository->getAllTables();

        $response->getBody()->write(json_encode($data));

        return $response;
    }

    public function showWithFields(Request $request, Response $response): Response
    {
        $data = $this->repository->getAllTablesWithFields();

        $response->getBody()->write(json_encode($data));

        return $response;
    }

    public function getTable(Request $request, Response $response, string $name): Response
    {
        $table = $name;
        $data = $this->repository->getTable($table);

        $response->getBody()->write(json_encode($data));

        return $response;
    }
}
