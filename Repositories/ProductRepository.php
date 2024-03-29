<?php

declare(strict_types=1);

namespace Hutech\Repositories;

class ProductRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('Product');
    }

    public function findAll(): ?array
    {
        return $this->getAll();
    }

    public function findById($id): ?object
    {
        return $this->getById($id);
    }

    public function add($product): void
    {
        $this->insert($product);
    }

    public function modify($product): void
    {
        $this->update($product);
    }

    public function remove($id): void
    {
        $this->delete($id);
    }
}