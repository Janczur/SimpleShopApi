<?php
declare(strict_types=1);

namespace App\ResearchManagement\Domain\Repository;

use App\ResearchManagement\Domain\Entity\Research;
use App\ResearchManagement\Domain\Model\ResearchCategory;
use Ramsey\Uuid\UuidInterface;

interface Researches
{
    public function add(Research $research): void;

    public function find(UuidInterface $uuid): ?Research;

    public function findCategory(string $uuid): ?ResearchCategory;

    public function findBySlugAndCategoryUuid(Research\Slug $slug, ?string $categoryUuid): ?Research;

    public function remove(Research $research): void;
}