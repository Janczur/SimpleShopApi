<?php
declare(strict_types=1);

namespace App\Tests\Application\CategoryManagement;

use App\Tests\Application\ApiTestCase;

final class CreateCategoryTest extends ApiTestCase
{

    /** @test */
    public function categoryCanBeCreated(): void
    {
        // Arrange & Act
        $response = $this->makePostRequest('/categories', ['name' => 'Test']);

        // Assert
        $this->assertEquals(201, $response->getStatusCode());
    }

    /** @test */
    public function cannotCreateCategoryWithInvalidName(): void
    {
        // Arrange & Act
        $response = $this->makePostRequest('/categories', ['name' => 'Inv@!id name...']);

        // Assert
        $this->assertEquals(422, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            '{"errors":{"name":["Category name can only contain letters, numbers, spaces, dashes and underscores"]},"status":422,"type":"validation_failed","title":"Validation failed"}',
            $response->getContent()
        );
    }

}