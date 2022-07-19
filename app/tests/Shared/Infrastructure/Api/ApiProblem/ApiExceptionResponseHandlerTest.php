<?php
declare(strict_types=1);

namespace App\Tests\Shared\Infrastructure\Api\ApiProblem;

use App\Shared\Infrastructure\Api\ApiProblem\ApiExceptionResponseHandler;
use App\Shared\Infrastructure\Api\ApiProblem\ApiProblem;
use App\Shared\Infrastructure\Api\ApiProblem\ApiProblemException;
use LogicException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class ApiExceptionResponseHandlerTest extends TestCase
{
    private ApiExceptionResponseHandler $handler;

    public function setUp(): void
    {
        $this->handler = new ApiExceptionResponseHandler();
    }

    /** @test */
    public function itSupportsExceptionsThatImplementHttpExceptionInterface(): void
    {
        // Arrange
        $exception = new HttpException(404, 'Not found');

        // Act & Assert
        self::assertTrue($this->handler->supports($exception));
    }

    /** @test */
    public function itDoesNotSupportsExceptionsThatDoNotImplementHttpExceptionInterface(): void
    {
        // Arrange
        $exception = new LogicException('Something went wrong');

        // Act & Assert
        self::assertFalse($this->handler->supports($exception));
    }

    /** @test */
    public function itCreatesApiProblemResponseFromApiProblemException(): void
    {
        // Arrange
        $apiProblem = ApiProblem::withType(ApiProblem::INVALID_BODY_FORMAT);
        $exception = new ApiProblemException($apiProblem);
        $expectedJson = json_encode($apiProblem->toArray());

        // Act
        $response = $this->handler->handle($exception);

        // Assert
        self::assertEquals('application/problem+json', $response->headers->get('content-Type'));
        self::assertJsonStringEqualsJsonString(
            $expectedJson,
            $response->getContent()
        );
    }

    /** @test */
    public function itCreatesApiProblemResponseFromAnyHttpException(): void
    {
        // Arrange
        $exception = new HttpException(410, 'Gone');
        $expectedJson = '{"detail":"Gone","status":410,"type":"unknown","title":"Gone"}';

        // Act
        $response = $this->handler->handle($exception);

        // Assert
        self::assertEquals('application/problem+json', $response->headers->get('content-Type'));
        self::assertJsonStringEqualsJsonString(
            $expectedJson,
            $response->getContent()
        );
    }
}