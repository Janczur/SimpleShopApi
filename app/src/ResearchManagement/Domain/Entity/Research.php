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

    public function rename(ResearchUniquenessValidator $uniquenessValidator, Name $name): void
    {
        if ($name->equals($this->name)) {
            return;
        }
        $slug = Slug::fromName($name);
        if (!$uniquenessValidator->isUnique($slug, $this->categoryUuid?->toString())) {
            throw new ResearchExists($name);
        }

        // do some more logic, like public domain event

        $this->name = $name;
        $this->slug = $slug;
        $this->updatedAt = new DateTimeImmutable();
    }

    public function update(?Code $code, ?IcdCode $icdCode, ?string $shortDescription, ?string $description): void
    {
        if ($code && $code->equals($this->code)) {
            $code = null;
        }
        if ($icdCode && $icdCode->equals($this->icdCode)) {
            $icdCode = null;
        }
        if ($shortDescription && $shortDescription === $this->shortDescription) {
            $shortDescription = null;
        }
        if ($description && $description === $this->description) {
            $description = null;
        }
        if (!$code && !$icdCode && !$shortDescription && !$description) {
            return;
        }
        // do some more logic, like public domain event
        $this->code = $code ?? $this->code;
        $this->icdCode = $icdCode ?? $this->icdCode;
        $this->shortDescription = $shortDescription ?? $this->shortDescription;
        $this->description = $description ?? $this->description;
        $this->updatedAt = new DateTimeImmutable();
    }

    public function changeCategory(
        ResearchCategoryValidator $categoryValidator,
        ResearchUniquenessValidator $uniquenessValidator,
        ?UuidInterface $categoryUuid
    ): void
    {
        if ($categoryUuid && $categoryUuid->equals($this->categoryUuid)) {
            return;
        }
        if (!$categoryUuid && !$this->categoryUuid) {
            return;
        }
        if ($categoryUuid && !$categoryValidator->exists($categoryUuid->toString())) {
            throw new ResearchCategoryDoesNotExists();
        }
        if ($categoryUuid && !$uniquenessValidator->isUnique($this->slug, $categoryUuid->toString())) {
            throw new ResearchExists($this->name);
        }
        // do some more logic, like public domain event
        $this->categoryUuid = $categoryUuid;
        $this->updatedAt = new DateTimeImmutable();
    }
}