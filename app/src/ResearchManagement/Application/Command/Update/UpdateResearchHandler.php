<?php
declare(strict_types=1);

namespace App\ResearchManagement\Application\Command\Update;

use App\ResearchManagement\Domain\Entity\Research\Code;
use App\ResearchManagement\Domain\Entity\Research\IcdCode;
use App\Shared\Domain\System\CQRS\CommandHandler;
use Ramsey\Uuid\Uuid;

final class UpdateResearchHandler implements CommandHandler
{
    public function __construct(
        private readonly ResearchUpdater $researchUpdater
    ) {}

    public function __invoke(UpdateResearch $command): void
    {
        $uuid = Uuid::fromString($command->uuid());
        $newCode = $command->code() ? Code::from($command->code()) : null;
        $newIcdCode = $command->icdCode() ? IcdCode::from($command->icdCode()) : null;
        $newShortDescription = $command->shortDescription() ?: null;
        $newDescription = $command->description() ?: null;

        $this->researchUpdater->__invoke($uuid, $newCode, $newIcdCode, $newShortDescription, $newDescription);
    }
}