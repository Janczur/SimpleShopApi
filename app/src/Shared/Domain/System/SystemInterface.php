<?php
declare(strict_types=1);

namespace App\Shared\Domain\System;

use App\Shared\Domain\System\CQRS\Command;
use App\Shared\Domain\System\CQRS\Query;

interface SystemInterface
{
    public function dispatch(Command $command): void;

    public function query(Query $query): mixed;

}