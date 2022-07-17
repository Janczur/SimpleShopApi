<?php

namespace App\Tests\CategoryManagement\Domain\Entity\Category;

use App\CategoryManagement\Domain\Entity\Category\Name;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    /** @test */
    public function itCanBeCreatedFromAString(): void
    {
        $name = Name::fromString('Test');
        $this->assertEquals('Test', $name->asString());
    }

    /** @test */
    public function itCanBeCreatedWithLettersNumbersSpacesDashesAndUnderScores(): void
    {
        $name = Name::fromString('Test 123_foo-456_');
        $this->assertEquals('Test 123_foo-456_', $name->asString());
    }

    /** @test */
    public function itCannotBeCreatedFromSpecialCharacters(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Name::fromString('Test $100%');
    }

    /** @test */
    public function itCannotBeCreatedWithMoreThan100Characters(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Name::fromString(str_repeat('a', 101));
    }

    /** @test */
    public function itCannotBeCreatedFromEmptyString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $name = Name::fromString('');
    }
}
