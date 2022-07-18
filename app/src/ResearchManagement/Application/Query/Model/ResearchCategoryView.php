<?php
declare(strict_types=1);

namespace App\ResearchManagement\Application\Query\Model;

final class ResearchCategoryView
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $name,
        public readonly string $slug
    ) {}
}