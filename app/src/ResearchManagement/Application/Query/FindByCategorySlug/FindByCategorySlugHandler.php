<?php
declare(strict_types=1);

namespace App\ResearchManagement\Application\Query\FindByCategorySlug;

use App\ResearchManagement\Application\Query\ResearchQuery;
use App\Shared\Domain\System\CQRS\QueryHandler;

class FindByCategorySlugHandler implements QueryHandler
{
    public function __construct(
        private readonly ResearchQuery $researchQuery
    ) {}

    public function __invoke(FindByCategorySlug $query): array
    {
        return $this->researchQuery->findByCategorySlug($query->slug());
    }
}