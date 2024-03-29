<?php

declare(strict_types=1);

namespace Hutech\Repositories;

use Exception;
use Hutech\Utils\Database;
use PDO;

abstract class BaseRepository
{
    public Database $pdo;

    public function __construct(protected $table)
    {
        $this->pdo = new Database();
    }

    public function getAll(): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id): ?object
    {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function insert($data): void
    {
        $this->executeTransaction(function () use ($data) {
            $fields = implode(', ', array_keys(get_object_vars($data)));
            $values = ':' . implode(', :', array_keys(get_object_vars($data)));
            $stmt = $this->pdo->prepare("INSERT INTO $this->table ($fields) VALUES ($values)");
            $stmt->execute(get_object_vars($data));
        });
    }

    private function executeTransaction($callback): void
    {
        $this->pdo->beginTransaction();

        try {
            $callback();
            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            print_r('Đã có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function update($data): void
    {
        $this->executeTransaction(function () use ($data) {
            $fields = implode(' = ?, ', array_keys(get_object_vars($data)));
            $fields .= ' = ?';
            $values = array_values(get_object_vars($data));
            $values[] = $data->id;
            $stmt = $this->pdo->prepare("UPDATE $this->table SET $fields WHERE id = ?");
            $stmt->execute($values);
        });
    }

    public function delete($id): void
    {
        $this->executeTransaction(function () use ($id) {
            $stmt = $this->pdo->prepare("DELETE FROM $this->table WHERE id = :id");
            $stmt->execute(['id' => $id]);
        });
    }
}