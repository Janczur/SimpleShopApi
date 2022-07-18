<?php

namespace App\ResearchManagement\Domain\Entity\Research;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    /** @test */
    public function itCanBeCreatedFromAString(): void
    {
        $name = Name::from('Test');
        $this->assertEquals('Test', $name->toString());
    }

    /** @test */
    public function itCanBeCreatedWithLettersNumbersSpacesDashesCommasDotsAndPolishCharacters(): void
    {
        $name = Name::from('IgE sp. rMal d 1, jabłko');
        $this->assertEquals('IgE sp. rMal d 1, jabłko', $name->toString());
    }

    /** @test */
    public function itCannotBeCreatedFromSpecialCharacters(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Name::from('Test $100%');
    }

    /** @test */
    public function itCannotBeCreatedWithMoreThan100Characters(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Name::from(str_repeat('a', 101));
    }

    /** @test */
    public function itCannotBeCreatedFromEmptyString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Name::from('');
    }
}
