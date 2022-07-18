<?php
declare(strict_types=1);

namespace App\CategoryManagement\Application\Query;

use App\CategoryManagement\Application\Query\Model\CategoryView;

interface CategoryQuery
{
    public function category(string $uuid): ?CategoryView;

    /**
     * @return CategoryView[]
     */
    public function findAll(): array;
}