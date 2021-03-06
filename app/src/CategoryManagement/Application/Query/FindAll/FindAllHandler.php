<?php
declare(strict_types=1);

namespace App\CategoryManagement\Application\Query\FindAll;

use App\CategoryManagement\Application\Query\CategoryQuery;
use App\CategoryManagement\Application\Query\Model\CategoryView;
use App\Shared\Domain\System\CQRS\QueryHandler;

final class FindAllHandler implements QueryHandler
{
    public function __construct(
        private readonly CategoryQuery $categoryQuery
    ) {}

    /**
     * @return CategoryView[]
     */
    public function __invoke(FindAll $query): array
    {
        return $this->categoryQuery->findAll();
    }
}