<?php

declare(strict_types=1);

namespace Hutech\Services;

use Hutech\Repositories\InvoiceRepository;

include_once './Repositories/InvoiceRepository.php';

readonly class InvoiceService
{
    public function __construct(protected InvoiceRepository $invoiceRepository)
    {
    }

    public function getAll(): ?array
    {
        return $this->invoiceRepository->findAll();
    }

    public function getById($id): ?object
    {
        return $this->invoiceRepository->findById($id);
    }

    public function create($invoice): void
    {
        $this->invoiceRepository->add($invoice);
    }

    public function delete($id): void
    {
        $this->invoiceRepository->remove($id);
    }

    public function update($invoice): void
    {
        $this->invoiceRepository->modify($invoice);
    }
}