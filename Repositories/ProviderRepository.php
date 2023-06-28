<?php

declare(strict_types=1);

namespace Hutech\Repositories;

use PDO;

class ProviderRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('Provider');
    }

    public function add($provider): void
    {
        $this->insert($provider);
    }

    public function isExistUser($id, $token): bool
    {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table WHERE user_id = :id AND token = :token");
        $stmt->execute(['id' => $id, 'token' => $token]);
        return $stmt->rowCount() > 0;
    }

    public function getProviderByEmail($email): object
    {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}