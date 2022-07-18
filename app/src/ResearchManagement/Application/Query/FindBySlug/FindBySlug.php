<?php
declare(strict_types=1);

namespace App\ResearchManagement\Application\Query\FindBySlug;

use App\Shared\Domain\System\CQRS\Query;

final class FindBySlug implements Query
{
    public function __construct(
        private readonly string $slug
    ) {}

    public function slug(): string
    {
        return $this->slug;
    }
}