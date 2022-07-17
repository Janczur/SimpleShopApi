<?php
declare(strict_types=1);

namespace App\CategoryManagement\Application\Query\FindByUuid;

use App\CategoryManagement\Application\Query\CategoryQuery;
use App\CategoryManagement\Application\Query\Model\Category;
use App\Shared\Domain\System\CQRS\QueryHandler;

class FindByUuidHandler implements QueryHandler
{
    public function __construct(
        private readonly CategoryQuery $categoryQuery
    ) {}

    public function __invoke(FindByUuid $query): ?Category
    {
        return $this->categoryQuery->category($query->uuid());
    }
}