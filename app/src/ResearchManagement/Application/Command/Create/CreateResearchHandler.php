<?php
declare(strict_types=1);

namespace App\ResearchManagement\Application\Command\Create;

use App\ResearchManagement\Domain\Entity\Research\Code;
use App\ResearchManagement\Domain\Entity\Research\IcdCode;
use App\ResearchManagement\Domain\Entity\Research\Name;
use App\Shared\Domain\System\CQRS\CommandHandler;

class CreateResearchHandler implements CommandHandler
{
    public function __construct(
        private readonly ResearchCreator $researchCreator,
    ) {}

    public function __invoke(CreateResearch $command): void
    {
        $name = Name::from($command->name());
        $code = Code::from($command->code());
        $command->icdCode() ? $icdCode = IcdCode::from($command->icdCode()) : $icdCode = null;

        $this->researchCreator->__invoke(
            $name,
            $code,
            $command->categoryUuid(),
            $icdCode,
            $command->shortDescription(),
            $command->description()
        );
    }

}