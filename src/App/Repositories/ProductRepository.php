<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Database;
use PDO;

class ProductRepository
{

    public function __construct(private Database $database) {}

    public function getAll(): array
    {

        $pdo = $this->database->getConnection();

        $stmt = $pdo->query('SELECT * FROM products');

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById(int $id): array|bool
    {

        $pdo = $this->database->getConnection();

        $stmt = $pdo->prepare('SELECT * FROM products WHERE id = :id');
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data): string
    {

        $pdo = $this->database->getConnection();

        $sql = "INSERT INTO products (name, description,size) VALUES (:name, :description, :size)";

        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);

        if (isset($data['description'])) {
            $stmt->bindValue(':description', $data['description'], PDO::PARAM_STR);
        } else
            $stmt->bindValue(':description', null, PDO::PARAM_NULL);

        $stmt->bindValue(':size', $data['size'], PDO::PARAM_INT);

        $stmt->execute();

        return $pdo->lastInsertId();
    }
}
