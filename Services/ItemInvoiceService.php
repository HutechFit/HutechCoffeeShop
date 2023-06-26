<?php

namespace Hutech\Services;

use Hutech\Repositories\ItemInvoiceRepository;

readonly class ItemInvoiceService
{
    public function __construct(protected ItemInvoiceRepository $itemInvoiceRepository)
    {
    }

    public function getAll(): ?array
    {
        return $this->itemInvoiceRepository->findAll();
    }

    public function getById($id): ?object
    {
        return $this->itemInvoiceRepository->findById($id);
    }

    public function create($itemInvoice): void
    {
        $this->itemInvoiceRepository->add($itemInvoice);
    }

    public function delete($id): void
    {
        $this->itemInvoiceRepository->remove($id);
    }

    public function update($itemInvoice): void
    {
        $this->itemInvoiceRepository->modify($itemInvoice);
    }
}