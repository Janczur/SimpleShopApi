<?php
declare(strict_types=1);

namespace App\ResearchManagement\Application\DTO;

final class UpdateResearchDTO
{
    public function __construct(
        private readonly ?int $code,
        private readonly ?string $icdCode,
        private readonly ?string $shortDescription,
        private readonly ?string $description,
    ) {}

    public function code(): ?int
    {
        return $this->code;
    }

    public function icdCode(): ?string
    {
        return $this->icdCode;
    }

    public function shortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function description(): ?string
    {
        return $this->description;
    }
}