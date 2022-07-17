<?php
declare(strict_types=1);

namespace App\CategoryManagement\Application\Command\Delete;

use App\CategoryManagement\Domain\Repository\Categories;
use App\Shared\Domain\System\CQRS\CommandHandler;
use RuntimeException;

final class DeleteCategoryHandler implements CommandHandler
{

    public function __construct(
        private readonly Categories $categories
    ) {}

    public function __invoke(DeleteCategory $command): void
    {
        if (!$category = $this->categories->find($command->uuid())) {
            throw new RuntimeException('Given category not exist');
        }

        $this->categories->remove($category);
    }

}