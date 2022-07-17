<?php
declare(strict_types=1);

namespace App\Tests\Application\CategoryManagement;

use App\CategoryManagement\Domain\Entity\Category\Name;
use App\CategoryManagement\Domain\Entity\Category\Slug;
use App\Tests\Application\ApiTestCase;
use App\Tests\Factory\Category\CategoryFactory;
use Ramsey\Uuid\Uuid;

final class ShowCategoryTest extends ApiTestCase
{
    /** @test */
    public function categoryCanBeShown(): void
    {
        // Arrange
        CategoryFactory::createOne([
            'uuid' => $uuid = Uuid::uuid4(),
            'name' => $name = Name::fromString('Category name'),
            'slug' => $slug = Slug::fromName($name),
        ]);

        // Act
        $response = $this->makeGetRequest('/categories/' . $uuid->toString());

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        $expected = [
            'uuid' => $uuid->toString(),
            'name' => $name->asString(),
            'slug' => $slug->asString(),
        ];
        $this->assertJsonStringEqualsJsonString(json_encode($expected), $response->getContent());
    }
}