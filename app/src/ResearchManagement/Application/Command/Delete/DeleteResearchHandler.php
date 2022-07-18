<?php
declare(strict_types=1);

namespace App\ResearchManagement\Application\Command\Delete;

use App\ResearchManagement\Domain\Repository\Researches;
use App\Shared\Domain\System\CQRS\CommandHandler;
use RuntimeException;

class DeleteResearchHandler implements CommandHandler
{
    public function __construct(
        private readonly Researches $researches
    ) {}

    public function __invoke(DeleteResearch $command): void
    {
        if (!$research = $this->researches->find($command->uuid())) {
            throw new RuntimeException('The given research does not exist');
        }
        $this->researches->remove($research);
    }

}