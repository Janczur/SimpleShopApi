<?php
declare(strict_types=1);

namespace App\CategoryManagement\Domain\Service;

use App\CategoryManagement\Domain\Entity\Category\Slug;
use App\CategoryManagement\Domain\Repository\Categories;

final class CategoryUniquenessValidator
{
    public function __construct(
        private readonly Categories $categories
    ) {}

    public function isUnique(Slug $slug): bool
    {
        return $this->categories->findBySlug($slug) === null;
    }
}