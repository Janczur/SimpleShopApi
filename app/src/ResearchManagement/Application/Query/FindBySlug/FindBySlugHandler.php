<?php
declare(strict_types=1);

namespace App\ResearchManagement\Application\Query\FindBySlug;

use App\ResearchManagement\Application\Query\Model\SingleResearchView;
use App\ResearchManagement\Application\Query\ResearchQuery;
use App\Shared\Domain\System\CQRS\QueryHandler;

final class FindBySlugHandler implements QueryHandler
{
    public function __construct(
        private readonly ResearchQuery $researchQuery
    ) {}

    public function __invoke(FindBySlug $query): ?SingleResearchView
    {
        return $this->researchQuery->findBySlug($query->slug());
    }
}