<?php
declare(strict_types=1);

namespace App\CategoryManagement\Application\Command\Update;

use App\CategoryManagement\Application\DTO\UpdateCategoryDTO;
use App\Shared\Domain\System\CQRS\Command;

class UpdateCategory implements Command
{
    public function __construct(
        private readonly string $uuid,
        private readonly UpdateCategoryDTO $dto
    ) {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function name(): string
    {
        return $this->dto->name();
    }
}