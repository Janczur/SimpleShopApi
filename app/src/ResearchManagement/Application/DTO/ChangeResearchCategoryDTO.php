<?php
declare(strict_types=1);

namespace App\ResearchManagement\Application\DTO;

final class ChangeResearchCategoryDTO
{
    public function __construct(
        private readonly ?string $categoryUuid,
    ) {}

    public function categoryUuid(): ?string
    {
        return $this->categoryUuid;
    }
}