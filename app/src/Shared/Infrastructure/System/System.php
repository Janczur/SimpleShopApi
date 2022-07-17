<?php
declare(strict_types=1);

namespace App\Shared\Infrastructure\System;

use App\Shared\Domain\System\CQRS\Command;
use App\Shared\Domain\System\CQRS\CommandBus;
use App\Shared\Domain\System\CQRS\Query;
use App\Shared\Domain\System\CQRS\QueryBus;
use App\Shared\Domain\System\SystemInterface;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;

final class System implements SystemInterface
{
    public function __construct(
        private readonly CommandBus $commandBus,
        private readonly QueryBus $queryBus,
        private readonly EntityManagerInterface $entityManager
    ) {}

    /**
     * @throws Exception
     */
    public function dispatch(Command $command): void
    {
        $this->entityManager->getConnection()->beginTransaction();
        try {
            $this->commandBus->dispatch($command);
            $this->entityManager->flush();
            $this->entityManager->getConnection()->commit();
        } catch (Exception $exception) {
            $this->entityManager->getConnection()->rollBack();
            throw $exception;
        }
    }

    public function query(Query $query): mixed
    {
        return $this->queryBus->query($query);
    }
}