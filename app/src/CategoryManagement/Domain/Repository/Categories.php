<?php
declare(strict_types=1);

namespace App\CategoryManagement\Domain\Repository;

use App\CategoryManagement\Domain\Entity\Category;

interface Categories
{
    public function add(Category $category): void;

    public function findBySlug(string $slug): ?Category;
}