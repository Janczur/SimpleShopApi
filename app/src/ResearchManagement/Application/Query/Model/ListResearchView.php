<?php
declare(strict_types=1);

namespace App\ResearchManagement\Application\Query\Model;

class ListResearchView
{
    public function __construct(
        public readonly string $name,
        public readonly string $slug,
        public readonly int $code,
        public readonly ?string $icdCode,
    ) {}
}