<?php
declare(strict_types=1);

namespace App\CategoryManagement\Application\Command\Create;

use App\CategoryManagement\Domain\Entity\Category\Name;
use App\CategoryManagement\Domain\Entity\Category\Slug;
use App\Shared\Domain\System\CQRS\CommandHandler;

final class CreateCategoryHandler implements CommandHandler
{
    public function __construct(
        private readonly CategoryCreator $creator
    ) {}

    public function __invoke(CreateCategory $command): void
    {
        $name = Name::fromString($command->name());
        $slug = Slug::fromName($name);

        $this->creator->__invoke($name, $slug);
    }
}