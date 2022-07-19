<?php
declare(strict_types=1);

namespace App\ResearchManagement\Application\Command\ChangeCategory;

use App\Shared\Domain\System\CQRS\CommandHandler;
use Ramsey\Uuid\Uuid;

final class ChangeResearchCategoryHandler implements CommandHandler
{
    public function __construct(
        private readonly ResearchCategoryChanger $categoryChanger
    ) {}

    public function __invoke(ChangeResearchCategory $command): void
    {
        $categoryUuid = $command->dto()->categoryUuid();
        $uuid = Uuid::fromString($command->uuid());
        $categoryUuid = $categoryUuid ? Uuid::fromString($categoryUuid) : null;

        $this->categoryChanger->__invoke($uuid, $categoryUuid);
    }
}