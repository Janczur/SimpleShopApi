<?php
declare(strict_types=1);

namespace App\ResearchManagement\Application\Command\Rename;

use App\ResearchManagement\Domain\Entity\Research\Name;
use App\ResearchManagement\Domain\Repository\Researches;
use App\ResearchManagement\Domain\Service\ResearchUniquenessValidator;
use Ramsey\Uuid\UuidInterface;
use RuntimeException;

final class ResearchRenamer
{
    public function __construct(
        private readonly ResearchUniquenessValidator $uniquenessValidator,
        private readonly Researches $researches
    ) {}

    public function __invoke(UuidInterface $uuid, Name $name): void
    {
        if (!$research = $this->researches->find($uuid)) {
            throw new RuntimeException('The given research does not exist');
        }
        $research->rename($this->uniquenessValidator, $name);
        $this->researches->add($research);
    }
}