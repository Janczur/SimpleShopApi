<?php
declare(strict_types=1);

namespace App\Shared\Infrastructure\Api\ApiProblem;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiProblemResponse extends JsonResponse
{
    private function __construct(ApiProblem $apiProblem)
    {
        parent::__construct($apiProblem->toArray(), $apiProblem->getStatusCode());
        $this->headers->set('Content-Type', 'application/problem+json');
    }

    public static function fromApiProblem(ApiProblem $apiProblem): self
    {
        return new self($apiProblem);
    }
}