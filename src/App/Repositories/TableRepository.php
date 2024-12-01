<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Database;
use Exception;
use PDO;
use PDOException;

class TableRepository
{
    public function __construct(private Database $database) {}

    public function getAllTables(): array
    {
        try {
            $pdo = $this->database->getConnection();
            $stmt = $pdo->query("SHOW TABLES");
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            throw new Exception("Error retrieving tables: " . $e->getMessage());
        }
    }

    public function getAllTablesWithFields(): array
    {
        try {
            $pdo = $this->database->getConnection();
            $stmt = $pdo->query("SHOW TABLES");
            $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
            $data = [];
            foreach ($tables as $table) {
                $stmt = $pdo->query("DESCRIBE $table");
                $data[$table] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            return $data;
        } catch (PDOException $e) {
            throw new Exception("Error retrieving tables: " . $e->getMessage());
        }
    }

    public function getTable(string $table): array
    {
        try {
            $pdo = $this->database->getConnection();
            $stmt = $pdo->query("DESCRIBE $table");

            $fields = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $stmt = $pdo->query("SELECT * FROM $table");

            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $data = [
                "fields" => $fields,
                "records" => $records
            ];

            return $data;
        } catch (PDOException $e) {
            throw new Exception("Error retrieving table: " . $e->getMessage());
        }
    }
}
