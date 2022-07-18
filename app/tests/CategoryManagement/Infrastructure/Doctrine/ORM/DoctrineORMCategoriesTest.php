<?php

namespace App\Tests\CategoryManagement\Infrastructure\Doctrine\ORM;

use App\CategoryManagement\Domain\Repository\Categories;
use App\CategoryManagement\Infrastructure\Doctrine\ORM\DoctrineORMCategories;
use App\Tests\Factory\Category\CategoryFactory;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DoctrineORMCategoriesTest extends KernelTestCase
{
    private Categories $categories;
    private EntityManagerInterface $entityManager;

    /** @test */
    public function itCorrectlyAddsCategory(): void
    {
        // Arrange
        $category = CategoryFactory::new()->withoutPersisting()->create()->object();

        // Act
        $this->categories->add($category);
        $existing = $this->categories->find($category->uuid());

        // Assert
        self::assertSame($category->uuid()->toString(), $existing->uuid()->toString());
        self::assertSame($category->name()->asString(), $existing->name()->asString());
        self::assertSame($category->slug()->asString(), $existing->slug()->asString());
    }

    /** @test */
    public function itCorrectlyRemovesCategory(): void
    {
        // Arrange
        $category = CategoryFactory::new()->withoutPersisting()->create([
            'uuid' => $uuid = Uuid::uuid4(),
        ])->object();
        $this->categories->add($category);

        // Pre-Assert
        self::assertNotNull($this->categories->find($uuid));

        // Act
        $this->categories->remove($category);

        // Assert
        self::assertNull($this->categories->find($uuid));
    }

    /** @test */
    public function itCorrectlyFindsCategoryBySlug(): void
    {
        // Arrange
        $category = CategoryFactory::new()->withoutPersisting()->create()->object();
        $this->categories->add($category);
        $this->entityManager->flush();

        // Act
        $foundCategory = $this->categories->findBySlug($category->slug());

        // Assert
        self::assertNotNull($foundCategory);
        self::assertSame($category->uuid()->toString(), $foundCategory->uuid()->toString());
    }

    protected function setUp(): void
    {
        $this->entityManager = self::bootKernel()->getContainer()->get('doctrine')->getManager();
        $this->categories = new DoctrineORMCategories($this->entityManager);
    }
}
