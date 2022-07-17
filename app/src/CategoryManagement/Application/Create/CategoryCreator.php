<?php
declare(strict_types=1);

namespace App\CategoryManagement\Application\Create;

use App\CategoryManagement\Domain\Entity\Category;
use App\CategoryManagement\Domain\Entity\Category\Name;
use App\CategoryManagement\Domain\Entity\Category\Slug;
use App\CategoryManagement\Domain\Repository\Categories;
use App\CategoryManagement\Domain\Service\CategoryUniquenessChecker;

final class CategoryCreator
{
    public function __construct(
        private readonly Categories $categories,
        private readonly CategoryUniquenessChecker $categoryUniquenessChecker
    ) {}

    public function __invoke(Name $name, Slug $slug): void
    {
        $category = Category::create($name, $slug, $this->categoryUniquenessChecker);
        $this->categories->add($category);
    }
}