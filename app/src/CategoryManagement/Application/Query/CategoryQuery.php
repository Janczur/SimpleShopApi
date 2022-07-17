<?php
declare(strict_types=1);

namespace App\CategoryManagement\Application\Query;

use App\CategoryManagement\Application\Query\Model\Category;

interface CategoryQuery
{
    public function category(string $uuid): ?Category;

    /**
     * @return Category[]
     */
    public function findAll(): array;
}