<?php
declare(strict_types=1);

namespace App\CategoryManagement\Application\Query\Model;

final class CategoryView
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $name,
        public readonly string $slug
    ) {}

}