<?php
declare(strict_types=1);

namespace App\ResearchManagement\Application\Command\Rename;

use App\ResearchManagement\Domain\Entity\Research\Name;
use App\Shared\Domain\System\CQRS\CommandHandler;
use Ramsey\Uuid\Uuid;

final class RenameResearchHandler implements CommandHandler
{
    public function __construct(
        private readonly ResearchRenamer $researchRenamer
    ) {}

    public function __invoke(RenameResearch $command): void
    {
        $uuid = Uuid::fromString($command->uuid());
        $newName = Name::from($command->newName());

        $this->researchRenamer->__invoke($uuid, $newName);
    }
}