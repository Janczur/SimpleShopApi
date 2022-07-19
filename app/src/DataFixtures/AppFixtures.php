<?php

namespace App\DataFixtures;

use App\CategoryManagement\Domain\Entity\Category;
use App\CategoryManagement\Domain\Service\CategoryUniquenessValidator;
use App\ResearchManagement\Domain\Entity\Research;
use App\ResearchManagement\Domain\Service\ResearchCategoryValidator;
use App\ResearchManagement\Domain\Service\ResearchUniquenessValidator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly CategoryUniquenessValidator $categoryUniquenessValidator,
        private readonly ResearchUniquenessValidator $researchUniquenessValidator,
        private readonly ResearchCategoryValidator $researchCategoryValidator
    ) {}

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i++) {
            $category = Category::create(
                $this->categoryUniquenessValidator,
                Category\Name::from('Category ' . $i)
            );
            $manager->persist($category);
            for ($j = 0; $j < 10; $j++) {
                $research = Research::create(
                    $this->researchCategoryValidator,
                    $this->researchUniquenessValidator,
                    Research\Name::from('Research ' . $i . '-' . $j),
                    Research\Code::from($j + 1),
                    $category->uuid()->toString(),
                    Research\IcdCode::from('A' . $i . $j),
                    'Short description ' . $i . '-' . $j,
                    'Description ' . $i . '-' . $j
                );
                $manager->persist($research);
            }
        }

        // researches without category
        for ($i = 0; $i < 5; $i++) {
            $research = Research::create(
                $this->researchCategoryValidator,
                $this->researchUniquenessValidator,
                Research\Name::from('Research ' . $i),
                Research\Code::from($i + 1),
                null,
                Research\IcdCode::from('A' . $i . $i),
                'Short description ' . $i,
                'Description ' . $i
            );
            $manager->persist($research);
        }
        $manager->flush();
    }
}
