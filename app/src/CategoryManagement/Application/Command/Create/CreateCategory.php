<?php
declare(strict_types=1);

namespace App\CategoryManagement\Application\Command\Create;

use App\Shared\Domain\System\CQRS\Command;

final class CreateCategory implements Command
{
    public function __construct(
        private readonly string $name
    ) {}

    public function name(): string
    {
        return $this->name;
    }
}