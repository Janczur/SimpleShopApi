<?php
declare(strict_types=1);

namespace App\ResearchManagement\Application\Query;

use App\ResearchManagement\Application\Query\Model\ListResearchView;
use App\ResearchManagement\Application\Query\Model\SingleResearchView;

interface ResearchQuery
{
    public function research(string $uuid): ?SingleResearchView;

    public function findBySlug(string $slug): ?SingleResearchView;

    /**
     * @param string $slug
     * @return ListResearchView[]
     */
    public function findByCategorySlug(string $slug): array;
}