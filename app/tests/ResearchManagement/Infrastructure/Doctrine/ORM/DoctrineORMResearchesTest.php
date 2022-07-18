<?php

namespace App\Tests\ResearchManagement\Infrastructure\Doctrine\ORM;

use App\ResearchManagement\Domain\Entity\Research;
use App\ResearchManagement\Domain\Entity\Research\Name;
use App\ResearchManagement\Domain\Entity\Research\Slug;
use App\ResearchManagement\Domain\Model\ResearchCategory;
use App\ResearchManagement\Domain\Repository\Researches;
use App\ResearchManagement\Infrastructure\Doctrine\ORM\DoctrineORMResearches;
use App\Tests\Factory\Category\CategoryFactory;
use App\Tests\Factory\Research\ResearchFactory;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DoctrineORMResearchesTest extends KernelTestCase
{

    private readonly Researches $researches;
    private readonly EntityManagerInterface $entityManager;

    /** @test */
    public function itCorrectlyAddsResearch(): void
    {
        // Arrange
        $research = ResearchFactory::new()->withoutPersisting()->create()->object();

        // Act
        $this->researches->add($research);
        $existing = $this->researches->find($research->uuid());

        // Assert
        self::assertSame($research->uuid()->toString(), $existing->uuid()->toString());
        self::assertSame($research->name()->toString(), $existing->name()->toString());
        self::assertSame($research->slug()->toString(), $existing->slug()->toString());
    }

    /** @test */
    public function itCorrectlyFindsResearchCategory(): void
    {
        // Arrange
        CategoryFactory::createOne([
            'uuid' => $categoryUuid = Uuid::uuid4(),
        ]);

        // Act
        $researchCategory = $this->researches->findCategory($categoryUuid->toString());

        // Assert
        self::assertInstanceOf(ResearchCategory::class, $researchCategory);
        self::assertSame($categoryUuid->toString(), $researchCategory->uuid());
    }

    /** @test */
    public function itCorrectlyFindsResearchBySlugAndCategoryUuid(): void
    {
        // Arrange
        ResearchFactory::createOne([
            'uuid' => $uuid = Uuid::uuid4(),
            'name' => $name = Name::from('Test Research'),
            'slug' => $slug = Slug::fromName($name),
            'categoryUuid' => $categoryUuid = Uuid::uuid4(),
        ]);

        // Act
        $research = $this->researches->findBySlugAndCategoryUuid($slug, $categoryUuid->toString());

        // Assert
        self::assertInstanceOf(Research::class, $research);
        self::assertSame($uuid->toString(), $research->uuid()->toString());
        self::assertSame($name->toString(), $research->name()->toString());
        self::assertSame($slug->toString(), $research->slug()->toString());
    }

    /** @test */
    public function itCorrectlyRemovesResearch(): void
    {
        // Arrange
        $research = ResearchFactory::new()->withoutPersisting()->create([
            'uuid' => $uuid = Uuid::uuid4(),
        ])->object();
        $this->researches->add($research);

        // Pre-Assert
        self::assertNotNull($this->researches->find($uuid));

        // Act
        $this->researches->remove($research);

        // Assert
        self::assertNull($this->researches->find($uuid));
    }

    protected function setUp(): void
    {
        $this->entityManager = self::bootKernel()->getContainer()->get('doctrine')->getManager();
        $this->researches = new DoctrineORMResearches($this->entityManager);
    }
}
