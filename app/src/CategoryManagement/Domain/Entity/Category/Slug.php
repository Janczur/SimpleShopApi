<?php
declare(strict_types=1);

namespace App\CategoryManagement\Domain\Entity\Category;

class Slug
{
    private function __construct(
        private readonly string $value
    ) {}

    public static function fromName(Name $name): self
    {
        $slug = preg_replace('/[^a-z0-9]+/', '-', strtolower($name->asString()));
        return new self($slug);
    }

    public function asString(): string
    {
        return $this->value;
    }

    public function equals(Slug $slug): bool
    {
        return $this->value === $slug->asString();
    }
}