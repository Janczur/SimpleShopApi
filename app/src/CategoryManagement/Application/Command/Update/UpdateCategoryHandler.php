<?php
declare(strict_types=1);

namespace App\CategoryManagement\Application\Command\Update;

use App\CategoryManagement\Domain\Entity\Category\Name;
use App\Shared\Domain\System\CQRS\CommandHandler;
use Ramsey\Uuid\Uuid;

class UpdateCategoryHandler implements CommandHandler
{
    public function __construct(
        private readonly CategoryUpdater $updater
    ) {}

    public function __invoke(UpdateCategory $command): void
    {
        $uuid = Uuid::fromString($command->uuid());
        $name = Name::from($command->name());

        $this->updater->__invoke($uuid, $name);
    }

}