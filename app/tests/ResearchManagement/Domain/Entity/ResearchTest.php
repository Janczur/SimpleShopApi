<?php

namespace App\Tests\ResearchManagement\Domain\Entity;

use App\ResearchManagement\Domain\Entity\Research;
use App\ResearchManagement\Domain\Entity\Research\Code;
use App\ResearchManagement\Domain\Entity\Research\IcdCode;
use App\ResearchManagement\Domain\Entity\Research\Name;
use App\ResearchManagement\Domain\Exception\ResearchCategoryDoesNotExists;
use App\ResearchManagement\Domain\Repository\Researches;
use App\ResearchManagement\Domain\Service\ResearchCategoryValidator;
use App\ResearchManagement\Domain\Service\ResearchUniquenessValidator;
use App\ResearchManagement\Infrastructure\Doctrine\ORM\DoctrineORMResearches;
use App\ResearchManagement\Infrastructure\InMemory\InMemoryResearches;
use App\Tests\Factory\Category\CategoryFactory;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class ResearchTest extends KernelTestCase
{
    private Researches $researches;
    private ResearchUniquenessValidator $uniquenessValidator;
    private ResearchCategoryValidator $categoryValidator;

    /** @test */
    public function canCreateResearchWithoutCategory(): void
    {
        // Arrange
        $name = 'Research';
        $code = 1234;
        $categoryUuid = null;
        $icdCode = 'A01';
        $shortDescription = 'Short description';
        $description = 'Description';

        // Act
        $research = $this->createResearch($name, $code, $categoryUuid, $icdCode, $shortDescription, $description);

        // Assert
        $this->assertSame($name, $research->name()->toString());
        $this->assertSame('research', $research->slug()->toString());
        $this->assertSame($code, $research->code()->toInt());
        $this->assertSame($icdCode, $research->icdCode()->toString());
        $this->assertSame($shortDescription, $research->shortDescription());
        $this->assertSame($description, $research->description());
        $this->assertNull($research->categoryUuid());
    }

    private function createResearch(
        string $name = 'Research',
        int $code = 1234,
        ?string $categoryUuid = null,
        ?string $icdCode = 'A01',
        ?string $shortDescription = 'Short description',
        ?string $description = 'Description'
    ): Research
    {
        return Research::create(
            $this->categoryValidator,
            $this->uniquenessValidator,
            Name::from($name),
            Code::from($code),
            $categoryUuid,
            $icdCode ? IcdCode::from($icdCode) : null,
            $shortDescription,
            $description
        );
    }

    /** @test */
    public function canCreateResearchWithCategory(): void
    {
        // Arrange
        CategoryFactory::createOne([
            'uuid' => $uuid = Uuid::uuid4(),
        ]);
        $categoryUuid = $uuid->toString();

        // Act
        $research = $this->createResearch(categoryUuid: $categoryUuid);

        // Assert
        $this->assertSame($categoryUuid, $research->categoryUuid()->toString());
    }

    /** @test */
    public function cannotCreateResearchWithNotExistingCategory(): void
    {
        // Arrange
        $categoryUuid = Uuid::uuid4()->toString();

        // Assert
        $this->expectException(ResearchCategoryDoesNotExists::class);

        // Act
        $this->createResearch(categoryUuid: $categoryUuid);
    }

    /** @test */
    public function canCreateCategoryOnlyWithNameAndCode(): void
    {
        // Arrange
        $name = 'Research';
        $code = 123;

        // Act
        $research = $this->createResearch($name, $code, null, null, null, null);

        // Assert
        $this->assertSame($name, $research->name()->toString());
        $this->assertSame('research', $research->slug()->toString());
        $this->assertSame($code, $research->code()->toInt());
    }

    public function setUp(): void
    {
        $entityManager = self::bootKernel()->getContainer()->get('doctrine')->getManager();
        $this->researches = new DoctrineORMResearches($entityManager);
        $this->uniquenessValidator = new ResearchUniquenessValidator($this->researches);
        $this->categoryValidator = new ResearchCategoryValidator($this->researches);
    }
}
