<?php
declare(strict_types=1);

namespace App\Tests\Application\ResearchManagement;

use App\ResearchManagement\Domain\Entity\Research\Name;
use App\ResearchManagement\Domain\Entity\Research\Slug;
use App\Tests\Application\ApiTestCase;
use App\Tests\Factory\Research\ResearchFactory;
use Ramsey\Uuid\Uuid;

final class RenameResearchTest extends ApiTestCase
{
    /** @test */
    public function canRenameResearch(): void
    {
        // Arrange
        ResearchFactory::createOne([
            'uuid' => $uuid = Uuid::uuid4(),
            'name' => $name = Name::from('Research name'),
            'slug' => Slug::fromName($name),
        ]);

        // Act
        $renameResponse = $this->makePatchRequest('/researches/rename', $uuid->toString(), [
            'name' => 'New research name'
        ]);

        // Assert
        $this->assertEquals(204, $renameResponse->getStatusCode());

        $response = $this->makeGetRequest('/researches/new-research-name');
        $this->assertEquals(200, $response->getStatusCode());
        $decoded = json_decode($response->getContent(), true);
        $this->assertEquals('New research name', $decoded['name']);
    }

    /** @test */
    public function cannotRenameResearchIfTheSameNameExists(): void
    {
        // Arrange
        ResearchFactory::createOne([
            'uuid' => Uuid::uuid4(),
            'name' => $firstName = Name::from('First research name'),
            'slug' => Slug::fromName($firstName),
        ]);

        ResearchFactory::createOne([
            'uuid' => $uuid = Uuid::uuid4(),
            'name' => $secondName = Name::from('Second research name'),
            'slug' => Slug::fromName($secondName),
        ]);

        // Act
        $response = $this->makePatchRequest('/researches/rename', $uuid->toString(), [
            'name' => $firstName->toString()
        ]);

        // Assert
        $this->assertEquals(422, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            '{"detail":"Research with name \'First research name\' already exists in current category","status":422,"type":"domain_error","title":"Domain error"}',
            $response->getContent()
        );
    }

    /** @test */
    public function cannotRenameResearchToInvalidName(): void
    {
        // Arrange
        ResearchFactory::createOne([
            'uuid' => $uuid = Uuid::uuid4(),
        ]);

        // Act
        $response = $this->makePatchRequest('/researches/rename', $uuid->toString(), [
            'name' => 'Inva!d &$%#$% name'
        ]);

        // Assert
        $this->assertEquals(422, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            '{"errors":{"name":["Research name can only contain letters, numbers, spaces, dashes, commas and dots"]},"status":422,"type":"validation_failed","title":"Validation failed"}',
            $response->getContent()
        );
    }
}