<?php

namespace App\System\CQRS;

interface CommandBus
{
    public function dispatch(Command $command): void;
}