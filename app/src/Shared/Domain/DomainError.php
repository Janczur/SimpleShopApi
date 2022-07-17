<?php
declare(strict_types=1);

namespace App\Shared\Domain;

use DomainException;

abstract class DomainError extends DomainException
{

    abstract public function errorMessage(): string;

    abstract public function errorCode(): string;
}