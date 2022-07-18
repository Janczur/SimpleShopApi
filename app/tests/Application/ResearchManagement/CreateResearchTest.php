<?php
declare(strict_types=1);

namespace App\Tests\Application\ResearchManagement;

use App\Tests\Application\ApiTestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class CreateResearchTest extends ApiTestCase
{

    /** @test */
    public function canCreateResearch(): void
    {
        // Arrange && Act
        $response = $this->researchPostRequest();

        // Assert
        $this->assertEquals(201, $response->getStatusCode());
    }

    private function researchPostRequest(
        ?string $name = 'Research name',
        ?int $code = 123,
        ?string $categoryUuid = null,
        ?string $icdCode = 'A12.3',
        ?string $shortDescription = 'Short description',
        ?string $description = 'Description'
    ): Response
    {
        return $this->makePostRequest('/researches', [
            'name' => $name,
            'code' => $code,
            'category_uuid' => $categoryUuid,
            'icd_code' => $icdCode,
            'short_description' => $shortDescription,
            'description' => $description,
        ]);
    }

    /** @test */
    public function cannotCreateResearchWithInvalidName(): void
    {
        // Arrange && Act
        $response = $this->researchPostRequest('Inv@!id name...');

        // Assert
        $this->assertEquals(422, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            '{"errors":{"name":["Research name can only contain letters, numbers, spaces, dashes, commas and dots"]},"status":422,"type":"validation_failed","title":"Validation failed"}',
            $response->getContent()
        );
    }

    /** @test */
    public function cannotCreateResearchWithInvalidCode(): void
    {
        // Arrange && Act
        $response = $this->researchPostRequest(code: -2);

        // Assert
        $this->assertEquals(422, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            '{"errors":{"code":["This value should be between 1 and 9999."]},"status":422,"type":"validation_failed","title":"Validation failed"}',
            $response->getContent()
        );
    }

    /** @test */
    public function cannotCreateResearchWithInvalidIcdCode(): void
    {
        // Arrange && Act
        $response = $this->researchPostRequest(icdCode: 'XXX');

        // Assert
        $this->assertEquals(422, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            '{"errors":{"icdCode":["Invalid ICD code"]},"status":422,"type":"validation_failed","title":"Validation failed"}',
            $response->getContent()
        );
    }

    /** @test */
    public function cannotCreateResearchWithInvalidCategoryUuid(): void
    {
        // Arrange && Act
        $response = $this->researchPostRequest(categoryUuid: 'invalid-uuid');

        // Assert
        $this->assertEquals(422, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            '{"errors":{"categoryUuid":["This is not a valid UUID."]},"status":422,"type":"validation_failed","title":"Validation failed"}',
            $response->getContent()
        );
    }

    /** @test */
    public function cannotCreateResearchWithNotExistingResearchCategory(): void
    {
        // Arrange && Act
        $response = $this->researchPostRequest(categoryUuid: Uuid::uuid4()->toString());

        // Assert
        $this->assertEquals(422, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            '{"detail":"Research category does not exists","status":422,"type":"domain_error","title":"Domain error"}',
            $response->getContent()
        );
    }
}