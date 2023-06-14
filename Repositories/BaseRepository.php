<?php

declare(strict_types=1);

namespace Hutech\Repositories;

use Exception;
use PDO;

include_once './Utils/Database.php';

abstract class BaseRepository
{
    private PDO $pdo;

    public function __construct(protected $table)
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function getAll() : ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) : ?object
    {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function insert($data): void
    {
        $this->pdo->beginTransaction();

        try {
            $fields = implode(', ', array_keys(get_object_vars($data)));
            $values = ':' . implode(', :', array_keys(get_object_vars($data)));
            $stmt = $this->pdo->prepare("INSERT INTO $this->table ($fields) VALUES ($values)");
            $stmt->execute(get_object_vars($data));

            $this->pdo->commit();
        } catch (Exception) {
            $this->pdo->rollBack();
        }
    }

    public function update($data) : void
    {
        $this->pdo->beginTransaction();

        try {
            $fields = implode(', ', array_keys(get_object_vars($data)));
            $values = ':' . implode(', :', array_keys(get_object_vars($data)));
            $stmt = $this->pdo->prepare("UPDATE $this->table SET $fields = $values WHERE id = :id");
            $stmt->execute(get_object_vars($data));

            $this->pdo->commit();
        } catch (Exception) {
            $this->pdo->rollBack();
        }
    }

    public function delete($id) : void
    {
        $this->pdo->beginTransaction();

        try {
            $stmt = $this->pdo->prepare("DELETE FROM $this->table WHERE id = :id");
            $stmt->execute(['id' => $id]);

            $this->pdo->commit();
        } catch (Exception) {
            $this->pdo->rollBack();
        }
    }
}