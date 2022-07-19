<?php
declare(strict_types=1);

namespace App\Tests\Shared\Infrastructure\Api\ApiProblem;

use App\Shared\Infrastructure\Api\ApiProblem\ApiProblem;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class ApiProblemTest extends TestCase
{
    /** @test */
    public function itCorrectlyCreatesApiProblemOfKnownTypes(): void
    {
        // Arrange & Act
        $apiProblemValidationError = ApiProblem::withType(ApiProblem::VALIDATION_FAILED);
        $apiProblemInvalidBodyFormat = ApiProblem::withType(ApiProblem::INVALID_BODY_FORMAT);

        // Assert
        $this->assertEquals([
            'status' => 422,
            'type' => 'validation_failed',
            'title' => 'Validation failed',
        ], $apiProblemValidationError->toArray());

        $this->assertEquals([
            'status' => 400,
            'type' => 'invalid_body_format',
            'title' => 'Invalid request body format',
        ], $apiProblemInvalidBodyFormat->toArray());
    }

    /** @test */
    public function itCorrectlyCreatesApiProblemWithStatusCode(): void
    {
        // Arrange & Act
        $apiProblem405 = ApiProblem::withStatusCode(405);
        $apiProblem307 = ApiProblem::withStatusCode(307);
        $apiProblem204 = ApiProblem::withStatusCode(204);

        // Assert
        $this->assertEquals([
            'status' => 405,
            'type' => 'unknown',
            'title' => 'Method Not Allowed',
        ], $apiProblem405->toArray());

        $this->assertEquals([
            'status' => 307,
            'type' => 'unknown',
            'title' => 'Temporary Redirect',
        ], $apiProblem307->toArray());

        $this->assertEquals([
            'status' => 204,
            'type' => 'unknown',
            'title' => 'No Content',
        ], $apiProblem204->toArray());
    }

    /** @test */
    public function itThrowsExceptionWhenTypeIsUnknown(): void
    {
        $this->expectException(InvalidArgumentException::class);
        ApiProblem::withType('some_type');
    }

    /** @test */
    public function itSetsCorrectTitleWhenStatusCodeIsUnknown(): void
    {
        // Arrange & Act
        $apiProblem = ApiProblem::withStatusCode(499);

        // Assert
        $this->assertEquals('Unknown status code', $apiProblem->getTitle());
    }

    /** @test */
    public function itCorrectlyAddsExtraData(): void
    {
        // Arrange
        $apiProblem = ApiProblem::withType(ApiProblem::VALIDATION_FAILED);

        // Act
        $apiProblem->set('foo', 'bar');

        // Assert
        $this->assertEquals([
            'status' => 422,
            'type' => 'validation_failed',
            'title' => 'Validation failed',
            'foo' => 'bar',
        ], $apiProblem->toArray());
    }
}