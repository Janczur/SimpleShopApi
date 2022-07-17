<?php
declare(strict_types=1);

namespace App\Shared\Domain\System\CQRS;

interface QueryBus
{
    public function query(Query $query): mixed;
}