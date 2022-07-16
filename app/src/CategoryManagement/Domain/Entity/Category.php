<?php
declare(strict_types=1);

namespace App\CategoryManagement\Domain\Entity;

use App\CategoryManagement\Domain\Entity\Category\Name;
use App\CategoryManagement\Domain\Entity\Category\Slug;
use App\CategoryManagement\Domain\Service\CategoryUniquenessChecker;
use DomainException;
use Symfony\Component\Uid\Uuid;

class Category
{
    private readonly Uuid $uuid;
    private readonly Name $name;
    private readonly Slug $slug;

    public function __construct(
        Name $name,
        Slug $slug,
        CategoryUniquenessChecker $categoryUniquenessChecker
    )
    {
        if (!$categoryUniquenessChecker->isUnique($this)) {
            throw new DomainException('Category already exists');
        }
        $this->uuid = Uuid::v4();
        $this->name = $name;
        $this->slug = $slug;
    }

    public function slug(): Slug
    {
        return $this->slug;
    }
}