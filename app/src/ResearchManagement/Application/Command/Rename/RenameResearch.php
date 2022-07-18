<?php
declare(strict_types=1);

namespace App\ResearchManagement\Application\Command\Rename;

use App\ResearchManagement\Application\DTO\RenameResearchDTO;
use App\Shared\Domain\System\CQRS\Command;

class RenameResearch implements Command
{
    public function __construct(
        private readonly string $uuid,
        private readonly RenameResearchDTO $dto
    ) {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function newName(): string
    {
        return $this->dto->name();
    }
}