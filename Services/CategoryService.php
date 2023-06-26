<?php

declare(strict_types=1);

namespace Hutech\Services;

use Hutech\Repositories\CategoryRepository;

readonly class CategoryService
{
    public function __construct(protected CategoryRepository $categoryRepository)
    {
    }

    public function getAll(): ?array
    {
        return $this->categoryRepository->findAll();
    }

    public function getById($id): ?object
    {
        return $this->categoryRepository->findById($id);
    }

    public function create($category): void
    {
        $this->categoryRepository->add($category);
    }

    public function delete($id): void
    {
        $this->categoryRepository->remove($id);
    }

    public function update($category): void
    {
        $this->categoryRepository->modify($category);
    }
}