<?php
declare(strict_types=1);

namespace App\System\CQRS;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

final class SpyCommandBus implements MessageBusInterface
{

    private Command $dispatchedCommand;

    public function dispatch($message, array $stamps = []): Envelope
    {
        $this->dispatchedCommand = $message;
        return new Envelope($message, $stamps);
    }

    public function lastDispatchedCommand(): Command
    {
        return $this->dispatchedCommand;
    }
}