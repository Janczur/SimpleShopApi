<?php
declare(strict_types=1);

namespace App\Tests\Application\ResearchManagement;

use App\Tests\Application\ApiTestCase;
use App\Tests\Factory\Research\ResearchFactory;
use Ramsey\Uuid\Uuid;

class DeleteResearchTest extends ApiTestCase
{
    /** @test */
    public function canDeleteExistingResearch(): void
    {
        // Arrange
        ResearchFactory::createOne([
            'uuid' => $uuid = Uuid::uuid4()
        ]);

        // Act
        $response = $this->makeDeleteRequest('/researches', $uuid->toString());

        // Assert
        $this->assertEquals(204, $response->getStatusCode());
    }

    /** @test */
    public function cannotDeleteResearchThatDoesNotExists(): void
    {
        // Arrange & Act
        $response = $this->makeDeleteRequest('/researches', Uuid::uuid4()->toString());

        // Assert
        $this->assertEquals(404, $response->getStatusCode());
    }

}