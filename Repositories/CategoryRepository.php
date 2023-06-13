<?php

declare(strict_types=1);

namespace Hutech\Repositories;

include_once './Models/Category.php';


class CategoryRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('categories');
    }

    public function findAll(): ?array
    {
        return $this->getAll();
    }

    public function findById($id): ?object
    {
        return $this->getById($id);
    }

    public function add(object $category): void
    {
        $this->insert($category);
    }

    public function modify(object $category): void
    {
        $this->update($category);
    }

    public function remove($id): void
    {
        $this->delete($id);
    }
}