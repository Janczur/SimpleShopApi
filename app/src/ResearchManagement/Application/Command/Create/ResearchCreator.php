<?php
declare(strict_types=1);

namespace App\ResearchManagement\Application\Command\Create;

use App\ResearchManagement\Domain\Entity\Research;
use App\ResearchManagement\Domain\Entity\Research\Code;
use App\ResearchManagement\Domain\Entity\Research\IcdCode;
use App\ResearchManagement\Domain\Entity\Research\Name;
use App\ResearchManagement\Domain\Repository\Researches;
use App\ResearchManagement\Domain\Service\ResearchCategoryValidator;
use App\ResearchManagement\Domain\Service\ResearchUniquenessValidator;

final class ResearchCreator
{
    public function __construct(
        private readonly ResearchCategoryValidator $researchCategoryValidator,
        private readonly ResearchUniquenessValidator $uniquenessValidator,
        private readonly Researches $researches
    ) {}

    public function __invoke(
        Name $name,
        Code $code,
        ?string $categoryUuid,
        ?IcdCode $icdCode,
        ?string $shortDescription,
        ?string $description
    ): void
    {
        $research = Research::create(
            $this->researchCategoryValidator,
            $this->uniquenessValidator,
            $name,
            $code,
            $categoryUuid,
            $icdCode,
            $shortDescription,
            $description
        );
        $this->researches->add($research);
    }

}