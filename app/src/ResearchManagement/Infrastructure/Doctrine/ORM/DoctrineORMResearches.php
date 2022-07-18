<?php
declare(strict_types=1);

namespace App\ResearchManagement\Infrastructure\Doctrine\ORM;

use App\CategoryManagement\Domain\Entity\Category;
use App\ResearchManagement\Domain\Entity\Research;
use App\ResearchManagement\Domain\Model\ResearchCategory;
use App\ResearchManagement\Domain\Repository\Researches;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

class DoctrineORMResearches implements Researches
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {}

    public function add(Research $research): void
    {
        $this->entityManager->persist($research);
    }

    public function findCategory(string $uuid): ?ResearchCategory
    {
        $category = $this->entityManager->find(Category::class, $uuid);
        if ($category === null) {
            return null;
        }
        return new ResearchCategory(
            $category->uuid()->toString(),
            $category->name()->toString(),
            $category->slug()->toString()
        );
    }

    public function find(UuidInterface $uuid): ?Research
    {
        return $this->entityManager->find(Research::class, $uuid);
    }

    public function findBySlugAndCategoryUuid(Research\Slug $slug, ?string $categoryUuid): ?Research
    {
        return $this->entityManager->getRepository(Research::class)->findOneBy([
            'slug.value' => $slug->toString(),
            'categoryUuid' => $categoryUuid
        ]);
    }

    public function remove(Research $research): void
    {
        $this->entityManager->remove($research);
    }
}