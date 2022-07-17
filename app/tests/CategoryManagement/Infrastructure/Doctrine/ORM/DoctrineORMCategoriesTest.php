<?php

namespace App\Tests\CategoryManagement\Infrastructure\Doctrine\ORM;

use App\CategoryManagement\Infrastructure\Doctrine\ORM\DoctrineORMCategories;
use App\Tests\Factory\Category\CategoryFactory;
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
        $category = CategoryFactory::new()->withoutPersisting()->create()->object();

        // Act
        $this->categories->add($category);
        $this->entityManager->flush();
        $existing = $this->categories->findBySlug($category->slug());

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
