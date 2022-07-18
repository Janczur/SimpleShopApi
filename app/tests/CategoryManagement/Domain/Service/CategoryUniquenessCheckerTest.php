<?php

namespace App\Tests\CategoryManagement\Domain\Service;

use App\CategoryManagement\Domain\Entity\Category;
use App\CategoryManagement\Domain\Repository\Categories;
use App\CategoryManagement\Domain\Service\CategoryUniquenessValidator;
use App\CategoryManagement\Infrastructure\InMemory\InMemoryCategories;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class CategoryUniquenessCheckerTest extends KernelTestCase
{
    private Categories $categories;
    private CategoryUniquenessValidator $uniquenessChecker;

    /**
     * @test
     */
    public function itReturnsTrueWhenCategoryIsUnique(): void
    {
        // Arrange
        $name = Category\Name::from('Test');
        $category = Category::create($this->uniquenessChecker, $name);

        $this->categories->add($category);

        $otherCategoryName = Category\Name::from('Test2');
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
        $name = Category\Name::from('Test');
        $category = Category::create($this->uniquenessChecker, $name);
        $this->categories->add($category);

        // Act && Assert
        $this->assertFalse($this->uniquenessChecker->isUnique($category->slug()));
    }

    protected function setUp(): void
    {
        $this->categories = new InMemoryCategories();
        $this->uniquenessChecker = new CategoryUniquenessValidator($this->categories);
    }

}
