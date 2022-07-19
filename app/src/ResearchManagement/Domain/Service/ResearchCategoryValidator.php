<?php
declare(strict_types=1);

namespace App\ResearchManagement\Domain\Service;

use App\ResearchManagement\Domain\Repository\Researches;

final class ResearchCategoryValidator
{
    public function __construct(
        private readonly Researches $researches
    ) {}

    public function exists(string $categoryUuid): bool
    {
        return $this->researches->findCategory($categoryUuid) !== null;
    }
}