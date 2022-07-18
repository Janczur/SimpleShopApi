<?php
declare(strict_types=1);

namespace App\CategoryManagement\Application\DTO;

class UpdateCategoryDTO
{
    public function __construct(
        private readonly string $name,
    ) {}

    public function name(): string
    {
        return $this->name;
    }
}