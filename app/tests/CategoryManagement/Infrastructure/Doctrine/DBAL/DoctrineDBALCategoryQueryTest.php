<?php

namespace App\Tests\CategoryManagement\Infrastructure\Doctrine\DBAL;

use App\CategoryManagement\Application\Query\CategoryQuery;
use App\CategoryManagement\Domain\Entity\Category\Name;
use App\CategoryManagement\Domain\Entity\Category\Slug;
use App\CategoryManagement\Infrastructure\Doctrine\DBAL\DoctrineDBALCategoryQuery;
use App\Tests\Factory\Category\CategoryFactory;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class DoctrineDBALCategoryQueryTest extends KernelTestCase
{
    private CategoryQuery $categoryQuery;

    /** @test */
    public function correctlyMapsTheQueryResultsToTheReadModel(): void
    {
        // Arrange
        $uuid = Uuid::uuid4();
        $name = Name::fromString('Category');
        $slug = Slug::fromName($name);
        CategoryFactory::createOne([
            'uuid' => $uuid,
            'name' => $name,
            'slug' => $slug,
        ]);

        // Act
        $categoryView = $this->categoryQuery->category($uuid->toString());

        // Assert
        self::assertNotNull($categoryView);
        self::assertSame($uuid->toString(), $categoryView->uuid());
        self::assertSame($name->asString(), $categoryView->name());
        self::assertSame($slug->asString(), $categoryView->slug());
    }

    public function setUp(): void
    {
        $connection = self::bootKernel()->getContainer()->get('doctrine')->getConnection();
        $this->categoryQuery = new DoctrineDBALCategoryQuery($connection);
    }
}
