<?php
declare(strict_types=1);

namespace App\ResearchManagement\Application\Query\Model;

class SingleResearchView
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $name,
        public readonly string $slug,
        public readonly int $code,
        public readonly ?ResearchCategoryView $category,
        public readonly ?string $icdCode,
        public readonly ?string $shortDescription,
        public readonly ?string $description,
        public readonly ?string $createdAt,
    ) {}
}