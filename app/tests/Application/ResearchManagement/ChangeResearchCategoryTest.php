<?php
declare(strict_types=1);

namespace App\Tests\Application\ResearchManagement;

use App\ResearchManagement\Domain\Entity\Research\Name;
use App\ResearchManagement\Domain\Entity\Research\Slug;
use App\Tests\Application\ApiTestCase;
use App\Tests\Factory\Category\CategoryFactory;
use App\Tests\Factory\Research\ResearchFactory;
use Ramsey\Uuid\Uuid;

final class ChangeResearchCategoryTest extends ApiTestCase
{
    /** @test */
    public function canChangeResearchCategory(): void
    {
        // Arrange
        CategoryFactory::createOne([
            'uuid' => $categoryUuid = Uuid::uuid4()
        ]);

        ResearchFactory::createOne([
            'uuid' => $researchUuid = Uuid::uuid4(),
            'name' => $name = Name::from('Research name'),
            'slug' => $slug = Slug::fromName($name),
            'categoryUuid' => $categoryUuid
        ]);

        CategoryFactory::createOne([
            'uuid' => $newCategoryUuid = Uuid::uuid4()
        ]);

        // Act
        $response = $this->makePatchRequest('/researches/category-change', $researchUuid->toString(), [
            'category_uuid' => $newCategoryUuid->toString()
        ]);

        // Assert
        $this->assertEquals(204, $response->getStatusCode());

        $response = $this->makeGetRequest('/researches/' . $slug->toString());
        $this->assertEquals(200, $response->getStatusCode());
        $decoded = json_decode($response->getContent(), true);
        $this->assertEquals($newCategoryUuid->toString(), $decoded['category']['uuid']);
    }

    /** @test */
    public function cannotChangeResearchCategoryToNotExistingOne(): void
    {
        // Arrange
        CategoryFactory::createOne([
            'uuid' => $categoryUuid = Uuid::uuid4()
        ]);

        ResearchFactory::createOne([
            'uuid' => $researchUuid = Uuid::uuid4(),
            'categoryUuid' => $categoryUuid
        ]);

        // Act
        $response = $this->makePatchRequest('/researches/category-change', $researchUuid->toString(), [
            'category_uuid' => Uuid::uuid4()->toString()
        ]);

        // Assert
        $this->assertEquals(422, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            '{"detail":"Research category does not exists","status":422,"type":"domain_error","title":"Domain error"}',
            $response->getContent()
        );
    }

    /** @test */
    public function canRemoveCategoryFromResearch(): void
    {
        // Arrange
        CategoryFactory::createOne([
            'uuid' => $categoryUuid = Uuid::uuid4()
        ]);

        ResearchFactory::createOne([
            'uuid' => $researchUuid = Uuid::uuid4(),
            'name' => $name = Name::from('Research name'),
            'slug' => $slug = Slug::fromName($name),
            'categoryUuid' => $categoryUuid
        ]);

        // Act
        $response = $this->makePatchRequest('/researches/category-change', $researchUuid->toString(), [
            'category_uuid' => null
        ]);

        // Assert
        $this->assertEquals(204, $response->getStatusCode());

        $response = $this->makeGetRequest('/researches/' . $slug->toString());
        $this->assertEquals(200, $response->getStatusCode());
        $decoded = json_decode($response->getContent(), true);
        $this->assertNull($decoded['category']);
    }
}