<?php
declare(strict_types=1);

namespace App\System;

use App\System\CQRS\Command;
use App\System\CQRS\CommandBus;
use App\System\CQRS\Query;
use App\System\CQRS\QueryBus;
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