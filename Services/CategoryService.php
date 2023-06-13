<?php

declare(strict_types=1);

namespace Hutech\Services;

use Hutech\Models\Category;
use Hutech\Repositories\CategoryRepository;

include_once './Models/Category.php';
include_once './Repositories/CategoryRepository.php';

readonly class CategoryService
{
    public function __construct(protected CategoryRepository $categoryRepository)
    {
    }

    public function getAll(): ?array
    {
        return $this->categoryRepository->findAll();
    }

    public function getById(int $id): ?object
    {
        return $this->categoryRepository->findById($id);
    }

    public function create(Category $category): void
    {
        $this->categoryRepository->add($category);
    }

    public function delete(int $id): void
    {
        $this->categoryRepository->remove($id);
    }

    public function update(Category $category): void
    {
        $this->categoryRepository->update($category);
    }
}