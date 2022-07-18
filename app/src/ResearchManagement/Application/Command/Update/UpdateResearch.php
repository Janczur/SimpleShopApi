<?php
declare(strict_types=1);

namespace App\ResearchManagement\Application\Command\Update;

use App\ResearchManagement\Application\DTO\UpdateResearchDTO;
use App\Shared\Domain\System\CQRS\Command;

final class UpdateResearch implements Command
{
    public function __construct(
        private readonly string $uuid,
        private readonly UpdateResearchDTO $dto
    ) {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function code(): ?int
    {
        return $this->dto->code();
    }

    public function icdCode(): ?string
    {
        return $this->dto->icdCode();
    }

    public function shortDescription(): ?string
    {
        return $this->dto->shortDescription();
    }

    public function description(): ?string
    {
        return $this->dto->description();
    }
}