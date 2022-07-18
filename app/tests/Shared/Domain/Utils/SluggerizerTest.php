<?php

namespace App\Tests\Shared\Domain\Utils;

use App\Shared\Domain\Utils\Sluggerizer;
use PHPUnit\Framework\TestCase;

class SluggerizerTest extends TestCase
{
    /** @test */
    public function itSluggerizesGivenStringCorrectly(): void
    {
        $value = 'IgE sp. rMal d 1, jabŁko';
        $slug = Sluggerizer::slugify($value);
        $this->assertEquals('ige-sp-rmal-d-1-jablko', $slug);
    }
}
