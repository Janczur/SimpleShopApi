<?php

namespace App\Tests\CategoryManagement\Domain\Entity;

use App\CategoryManagement\Domain\Entity\Category;
use App\CategoryManagement\Domain\Exception\CategoryExists;
use App\CategoryManagement\Domain\Service\CategoryUniquenessChecker;
use App\CategoryManagement\Infrastructure\InMemory\InMemoryCategories;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CategoryTest extends KernelTestCase
{
    private readonly CategoryUniquenessChecker $uniquenessChecker;
    private readonly InMemoryCategories $categories;

    /** @test */
    public function itCanBeCreatedFromNameAndSlug(): void
    {
        // Arrange
        $name = Category\Name::fromString('Test');
        $slug = Category\Slug::fromName($name);

        // Act
        $category = Category::create($name, $slug, $this->uniquenessChecker);

        // Assert
        self::assertSame([
            'name' => 'Test',
            'slug' => 'test'
        ], [
            'name' => $category->name()->asString(),
            'slug' => $category->slug()->asString()
        ]);
    }

    /** @test */
    public function itThrowsErrorWhenTryingToCreateCategoryThatAlreadyExists(): void
    {
        // Assert
        $this->expectException(CategoryExists::class);

        // Arrange
        $name = Category\Name::fromString('Test');
        $slug = Category\Slug::fromName($name);
        $category = Category::create($name, $slug, $this->uniquenessChecker);
        $this->categories->add($category);

        // Act
        $category = Category::create($name, $slug, $this->uniquenessChecker);

    }

    protected function setUp(): void
    {
        $this->categories = new InMemoryCategories();
        $this->uniquenessChecker = new CategoryUniquenessChecker($this->categories);
    }
}
