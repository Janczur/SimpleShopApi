<?php
declare(strict_types=1);

namespace App\ResearchManagement\Domain\Service;

use App\ResearchManagement\Domain\Entity\Research\Slug;
use App\ResearchManagement\Domain\Repository\Researches;

final class ResearchUniquenessValidator
{
    public function __construct(
        private readonly Researches $researches
    ) {}

    public function isUnique(Slug $slug, ?string $categoryUuid): bool
    {
        return $this->researches->findBySlugAndCategoryUuid($slug, $categoryUuid) === null;
    }
}