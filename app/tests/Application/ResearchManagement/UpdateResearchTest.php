<?php
declare(strict_types=1);

namespace App\Tests\Application\ResearchManagement;

use App\ResearchManagement\Domain\Entity\Research\Code;
use App\ResearchManagement\Domain\Entity\Research\IcdCode;
use App\ResearchManagement\Domain\Entity\Research\Name;
use App\ResearchManagement\Domain\Entity\Research\Slug;
use App\Tests\Application\ApiTestCase;
use App\Tests\Factory\Research\ResearchFactory;
use Ramsey\Uuid\Uuid;

class UpdateResearchTest extends ApiTestCase
{

    /** @test */
    public function canUpdateExistingResearchValues(): void
    {
        // Arrange
        ResearchFactory::createOne([
            'uuid' => $uuid = Uuid::uuid4(),
            'name' => $name = Name::from('Research name'),
            'slug' => $slug = Slug::fromName($name),
            'code' => Code::from(1),
            'icdCode' => IcdCode::from('A01'),
            'description' => 'Research description',
            'shortDescription' => 'Research short description',
        ]);

        // Act
        $response = $this->makePatchRequest('/researches', $uuid->toString(), [
            'code' => 2,
            'icd_code' => 'A02',
            'description' => 'New research description',
            'short_description' => 'New research short description',
        ]);

        // Assert
        $this->assertEquals(204, $response->getStatusCode());

        $response = $this->makeGetRequest('/researches/' . $slug->toString());
        $this->assertEquals(200, $response->getStatusCode());
        $decoded = json_decode($response->getContent(), true);
        $this->assertEquals(2, $decoded['code']);
        $this->assertEquals('A02', $decoded['icd_code']);
        $this->assertEquals('New research description', $decoded['description']);
        $this->assertEquals('New research short description', $decoded['short_description']);
    }

    /** @test */
    public function canUpdateNotExistingResearchValues(): void
    {
        // Arrange
        ResearchFactory::createOne([
            'uuid' => $uuid = Uuid::uuid4(),
            'name' => $name = Name::from('Research name'),
            'slug' => $slug = Slug::fromName($name),
            'code' => Code::from(1),
            'icdCode' => null,
            'description' => null,
            'shortDescription' => null,
        ]);

        // Act
        $response = $this->makePatchRequest('/researches', $uuid->toString(), [
            'code' => 2,
            'icd_code' => 'A02',
            'description' => 'New research description',
            'short_description' => 'New research short description',
        ]);

        // Assert
        $this->assertEquals(204, $response->getStatusCode());

        $response = $this->makeGetRequest('/researches/' . $slug->toString());
        $this->assertEquals(200, $response->getStatusCode());
        $decoded = json_decode($response->getContent(), true);
        $this->assertEquals(2, $decoded['code']);
        $this->assertEquals('A02', $decoded['icd_code']);
        $this->assertEquals('New research description', $decoded['description']);
        $this->assertEquals('New research short description', $decoded['short_description']);
    }

    /** @test */
    public function cannotUpdateToInvalidValues(): void
    {
        // Arrange
        ResearchFactory::createOne([
            'uuid' => $uuid = Uuid::uuid4(),
        ]);

        // Acts & Asserts
        $response = $this->makePatchRequest('/researches', $uuid->toString(), ['code' => -3,]);
        $this->assertEquals(422, $response->getStatusCode());
        $response = $this->makePatchRequest('/researches', $uuid->toString(), ['icd_code' => 'XXX',]);
        $this->assertEquals(422, $response->getStatusCode());
        $response = $this->makePatchRequest('/researches', $uuid->toString(), ['short_description' => '2',]);
        $this->assertEquals(422, $response->getStatusCode());
    }

}