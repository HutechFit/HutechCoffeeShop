<?php

declare(strict_types=1);

namespace Hutech\Repositories;

class ItemInvoiceRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('item_invoice');
    }

    public function findAll(): ?array
    {
        return $this->getAll();
    }

    public function findById($id): ?object
    {
        return $this->getById($id);
    }

    public function add($itemInvoice): void
    {
        $this->insert($itemInvoice);
    }

    public function modify($itemInvoice): void
    {
        $this->update($itemInvoice);
    }

    public function remove($id): void
    {
        $this->delete($id);
    }
}