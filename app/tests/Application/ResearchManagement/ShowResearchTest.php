<?php
declare(strict_types=1);

namespace App\Tests\Application\ResearchManagement;

use App\CategoryManagement\Domain\Entity\Category;
use App\ResearchManagement\Domain\Entity\Research\Code;
use App\ResearchManagement\Domain\Entity\Research\IcdCode;
use App\ResearchManagement\Domain\Entity\Research\Name;
use App\ResearchManagement\Domain\Entity\Research\Slug;
use App\Tests\Application\ApiTestCase;
use App\Tests\Factory\Category\CategoryFactory;
use App\Tests\Factory\Research\ResearchFactory;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

class ShowResearchTest extends ApiTestCase
{

    /** @test */
    public function canShowResearchWithCategory(): void
    {
        // Arrange
        CategoryFactory::createOne([
            'uuid' => $categoryUuid = Uuid::uuid4(),
            'name' => $categoryName = Category\Name::from('Research category name'),
            'slug' => $categorySlug = Category\Slug::fromName($categoryName),
        ]);
        ResearchFactory::createOne([
            'uuid' => $uuid = Uuid::uuid4(),
            'name' => $name = Name::from('Research name'),
            'slug' => $slug = Slug::fromName($name),
            'code' => $code = Code::from(123),
            'categoryUuid' => $categoryUuid,
            'icdCode' => $icdCode = IcdCode::from('A12'),
            'shortDescription' => $shortDescription = 'short description',
            'description' => $description = 'description',
            'createdAt' => $createdAt = new DateTimeImmutable(),
        ]);

        // Act
        $response = $this->makeGetRequest('/researches/' . $slug->toString());


        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        $expected = [
            'uuid' => $uuid->toString(),
            'name' => $name->toString(),
            'slug' => $slug->toString(),
            'code' => $code->toInt(),
            'category' => [
                'uuid' => $categoryUuid->toString(),
                'name' => $categoryName->toString(),
                'slug' => $categorySlug->toString(),
            ],
            'icd_code' => $icdCode->toString(),
            'description' => $description,
            'short_description' => $shortDescription,
            'created_at' => $createdAt->format('Y-m-d H:i:s'),
        ];

        $this->assertJsonStringEqualsJsonString(json_encode($expected), $response->getContent());
    }

    /** @test */
    public function cannotShowResearchThatDoesNotExists(): void
    {
        // Arrange & Act
        $response = $this->makeGetRequest('/researches/not-existing-slug');

        // Assert
        $this->assertEquals(404, $response->getStatusCode());
    }
}