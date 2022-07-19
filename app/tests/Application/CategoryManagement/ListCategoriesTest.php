<?php
declare(strict_types=1);

namespace App\Tests\Application\CategoryManagement;

use App\Tests\Application\ApiTestCase;
use App\Tests\Factory\Category\CategoryFactory;

final class ListCategoriesTest extends ApiTestCase
{

    /** @test */
    public function categoriesCanBeListed(): void
    {
        // Arrange
        CategoryFactory::createMany(3);

        // Act
        $response = $this->makeGetRequest('/categories');

        // Assert
        self::assertEquals(200, $response->getStatusCode());
        self::assertCount(3, json_decode($response->getContent(), true));
    }
}