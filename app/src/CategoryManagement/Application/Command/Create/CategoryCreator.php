<?php
declare(strict_types=1);

namespace App\CategoryManagement\Application\Command\Create;

use App\CategoryManagement\Domain\Entity\Category;
use App\CategoryManagement\Domain\Entity\Category\Name;
use App\CategoryManagement\Domain\Repository\Categories;
use App\CategoryManagement\Domain\Service\CategoryUniquenessValidator;

final class CategoryCreator
{
    public function __construct(
        private readonly Categories $categories,
        private readonly CategoryUniquenessValidator $categoryUniquenessChecker
    ) {}

    public function __invoke(Name $name): void
    {
        $category = Category::create($this->categoryUniquenessChecker, $name);
        $this->categories->add($category);
    }
}