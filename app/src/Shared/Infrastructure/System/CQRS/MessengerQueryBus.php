<?php
declare(strict_types=1);

namespace App\Shared\Infrastructure\System\CQRS;

use App\Shared\Domain\System\CQRS\Query;
use App\Shared\Domain\System\CQRS\QueryBus;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class MessengerQueryBus implements QueryBus
{
    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    public function query(Query $query): mixed
    {
        return $this->handle($query);
    }
}