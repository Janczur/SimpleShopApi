<?php
declare(strict_types=1);

namespace App\ResearchManagement\Domain\Entity\Research;

use App\Shared\Domain\Utils\Sluggerizer;

final class Slug
{
    private function __construct(
        private readonly string $value
    ) {}

    public static function fromName(Name $name): self
    {
        $slug = Sluggerizer::slugify($name->toString());
        return new self($slug);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function equals(Slug $slug): bool
    {
        return $this->value === $slug->toString();
    }
}