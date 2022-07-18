<?php

namespace CategoryManagement\Domain\Entity\Category;

use App\CategoryManagement\Domain\Entity\Category\Name;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    /** @test */
    public function canCreateNameFromAString(): void
    {
        $name = Name::from('Test');
        $this->assertEquals('Test', $name->toString());
    }

    /** @test */
    public function canCreateNameWithPolishCharacters(): void
    {
        $name = Name::from('AaĄąBbCcĆćDdEeĘęFfGgHhIiJjKkLlŁłMmNnŃńOoÓóPpRrSsŚśTtUuWwYyZzŹźŻż');
        $this->assertEquals('AaĄąBbCcĆćDdEeĘęFfGgHhIiJjKkLlŁłMmNnŃńOoÓóPpRrSsŚśTtUuWwYyZzŹźŻż', $name->toString());
    }

    /** @test */
    public function canCreateNameWithLettersNumbersSpacesDashesAndUnderScores(): void
    {
        $name = Name::from('Test 123_foo-456_');
        $this->assertEquals('Test 123_foo-456_', $name->toString());
    }

    /** @test */
    public function canCreateNameFromSpecialCharacters(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Name::from('Test $100%');
    }

    /** @test */
    public function canCreateNameWithMoreThan100Characters(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Name::from(str_repeat('a', 101));
    }

    /** @test */
    public function canCreateNameFromEmptyString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Name::from('');
    }
}
