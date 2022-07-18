<?php
declare(strict_types=1);

namespace App\ResearchManagement\Application\Command\Update;

use App\ResearchManagement\Domain\Entity\Research\Code;
use App\ResearchManagement\Domain\Entity\Research\IcdCode;
use App\ResearchManagement\Domain\Repository\Researches;
use Ramsey\Uuid\UuidInterface;
use RuntimeException;

final class ResearchUpdater
{
    public function __construct(
        private readonly Researches $researches
    ) {}

    public function __invoke(
        UuidInterface $uuid,
        ?Code $code,
        ?IcdCode $icdCode,
        ?string $shortDescription,
        ?string $description
    ): void
    {
        if (!$research = $this->researches->find($uuid)) {
            throw new RuntimeException('The given research does not exist');
        }
        $research->update($code, $icdCode, $shortDescription, $description);
        $this->researches->add($research);
    }
}