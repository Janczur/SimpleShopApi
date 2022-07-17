<?php
declare(strict_types=1);

namespace App\CategoryManagement\Application\Command\Delete;

use App\Shared\Domain\System\CQRS\Command;
use Ramsey\Uuid\UuidInterface;

final class DeleteCategory implements Command
{
    public function __construct(
        private readonly UuidInterface $uuid
    ) {}

    public function uuid(): UuidInterface
    {
        return $this->uuid;
    }
}