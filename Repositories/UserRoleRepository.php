<?php

declare(strict_types=1);

namespace Hutech\Repositories;

class UserRoleRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('User_Role');
    }

    public function add($user_role): void
    {
        $this->insert($user_role);
    }

    public function getRoleByUserId($user_id): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table WHERE user_id = '$user_id'");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}