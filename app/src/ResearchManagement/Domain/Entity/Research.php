<?php
declare(strict_types=1);

namespace App\ResearchManagement\Domain\Entity;

use App\ResearchManagement\Domain\Entity\Research\Code;
use App\ResearchManagement\Domain\Entity\Research\IcdCode;
use App\ResearchManagement\Domain\Entity\Research\Name;
use App\ResearchManagement\Domain\Entity\Research\Slug;
use App\ResearchManagement\Domain\Exception\ResearchCategoryDoesNotExists;
use App\ResearchManagement\Domain\Exception\ResearchExists;
use App\ResearchManagement\Domain\Service\ResearchCategoryValidator;
use App\ResearchManagement\Domain\Service\ResearchUniquenessValidator;
use App\Shared\Domain\Aggregate\AggregateRoot;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Research extends AggregateRoot
{
    public function __construct(
        private readonly UuidInterface $uuid,
        private Name $name,
        private Slug $slug,
        private Code $code,
        private ?UuidInterface $categoryUuid,
        private ?IcdCode $icdCode,
        private ?string $shortDescription,
        private ?string $description,
        private DateTimeImmutable $createdAt = new DateTimeImmutable(),
        private DateTimeImmutable $updatedAt = new DateTimeImmutable(),
    ) {}

    public static function create(
        ResearchCategoryValidator $categoryValidator,
        ResearchUniquenessValidator $uniquenessChecker,
        Name $name,
        Code $code,
        ?string $categoryUuid = null,
        ?IcdCode $icdCode = null,
        ?string $shortDescription = null,
        ?string $description = null,
    ): self
    {
        if ($categoryUuid && !$categoryValidator->exists($categoryUuid)) {
            throw new ResearchCategoryDoesNotExists($categoryUuid);
        }

        $slug = Slug::fromName($name);
        if (!$uniquenessChecker->isUnique($slug, $categoryUuid)) {
            throw new ResearchExists($name);
        }

        return new self(
            Uuid::uuid4(),
            $name,
            $slug,
            $code,
            $categoryUuid ? Uuid::fromString($categoryUuid) : null,
            $icdCode,
            $shortDescription,
            $description,
        );
    }

    public function uuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function slug(): Slug
    {
        return $this->slug;
    }

    public function code(): Code
    {
        return $this->code;
    }

    public function categoryUuid(): ?UuidInterface
    {
        return $this->categoryUuid;
    }

    public function icdCode(): ?IcdCode
    {
        return $this->icdCode;
    }

    public function shortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}