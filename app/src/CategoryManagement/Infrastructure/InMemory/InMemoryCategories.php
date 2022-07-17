<?php
declare(strict_types=1);

namespace App\CategoryManagement\Infrastructure\InMemory;

use App\CategoryManagement\Domain\Entity\Category;
use App\CategoryManagement\Domain\Repository\Categories;
use Ramsey\Uuid\UuidInterface;

final class InMemoryCategories implements Categories
{

    /** @var Category[] */
    private array $memory = [];

    public function add(Category $category): void
    {
        $this->memory[$category->uuid()->toString()] = $category;
    }

    public function find(UuidInterface $uuid): ?Category
    {
        return $this->memory[$uuid->toString()] ?? null;
    }

    public function findBySlug(Category\Slug $slug): ?Category
    {
        foreach ($this->memory as $category) {
            if ($category->slug()->equals($slug)) {
                return $category;
            }
        }
        return null;
    }

    public function remove(Category $category): void
    {
        unset($this->memory[$category->uuid()->toString()]);
    }
}