<?php
declare(strict_types=1);

namespace App\CategoryManagement\Domain\Service;

use App\CategoryManagement\Domain\Entity\Category\Slug;
use App\CategoryManagement\Domain\Repository\Categories;

class CategoryUniquenessChecker
{
    public function __construct(
        private readonly Categories $categories
    ) {}

    public function isUnique(Slug $slug): bool
    {
        return $this->categories->getBySlug($slug) === null;
    }
}