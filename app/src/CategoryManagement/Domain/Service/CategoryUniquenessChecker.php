<?php
declare(strict_types=1);

namespace App\CategoryManagement\Domain\Service;

use App\CategoryManagement\Domain\Entity\Category;
use App\CategoryManagement\Domain\Repository\Categories;

class CategoryUniquenessChecker
{
    public function __construct(
        private readonly Categories $categories
    ) {}

    public function isUnique(Category $category): bool
    {
        return $this->categories->findBySlug($category->slug()->toString()) === null;
    }
}