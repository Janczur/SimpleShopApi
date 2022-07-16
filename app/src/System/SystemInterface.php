<?php
declare(strict_types=1);

namespace App\System;

use App\System\CQRS\Command;
use App\System\CQRS\Query;

interface SystemInterface
{
    public function dispatch(Command $command): void;

    public function query(Query $query): mixed;

}