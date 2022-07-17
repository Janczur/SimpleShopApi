<?php
declare(strict_types=1);

namespace App\Shared\Infrastructure\Api\ApiProblem;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class ApiProblemException extends HttpException
{
    private ApiProblem $apiProblem;

    public function __construct(ApiProblem $apiProblem, ?Throwable $previous = null)
    {
        $this->apiProblem = $apiProblem;
        parent::__construct($apiProblem->getStatusCode(), $apiProblem->getTitle(), $previous);
    }

    public function getApiProblem(): ApiProblem
    {
        return $this->apiProblem;
    }
}