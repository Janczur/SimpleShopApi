<?php
declare(strict_types=1);

namespace App\System\CQRS;

interface QueryBus
{
    public function query(Query $query): mixed;
}