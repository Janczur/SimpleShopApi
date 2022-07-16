<?php
declare(strict_types=1);

namespace App\CategoryManagement\Domain\Entity\Category;

use InvalidArgumentException;

class Name
{
    private function __construct(
        private readonly string $name
    ) {}

    public static function fromString(string $name): self
    {
        if (!preg_match('/^[a-zA-Z0-9\-_]+$/', $name)) {
            throw new InvalidArgumentException(
                'Category name can only contain letters, numbers, dashes and underscores'
            );
        }
        if (strlen($name) > 100) {
            throw new InvalidArgumentException('Name is too long');
        }
        return new self($name);
    }
}