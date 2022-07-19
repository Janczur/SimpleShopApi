<?php

namespace App\Tests\CategoryManagement\Domain\Entity\Category;

use App\CategoryManagement\Domain\Entity\Category\Name;
use App\CategoryManagement\Domain\Entity\Category\Slug;
use PHPUnit\Framework\TestCase;
use TypeError;

final class SlugTest extends TestCase
{
    /** @test */
    public function itCanOnlyBeCreatedFromTheCategoryName(): void
    {
        $this->expectException(TypeError::class);
        Slug::fromName('slug');
    }

    /** @test */
    public function canCreateSlugFromTheCategoryName(): void
    {
        $name = Name::from('Test');
        $slug = Slug::fromName($name);
        $this->assertEquals('test', $slug->toString());
    }
}
