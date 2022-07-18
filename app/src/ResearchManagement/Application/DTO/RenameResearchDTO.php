<?php
declare(strict_types=1);

namespace App\ResearchManagement\Application\DTO;

final class RenameResearchDTO
{
    public function __construct(
        private readonly string $name
    ) {}

    public function name(): string
    {
        return $this->name;
    }
}