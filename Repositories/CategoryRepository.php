<?php

declare(strict_types=1);

namespace Hutech\Repositories;

class CategoryRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('Category');
    }

    public function findAll(): ?array
    {
        return $this->getAll();
    }

    public function findById($id): ?object
    {
        return $this->getById($id);
    }

    public function add($category): void
    {
        $this->insert($category);
    }

    public function modify($category): void
    {
        $this->update($category);
    }

    public function remove($id): void
    {
        $this->delete($id);
    }
}