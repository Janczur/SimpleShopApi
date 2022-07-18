<?php
declare(strict_types=1);

namespace App\ResearchManagement\Infrastructure\Doctrine\DBAL;

use App\ResearchManagement\Application\Query\Model\ResearchCategoryView;
use App\ResearchManagement\Application\Query\Model\ResearchView;
use App\ResearchManagement\Application\Query\ResearchQuery;
use Doctrine\DBAL\Connection;

class DoctrineDBALResearchQuery implements ResearchQuery
{

    public function __construct(
        private readonly Connection $connection
    ) {}

    public function research(string $uuid): ?ResearchView
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select(
            'uuid',
            'name',
            'slug',
            'code',
            'category_uuid',
            'icd_code',
            'short_description',
            'description',
            'created_at'
        )
            ->from('research')
            ->where('uuid = :uuid')
            ->setParameter('uuid', $uuid);
        $result = $queryBuilder->executeQuery();
        if (!$researchData = $result->fetchAssociative()) {
            return null;
        }
        if ($researchData['category_uuid']) {
            $category = $this->category($researchData['category_uuid']);
        } else {
            $category = null;
        }
        return new ResearchView(
            $researchData['uuid'],
            $researchData['name'],
            $researchData['slug'],
            $researchData['code'],
            $category,
            $researchData['icd_code'],
            $researchData['short_description'],
            $researchData['description'],
            $researchData['created_at']
        );

    }

    private function category(string $categoryUuid): ResearchCategoryView
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select(
            'uuid',
            'name',
            'slug'
        )
            ->from('category')
            ->where('uuid = :uuid')
            ->setParameter('uuid', $categoryUuid);
        $categoryData = $queryBuilder->executeQuery()->fetchAssociative();
        return new ResearchCategoryView(
            $categoryData['uuid'],
            $categoryData['name'],
            $categoryData['slug']
        );
    }

    public function findAll(): array
    {
        return [];
    }
}