<?php

namespace App\ResearchManagement\Domain\Entity\Research;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CodeTest extends TestCase
{
    /** @test */
    public function canCreateCodeFromInteger(): void
    {
        $this->assertEquals('123', Code::from(123)->toString());
        $this->assertEquals('1', Code::from(1)->toString());
        $this->assertEquals('9999', Code::from(9999)->toString());
        $this->assertEquals('123', Code::from((int)'123')->toString());
    }

    /** @test */
    public function shouldProjectCodeToInteger(): void
    {
        $this->assertEquals(12, Code::from(12)->toInt());
        $this->assertEquals(1, Code::from(1)->toInt());
        $this->assertEquals(9999, Code::from(9999)->toInt());
    }

    /** @test */
    public function cannotCreateCodeFromNegativeInteger(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Code::from(-2);
    }

    /** @test */
    public function cannotCreateCodeFromNonNumericValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Code::from((int)'a123');
    }
}
