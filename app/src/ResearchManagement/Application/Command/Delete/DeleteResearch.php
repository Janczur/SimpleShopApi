<?php
declare(strict_types=1);

namespace App\ResearchManagement\Application\Command\Delete;

use App\Shared\Domain\System\CQRS\Command;
use Ramsey\Uuid\UuidInterface;

final class DeleteResearch implements Command
{
    public function __construct(
        private readonly UuidInterface $uuid
    ) {}

    public function uuid(): UuidInterface
    {
        return $this->uuid;
    }
}