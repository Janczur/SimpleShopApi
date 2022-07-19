<?php

namespace App\ResearchManagement\Domain\Entity\Research;

use PHPUnit\Framework\TestCase;

final class SlugTest extends TestCase
{
    /** @test */
    public function canCreateSlugFromTheTestName(): void
    {
        $name = Name::from('Badanie krwi');
        $slug = Slug::fromName($name);
        $this->assertEquals('badanie-krwi', $slug->toString());
    }
}
