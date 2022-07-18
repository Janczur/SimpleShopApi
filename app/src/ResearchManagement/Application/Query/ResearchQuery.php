<?php
declare(strict_types=1);

namespace App\ResearchManagement\Application\Query;

use App\ResearchManagement\Application\Query\Model\ResearchView;

interface ResearchQuery
{
    public function research(string $uuid): ?ResearchView;

    /**
     * @return ResearchView[]
     */
    public function findAll(): array;
}