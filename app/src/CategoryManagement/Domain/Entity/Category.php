<?php
declare(strict_types=1);

namespace App\CategoryManagement\Domain\Entity;

use App\CategoryManagement\Domain\Entity\Category\Name;
use App\CategoryManagement\Domain\Entity\Category\Slug;
use App\CategoryManagement\Domain\Exception\CategoryExists;
use App\CategoryManagement\Domain\Service\CategoryUniquenessChecker;
use App\Shared\Domain\Aggregate\AggregateRoot;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Category extends AggregateRoot
{

    private function __construct(
        private readonly UuidInterface $uuid,
        private readonly Name $name,
        private readonly Slug $slug
    ) {}

    public static function create(Name $name, Slug $slug, CategoryUniquenessChecker $categoryUniquenessChecker): self
    {
        if (!$categoryUniquenessChecker->isUnique($slug)) {
            throw new CategoryExists($name);
        }
        // do some other logic, like record an event
        return new self(Uuid::uuid4(), $name, $slug);
    }

    public function slug(): Slug
    {
        return $this->slug;
    }
}