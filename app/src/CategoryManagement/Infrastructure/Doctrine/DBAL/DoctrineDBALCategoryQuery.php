<?php
declare(strict_types=1);

namespace App\CategoryManagement\Infrastructure\Doctrine\DBAL;

use App\CategoryManagement\Application\Query\CategoryQuery;
use App\CategoryManagement\Application\Query\Model\Category;
use Doctrine\DBAL\Connection;

class DoctrineDBALCategoryQuery implements CategoryQuery
{
    public function __construct(
        private readonly Connection $connection
    ) {}

    public function category(string $uuid): ?Category
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select('uuid', 'name', 'slug')
            ->from('category')
            ->where('uuid = :uuid')
            ->setParameter('uuid', $uuid);
        $result = $queryBuilder->executeQuery();
        if (!$categoryData = $result->fetchAssociative()) {
            return null;
        }
        return new Category($categoryData['uuid'], $categoryData['name'], $categoryData['slug']);
    }

    public function findAll(): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select('uuid', 'name', 'slug')
            ->from('category');
        $categories = $queryBuilder->executeQuery()->fetchAllAssociative();
        return array_map(static function (array $categoryData) {
            return new Category($categoryData['uuid'], $categoryData['name'], $categoryData['slug']);
        }, $categories);
    }
}