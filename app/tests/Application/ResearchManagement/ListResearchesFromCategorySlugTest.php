<?php
declare(strict_types=1);

namespace App\Tests\Application\ResearchManagement;

use App\CategoryManagement\Domain\Entity\Category\Name;
use App\CategoryManagement\Domain\Entity\Category\Slug;
use App\ResearchManagement\Domain\Entity\Research\Code;
use App\Tests\Application\ApiTestCase;
use App\Tests\Factory\Category\CategoryFactory;
use App\Tests\Factory\Research\ResearchFactory;
use Ramsey\Uuid\Uuid;

final class ListResearchesFromCategorySlugTest extends ApiTestCase
{
    /** @test */
    public function canListResearchesFromCategorySlug(): void
    {
        // Arrange
        CategoryFactory::createMany(5);

        CategoryFactory::createOne([
            'uuid' => $categoryUuid = Uuid::uuid4(),
            'slug' => $slug = Slug::fromName(Name::from('Badanie krwi'))
        ]);
        ResearchFactory::createMany(3, [
            'categoryUuid' => $categoryUuid,
            'code' => $code = Code::from(123)
        ]);

        // Act
        $response = $this->makeGetRequest('/researches/category/' . $slug->toString());

        // Assert
        self::assertEquals(200, $response->getStatusCode());
        $decoded = json_decode($response->getContent(), true);
        self::assertCount(3, $decoded);
        self::assertCount(4, $decoded[0]);
        self::assertEquals($code->toInt(), $decoded[0]['code']);
    }
}