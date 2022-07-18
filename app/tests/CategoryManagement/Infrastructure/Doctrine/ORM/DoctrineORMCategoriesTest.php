<?php

namespace App\Tests\CategoryManagement\Infrastructure\Doctrine\ORM;

use App\CategoryManagement\Domain\Entity\Category\Name;
use App\CategoryManagement\Domain\Entity\Category\Slug;
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
        self::assertSame($category->name()->toString(), $existing->name()->toString());
        self::assertSame($category->slug()->toString(), $existing->slug()->toString());
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
        CategoryFactory::createOne([
            'uuid' => $uuid = Uuid::uuid4(),
            'name' => $name = Name::from('Test Category'),
            'slug' => $slug = Slug::fromName($name),
        ]);

        // Act
        $category = $this->categories->findBySlug($slug);

        // Assert
        self::assertNotNull($category);
        self::assertSame($uuid->toString(), $category->uuid()->toString());
        self::assertSame($name->toString(), $category->name()->toString());
        self::assertSame($slug->toString(), $category->slug()->toString());
    }

    protected function setUp(): void
    {
        $entityManager = self::bootKernel()->getContainer()->get('doctrine')->getManager();
        $this->categories = new DoctrineORMCategories($entityManager);
    }
}
