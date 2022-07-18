<?php
declare(strict_types=1);

namespace App\ResearchManagement\Infrastructure\Doctrine\DBAL;

use App\ResearchManagement\Application\Query\Model\ListResearchView;
use App\ResearchManagement\Application\Query\Model\ResearchCategoryView;
use App\ResearchManagement\Application\Query\Model\SingleResearchView;
use App\ResearchManagement\Application\Query\ResearchQuery;
use Doctrine\DBAL\Connection;

class DoctrineDBALResearchQuery implements ResearchQuery
{

    public function __construct(
        private readonly Connection $connection
    ) {}

    public function research(string $uuid): ?SingleResearchView
    {
        return $this->findBy('uuid', $uuid);
    }

    private function findBy($field, $value): ?SingleResearchView
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
            ->where("$field = :$field")
            ->setParameter($field, $value);
        $result = $queryBuilder->executeQuery();
        if (!$researchData = $result->fetchAssociative()) {
            return null;
        }
        if ($researchData['category_uuid']) {
            $category = $this->category($researchData['category_uuid']);
        } else {
            $category = null;
        }
        return new SingleResearchView(
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

    public function findBySlug(string $slug): ?SingleResearchView
    {
        return $this->findBy('slug', $slug);
    }

    /**
     * @inheritDoc
     */
    public function findByCategorySlug(string $slug): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select(
            'uuid'
        )
            ->from('category')
            ->where('slug = :slug')
            ->setParameter('slug', $slug);
        $categoryUuid = $queryBuilder->executeQuery()->fetchOne();

        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select(
            'name',
            'slug',
            'code',
            'icd_code',
        )
            ->from('research')
            ->where('category_uuid = :category_uuid')
            ->setParameter('category_uuid', $categoryUuid);
        $researchData = $queryBuilder->executeQuery()->fetchAllAssociative();
        return array_map(static function (array $researchData) {
            return new ListResearchView(
                $researchData['name'],
                $researchData['slug'],
                $researchData['code'],
                $researchData['icd_code'],
            );
        }, $researchData);
    }
}