<?php
declare(strict_types=1);

namespace App\CategoryManagement\Infrastructure\Doctrine\ORM;

use App\CategoryManagement\Domain\Entity\Category;
use App\CategoryManagement\Domain\Repository\Categories;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineORMCategories implements Categories
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {}

    public function add(Category $category): void
    {
        $this->entityManager->persist($category);
    }

    public function getBySlug(Category\Slug $slug): ?Category
    {
        return $this->entityManager->getRepository(Category::class)->findOneBy([
            'slug.value' => $slug->asString()
        ]);
    }
}