<?php
declare(strict_types=1);

namespace App\CategoryManagement\Infrastructure\InMemory;

use App\CategoryManagement\Domain\Entity\Category;
use App\CategoryManagement\Domain\Repository\Categories;

final class InMemoryCategories implements Categories
{

    private array $memory = [];

    public function add(Category $category): void
    {
        $this->memory[$category->slug()->asString()] = $category;
    }

    public function getBySlug(Category\Slug $slug): ?Category
    {
        return $this->memory[$slug->asString()] ?? null;
    }
}