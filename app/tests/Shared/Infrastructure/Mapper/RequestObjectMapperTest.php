<?php
declare(strict_types=1);

namespace App\Tests\Shared\Infrastructure\Mapper;

use App\Shared\Infrastructure\Api\ApiProblem\ApiProblemException;
use App\Shared\Infrastructure\Mapper\RequestObjectMapper;
use App\Shared\Infrastructure\Validator\Exception\ValidationException;
use App\Tests\DummyData\DummyDTO;
use Faker\Factory;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class RequestObjectMapperTest extends KernelTestCase
{
    private ContainerInterface $container;

    public function setUp(): void
    {
        $this->container = static::getContainer();
        $this->faker = Factory::create();
    }

    /** @test */
    public function itRequiresHttpRequestToExist(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Request stack does not contain any request!');

        $this->container->get(RequestObjectMapper::class);
    }

    /** @test */
    public function itCorrectlyMapsPostRequestToGivenObject(): void
    {
        // Arrange
        $requestData = [
            'uuid' => $this->faker->uuid(),
            'name' => $this->faker->name(),
        ];
        $requestObjectMapper = $this->createObjectMapperWithPostRequest($requestData);

        // Act
        $dto = $requestObjectMapper->map(DummyDTO::class);

        // Assert
        $this->assertInstanceOf(DummyDTO::class, $dto);
        $this->assertSame($requestData['uuid'], $dto->getUuid());
        $this->assertSame($requestData['name'], $dto->getName());
    }

    private function createObjectMapperWithPostRequest(array $requestData): RequestObjectMapper
    {
        $request = new Request([], [], [], [], [], [], json_encode($requestData));
        $request->setMethod('POST');
        $requestStack = new RequestStack();
        $requestStack->push($request);

        return new RequestObjectMapper(
            $requestStack,
            $this->container->get('serializer'),
            $this->container->get('validator')
        );
    }

    /** @test */
    public function itThrowsExceptionWhenARequiredParameterOnTheRequestIsMissing(): void
    {
        // Arrange
        $requestData = [
            'name' => $this->faker->name(),
        ];
        $requestObjectMapper = $this->createObjectMapperWithPostRequest($requestData);

        // Assert
        $this->expectException(ApiProblemException::class);
        $this->expectExceptionMessage('Required parameter is missing');

        // Act
        $requestObjectMapper->map(DummyDTO::class);
    }

    /** @test */
    public function itThrowsExceptionWhenARequestDataHasFailedValidation(): void
    {
        // Arrange
        $requestData = [
            'uuid' => 'not-an-uuid',
            'name' => $this->faker->name(),
        ];
        $requestObjectMapper = $this->createObjectMapperWithPostRequest($requestData);

        // Assert
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Validation failed');

        // Act
        $requestObjectMapper->map(DummyDTO::class);
    }

    /** @test */
    public function itThrowsExceptionWhenTheRequestParameterIsOfTheWrongType(): void
    {
        // Arrange
        $requestData = [
            'uuid' => $this->faker->uuid(),
            'name' => $this->faker->randomNumber(),
        ];
        $requestObjectMapper = $this->createObjectMapperWithPostRequest($requestData);

        // Assert
        $this->expectException(ApiProblemException::class);
        $this->expectExceptionMessage('Invalid parameter type');

        // Act
        $requestObjectMapper->map(DummyDTO::class);
    }

    /** @test */
    public function itCorrectlyMapsGetRequestToGivenObject(): void
    {
        // Arrange
        $requestData = [
            'uuid' => $this->faker->uuid(),
            'name' => $this->faker->name(),
        ];
        $request = new Request($requestData);
        $requestStack = new RequestStack();
        $requestStack->push($request);

        $requestObjectMapper = new RequestObjectMapper(
            $requestStack,
            $this->container->get('serializer'),
            $this->container->get('validator')
        );

        // Act
        $dto = $requestObjectMapper->map(DummyDTO::class);

        // Assert
        $this->assertInstanceOf(DummyDTO::class, $dto);
        $this->assertSame($requestData['uuid'], $dto->getUuid());
        $this->assertSame($requestData['name'], $dto->getName());
    }
}