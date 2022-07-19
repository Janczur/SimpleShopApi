<?php
declare(strict_types=1);

namespace App\ResearchManagement\Application\Command\ChangeCategory;

use App\ResearchManagement\Application\DTO\ChangeResearchCategoryDTO;
use App\Shared\Domain\System\CQRS\Command;

class ChangeResearchCategory implements Command
{
    public function __construct(
        private readonly string $uuid,
        private readonly ChangeResearchCategoryDTO $dto
    ) {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function dto(): ChangeResearchCategoryDTO
    {
        return $this->dto;
    }
}