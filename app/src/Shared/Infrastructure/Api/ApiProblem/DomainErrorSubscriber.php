<?php
declare(strict_types=1);

namespace App\Shared\Infrastructure\Api\ApiProblem;

use App\Shared\Domain\DomainError;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class DomainErrorSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => [
                ['formatDomainErrorResponse', 0]
            ]
        ];
    }

    public function formatDomainErrorResponse(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof DomainError && !$exception->getPrevious() instanceof DomainError) {
            return;
        }

        if ($exception->getPrevious() instanceof DomainError) {
            $exception = $exception->getPrevious();
        }

        $apiProblem = ApiProblem::withType(ApiProblem::DOMAIN_ERROR);
        $apiProblem->set('detail', $exception->errorMessage());

        $event->setResponse(ApiProblemResponse::fromApiProblem($apiProblem));
    }
}