<?php
declare(strict_types=1);

namespace App\Shared\Infrastructure\Mapper;

use App\Shared\Infrastructure\Api\ApiProblem\ApiProblem;
use App\Shared\Infrastructure\Api\ApiProblem\ApiProblemException;
use App\Shared\Infrastructure\Validator\Exception\ValidationException;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\Exception\MissingConstructorArgumentsException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use UnexpectedValueException;

class RequestObjectMapper
{

    private Request $request;
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(
        RequestStack $requestStack,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    )
    {
        if (!$request = $requestStack->getCurrentRequest()) {
            throw new RuntimeException('Request stack does not contain any request!');
        }
        $this->request = $request;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function map(string $className, array $context = [], string $type = 'json'): object
    {
        try {
            $deserializedObject = $this->serializer->deserialize($this->getContent($type), $className, $type, $context);
        } catch (MissingConstructorArgumentsException $e) {
            $apiProblem = ApiProblem::withType(ApiProblem::REQUIRED_PARAMETER_MISSING);
            $apiProblem->set('parameterName', implode(', ', $e->getMissingConstructorArguments()));
            throw new ApiProblemException($apiProblem, $e);
        } catch (NotNormalizableValueException $e) {
            $apiProblem = ApiProblem::withType(ApiProblem::INVALID_PARAMETER_TYPE);
            $apiProblem->set('parameterName', $e->getPath());
            $apiProblem->set('currentType', $e->getCurrentType());
            $apiProblem->set('expectedTypes', $e->getExpectedTypes());
            throw new ApiProblemException($apiProblem, $e);
        } catch (UnexpectedValueException $e) {
            throw new ApiProblemException(ApiProblem::withType(ApiProblem::INVALID_BODY_FORMAT), $e);
        }

        $violationList = $this->validator->validate($deserializedObject, null, $this->validationGroups ?? []);
        if ($violationList->count() > 0) {
            throw new ValidationException($violationList);
        }

        return $deserializedObject;
    }

    private function getContent(string $type): string
    {
        if ($this->request->getMethod() === Request::METHOD_GET) {
            return $this->serializer->serialize($this->request->query->all(), $type);
        }
        return $this->request->getContent();
    }
}