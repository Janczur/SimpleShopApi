<?php
declare(strict_types=1);

namespace App\ResearchManagement\Application\Query\FindByUuid;

use App\ResearchManagement\Application\Query\Model\ResearchView;
use App\ResearchManagement\Application\Query\ResearchQuery;
use App\Shared\Domain\System\CQRS\QueryHandler;

class FindByUuidHandler implements QueryHandler
{
    public function __construct(
        private readonly ResearchQuery $researchQuery
    ) {}

    public function __invoke(FindByUuid $query): ?ResearchView
    {
        return $this->researchQuery->research($query->uuid());
    }
}