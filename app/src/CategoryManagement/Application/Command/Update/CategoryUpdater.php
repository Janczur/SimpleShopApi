<?php
declare(strict_types=1);

namespace App\CategoryManagement\Application\Command\Update;

use App\CategoryManagement\Domain\Entity\Category\Name;
use App\CategoryManagement\Domain\Repository\Categories;
use App\CategoryManagement\Domain\Service\CategoryUniquenessValidator;
use Ramsey\Uuid\UuidInterface;
use RuntimeException;

final class CategoryUpdater
{
    public function __construct(
        private readonly Categories $categories,
        private readonly CategoryUniquenessValidator $categoryUniquenessChecker
    ) {}

    public function __invoke(UuidInterface $uuid, Name $name): void
    {
        if (!$category = $this->categories->find($uuid)) {
            throw new RuntimeException('The given category does not exist');
        }
        $category->rename($this->categoryUniquenessChecker, $name);
        $this->categories->add($category);
    }
}