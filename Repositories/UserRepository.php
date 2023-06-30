<?php

declare(strict_types=1);

namespace Hutech\Repositories;

class UserRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('User');
    }

    public function add($user): void
    {
        $this->insert($user);
    }

    public function getUser($email): object|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetchObject();
    }

    public function setVerify($id): void
    {
        $stmt = $this->pdo->prepare("UPDATE $this->table SET is_verify = 1 WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    public function findById($id): object
    {
        return $this->getById($id);
    }

    public function changePassword($id, $password): void
    {
        $stmt = $this->pdo->prepare("UPDATE $this->table SET password = :password WHERE id = :id");
        $stmt->execute(['password' => $password, 'id' => $id]);
    }
}