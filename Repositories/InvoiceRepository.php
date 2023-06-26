<?php

declare(strict_types=1);

namespace Hutech\Repositories;

class InvoiceRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('Invoice');
    }

    public function findAll(): ?array
    {
        return $this->getAll();
    }

    public function findById($id): ?object
    {
        return $this->getById($id);
    }

    public function add($invoice): void
    {
        $this->insert($invoice);
    }

    public function modify($invoice): void
    {
        $this->update($invoice);
    }

    public function remove($id): void
    {
        $this->delete($id);
    }
}