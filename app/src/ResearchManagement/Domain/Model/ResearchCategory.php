<?php
declare(strict_types=1);

namespace App\ResearchManagement\Domain\Model;


final class ResearchCategory
{
    public function __construct(
        private readonly string $uuid,
        private readonly string $name,
        private readonly string $slug,
    ) {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function slug(): string
    {
        return $this->slug;
    }
}