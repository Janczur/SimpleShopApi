<?php
declare(strict_types=1);

namespace App\Tests\Application\CategoryManagement;

use App\Tests\Application\ApiTestCase;
use App\Tests\Factory\Category\CategoryFactory;
use Ramsey\Uuid\Uuid;

final class DeleteCategoryTest extends ApiTestCase
{
    /** @test */
    public function categoryCanBeDeleted(): void
    {
        // Arrange
        CategoryFactory::createOne([
            'uuid' => $uuid = Uuid::uuid4()
        ]);

        // Act
        $response = $this->makeDeleteRequest('/categories', $uuid->toString());

        // Assert
        $this->assertEquals(204, $response->getStatusCode());
    }

}