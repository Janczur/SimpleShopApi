<?php

namespace App\Shared\Domain\System\CQRS;

interface CommandBus
{
    public function dispatch(Command $command): void;
}