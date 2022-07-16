<?php
declare(strict_types=1);

namespace App\CategoryManagement\Domain\Entity\Category;

class Slug
{
    private function __construct(
        private readonly string $slug
    ) {}

    public static function fromName(Name $name): self
    {
        $slug = strtolower(preg_replace('/[^a-z0-9]+/', '-', $name->toString()));
        return new self($slug);
    }

    public function toString(): string
    {
        return $this->slug;
    }
}