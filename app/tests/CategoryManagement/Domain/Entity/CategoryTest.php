<?php

namespace App\Tests\CategoryManagement\Domain\Entity;

use App\CategoryManagement\Domain\Entity\Category;
use App\CategoryManagement\Domain\Exception\CategoryExists;
use App\CategoryManagement\Domain\Service\CategoryUniquenessValidator;
use App\CategoryManagement\Infrastructure\InMemory\InMemoryCategories;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class CategoryTest extends KernelTestCase
{
    private readonly CategoryUniquenessValidator $uniquenessValidator;
    private readonly InMemoryCategories $categories;

    /** @test */
    public function itCanBeCreatedFromNameAndSlug(): void
    {
        // Arrange
        $name = Category\Name::from('Test');

        // Act
        $category = Category::create($this->uniquenessValidator, $name);

        // Assert
        self::assertSame([
            'name' => 'Test',
            'slug' => 'test'
        ], [
            'name' => $category->name()->toString(),
            'slug' => $category->slug()->toString()
        ]);
    }

    /** @test */
    public function itThrowsErrorWhenTryingToCreateCategoryThatAlreadyExists(): void
    {
        // Assert
        $this->expectException(CategoryExists::class);

        // Arrange
        $name = Category\Name::from('Test');
        $category = Category::create($this->uniquenessValidator, $name);
        $this->categories->add($category);

        // Act
        Category::create($this->uniquenessValidator, $name);

    }

    public function setUp(): void
    {
        $this->categories = new InMemoryCategories();
        $this->uniquenessValidator = new CategoryUniquenessValidator($this->categories);
    }
}
