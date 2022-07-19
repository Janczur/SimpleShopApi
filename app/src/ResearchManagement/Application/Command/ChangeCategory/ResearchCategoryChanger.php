<?php
declare(strict_types=1);

namespace App\ResearchManagement\Application\Command\ChangeCategory;

use App\ResearchManagement\Domain\Repository\Researches;
use App\ResearchManagement\Domain\Service\ResearchCategoryValidator;
use App\ResearchManagement\Domain\Service\ResearchUniquenessValidator;
use Ramsey\Uuid\UuidInterface;
use RuntimeException;

final class ResearchCategoryChanger
{
    public function __construct(
        private readonly ResearchCategoryValidator $categoryValidator,
        private readonly ResearchUniquenessValidator $uniquenessValidator,
        private readonly Researches $researches
    ) {}


    public function __invoke(UuidInterface $uuid, ?UuidInterface $categoryUuid): void
    {
        if (!$research = $this->researches->find($uuid)) {
            throw new RuntimeException('The given research does not exist');
        }
        $research->changeCategory($this->categoryValidator, $this->uniquenessValidator, $categoryUuid);
        $this->researches->add($research);
    }

}