<?php

namespace App\Tests\CategoryManagement\Infrastructure\Doctrine\ORM;

use App\CategoryManagement\Domain\Entity\Category;
use App\CategoryManagement\Domain\Service\CategoryUniquenessChecker;
use App\CategoryManagement\Infrastructure\Doctrine\ORM\DoctrineORMCategories;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DoctrineORMCategoriesTest extends KernelTestCase
{
    private DoctrineORMCategories $categories;
    private EntityManagerInterface $entityManager;

    /** @test */
    public function categorySuccessfullyAdded(): void
    {
        // Arrange
        $category = Category::create(
            $name = Category\Name::fromString('Test2'),
            Category\Slug::fromName($name),
            new CategoryUniquenessChecker($this->categories)
        );

        // Act
        $this->categories->add($category);
        $this->entityManager->flush();
        $existing = $this->categories->getBySlug($category->slug());

        // Assert
        self::assertSame($category->uuid()->toString(), $existing->uuid()->toString());
        self::assertSame($category->name()->asString(), $existing->name()->asString());
        self::assertSame($category->slug()->asString(), $existing->slug()->asString());
    }

    protected function setUp(): void
    {
        $this->entityManager = self::bootKernel()->getContainer()->get('doctrine')->getManager();
        $this->categories = new DoctrineORMCategories($this->entityManager);
    }
}
