<?php
declare(strict_types=1);

namespace App\Shared\Infrastructure\Api\ApiProblem;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

final class ApiExceptionResponseHandler
{
    public function supports(Throwable $exception): bool
    {
        return $this->getStatusCode($exception) !== 500;
    }

    private function getStatusCode(Throwable $exception): int
    {
        if ($exception instanceof HttpExceptionInterface) {
            return $exception->getStatusCode();
        }
        return 500;
    }

    public function handle(Throwable $exception): ApiProblemResponse
    {
        if ($exception instanceof ApiProblemException) {
            $apiProblem = $exception->getApiProblem();
        } else {
            $apiProblem = ApiProblem::withStatusCode($this->getStatusCode($exception));
            $apiProblem->set('detail', $exception->getMessage());
        }
        return ApiProblemResponse::fromApiProblem($apiProblem);
    }
}