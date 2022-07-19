<?php
declare(strict_types=1);

namespace App\Shared\Infrastructure\Api\ApiProblem;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class ApiExceptionSubscriber implements EventSubscriberInterface
{

    public function __construct(
        private readonly ApiExceptionResponseHandler $apiExceptionResponseHandler
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => [
                ['formatApiExceptionResponse', 0],
                ['logApiException', -10],
            ]
        ];
    }

    public function logApiException(ExceptionEvent $event): void
    {
        // @todo implement integration with logging service
    }

    public function formatApiExceptionResponse(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if ($this->apiExceptionResponseHandler->supports($exception)) {
            $event->setResponse($this->apiExceptionResponseHandler->handle($exception));
        }
    }
}