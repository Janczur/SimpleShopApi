<?php
declare(strict_types=1);

namespace App\Tests\Application\CategoryManagement;

use App\CategoryManagement\Domain\Entity\Category\Name;
use App\Tests\Application\ApiTestCase;
use App\Tests\Factory\Category\CategoryFactory;
use Ramsey\Uuid\Uuid;

final class UpdateCategoryTest extends ApiTestCase
{
    /** @test */
    public function categoryCanBeUpdated(): void
    {
        // Arrange
        CategoryFactory::createOne([
            'uuid' => $uuid = Uuid::uuid4(),
            'name' => Name::from('Category name'),
        ]);
        $data = ['name' => 'New category name',];

        // Act
        $updateResponse = $this->makePatchRequest('/categories', $uuid->toString(), $data);
        $getResponse = $this->makeGetRequest('/categories/' . $uuid->toString());

        // Assert
        $this->assertEquals(204, $updateResponse->getStatusCode());
        $expected = [
            'uuid' => $uuid->toString(),
            'name' => 'New category name',
            'slug' => 'new-category-name',
        ];
        $this->assertJsonStringEqualsJsonString(json_encode($expected), $getResponse->getContent());
    }
}