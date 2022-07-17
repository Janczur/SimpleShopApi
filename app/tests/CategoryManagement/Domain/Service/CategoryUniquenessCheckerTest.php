<?php

namespace App\Tests\CategoryManagement\Domain\Service;

use App\CategoryManagement\Domain\Entity\Category;
use App\CategoryManagement\Domain\Repository\Categories;
use App\CategoryManagement\Domain\Service\CategoryUniquenessChecker;
use App\CategoryManagement\Infrastructure\InMemory\InMemoryCategories;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class CategoryUniquenessCheckerTest extends KernelTestCase
{
    private Categories $categories;
    private CategoryUniquenessChecker $uniquenessChecker;

    /**
     * @test
     */
    public function itReturnsTrueWhenCategoryIsUnique(): void
    {
        // Arrange
        $name = Category\Name::fromString('Test');
        $slug = Category\Slug::fromName($name);
        $category = Category::create($name, $slug, $this->uniquenessChecker);

        $this->categories->add($category);

        $otherCategoryName = Category\Name::fromString('Test2');
        $otherCategorySlug = Category\Slug::fromName($otherCategoryName);

        // Act && Assert
        $this->assertTrue($this->uniquenessChecker->isUnique($otherCategorySlug));
    }

    /**
     * @test
     */
    public function itReturnsFalseWhenCategoryIsNotUnique(): void
    {
        // Arrange
        $name = Category\Name::fromString('Test');
        $slug = Category\Slug::fromName($name);
        $category = Category::create($name, $slug, $this->uniquenessChecker);
        $this->categories->add($category);

        // Act && Assert
        $this->assertFalse($this->uniquenessChecker->isUnique($slug));
    }

    protected function setUp(): void
    {
        $this->categories = new InMemoryCategories();
        $this->uniquenessChecker = new CategoryUniquenessChecker($this->categories);
    }

}
