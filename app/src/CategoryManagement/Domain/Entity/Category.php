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
    public function __construct(
        private readonly UuidInterface $uuid,
        private Name $name,
        private Slug $slug
    ) {}

    public static function create(Name $name, Slug $slug, CategoryUniquenessChecker $uniquenessChecker): self
    {
        if (!$uniquenessChecker->isUnique($slug)) {
            throw new CategoryExists($name);
        }
        // do some other logic, like record an event
        return new self(Uuid::uuid4(), $name, $slug);
    }

    public function uuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function slug(): Slug
    {
        return $this->slug;
    }

    public function rename(Name $name, CategoryUniquenessChecker $uniquenessChecker): void
    {
        $slug = Slug::fromName($name);
        if (!$uniquenessChecker->isUnique($slug)) {
            throw new CategoryExists($name);
        }
        $this->name = $name;
        $this->slug = $slug;
    }
}