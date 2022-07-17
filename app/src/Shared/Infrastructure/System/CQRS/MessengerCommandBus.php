<?php
declare(strict_types=1);

namespace App\Shared\Infrastructure\System\CQRS;

use App\Shared\Domain\System\CQRS\Command;
use App\Shared\Domain\System\CQRS\CommandBus;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerCommandBus implements CommandBus
{

    public function __construct(
        private readonly MessageBusInterface $commandBus
    ) {}

    public function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }
}