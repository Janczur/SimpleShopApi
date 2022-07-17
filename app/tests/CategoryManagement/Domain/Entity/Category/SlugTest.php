<?php

namespace App\Tests\CategoryManagement\Domain\Entity\Category;

use App\CategoryManagement\Domain\Entity\Category\Name;
use App\CategoryManagement\Domain\Entity\Category\Slug;
use PHPUnit\Framework\TestCase;
use TypeError;

class SlugTest extends TestCase
{
    /** @test */
    public function itCanOnlyBeCreatedFromTheCategoryName(): void
    {
        $this->expectException(TypeError::class);
        Slug::fromName('slug');
    }

    /** @test */
    public function itCanBeCreatedFromTheCategoryName(): void
    {
        $name = Name::fromString('Test');
        $slug = Slug::fromName($name);
        $this->assertEquals('test', $slug->asString());
    }

    /** @test */
    public function valueIsSluggerizedCorrectly(): void
    {
        $name = Name::fromString('Test');
        $slug = Slug::fromName($name);
        $this->assertEquals('test', $slug->asString());

        $name = Name::fromString('Test    space slug_with_underscores');
        $slug = Slug::fromName($name);
        $this->assertEquals('test-space-slug-with-underscores', $slug->asString());
    }
}
