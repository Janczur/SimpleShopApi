<?php
declare(strict_types=1);

namespace App\ResearchManagement\Application\Command\Create;

use App\Shared\Domain\System\CQRS\Command;

class CreateResearch implements Command
{
    public function __construct(
        private readonly string $name,
        private readonly int $code,
        private readonly ?string $categoryUuid,
        private readonly ?string $icdCode,
        private readonly ?string $shortDescription,
        private readonly ?string $description,
    ) {}

    public function name(): string
    {
        return $this->name;
    }

    public function code(): int
    {
        return $this->code;
    }

    public function categoryUuid(): ?string
    {
        return $this->categoryUuid;
    }

    public function icdCode(): ?string
    {
        return $this->icdCode;
    }

    public function shortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function description(): ?string
    {
        return $this->description;
    }


}