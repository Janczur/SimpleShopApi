<?php

namespace App\Tests\CategoryManagement\Application\Command\Update;

use App\CategoryManagement\Application\Command\Update\CategoryUpdater;
use App\CategoryManagement\Domain\Entity\Category\Name;
use App\CategoryManagement\Domain\Repository\Categories;
use App\CategoryManagement\Domain\Service\CategoryUniquenessChecker;
use App\CategoryManagement\Infrastructure\InMemory\InMemoryCategories;
use App\Tests\Factory\Category\CategoryFactory;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CategoryUpdaterTest extends KernelTestCase
{
    private readonly CategoryUpdater $categoryUpdater;
    private readonly Categories $categories;

    public function setUp(): void
    {
        self::bootKernel();
        $this->categories = new InMemoryCategories();
        $uniquenessChecker = new CategoryUniquenessChecker($this->categories);
        $this->categoryUpdater = new CategoryUpdater($this->categories, $uniquenessChecker);
    }

    /** @test */
    public function itCanUpdateTheCategory(): void
    {
        // Arrange
        $category = CategoryFactory::new()->withoutPersisting()->create([
            'uuid' => $uuid = Uuid::uuid4(),
            'name' => Name::fromString('Original category name'),
        ])->object();
        $this->categories->add($category);
        $newName = Name::fromString('New category name');

        // Act
        $this->categoryUpdater->__invoke($uuid, $newName);
        $category = $this->categories->find($uuid);

        // Assert
        $this->assertSame($newName->asString(), $category->name()->asString());
    }

}
