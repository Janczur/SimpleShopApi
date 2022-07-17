<?php
declare(strict_types=1);

namespace App\Shared\Infrastructure\Validator;

use App\Shared\Infrastructure\Api\ApiProblem\ApiProblem;
use App\Shared\Infrastructure\Api\ApiProblem\ApiProblemResponse;
use App\Shared\Infrastructure\Validator\Exception\ValidationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationFailedExceptionSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => [
                ['formatApiValidationExceptionResponse', 0]
            ]
        ];
    }

    public function formatApiValidationExceptionResponse(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof ValidationFailedException && !$exception instanceof ValidationException) {
            return;
        }

        $errors = $this->getErrors($exception->getViolations());

        $apiProblem = ApiProblem::withType(ApiProblem::VALIDATION_FAILED);
        $apiProblem->set('errors', $errors);

        $event->setResponse(ApiProblemResponse::fromApiProblem($apiProblem));
    }

    private function getErrors(ConstraintViolationListInterface $violations): array
    {
        $errors = [];

        foreach ($violations as $violation) {
            $propertyPath = $violation->getPropertyPath();
            $errors[$propertyPath][] = $violation->getMessage();
        }

        return $errors;
    }
}