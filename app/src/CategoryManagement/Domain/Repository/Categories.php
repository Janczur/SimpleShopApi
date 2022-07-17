<?php
declare(strict_types=1);

namespace App\CategoryManagement\Domain\Repository;

use App\CategoryManagement\Domain\Entity\Category;
use Ramsey\Uuid\UuidInterface;

interface Categories
{
    public function add(Category $category): void;

    public function find(UuidInterface $uuid): ?Category;

    public function findBySlug(Category\Slug $slug): ?Category;

    public function remove(Category $category): void;
}