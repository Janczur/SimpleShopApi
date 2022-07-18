<?php
declare(strict_types=1);

namespace App\ResearchManagement\Domain\Entity\Research;

use InvalidArgumentException;

final class Code
{
    private function __construct(
        private readonly int $value
    ) {}

    public static function from(int $code): self
    {
        if ($code <= 0) {
            throw new InvalidArgumentException('Code must be greater than 0');
        }
        if ($code > 9999) {
            throw new InvalidArgumentException('Code must be less than or equal to 9999');
        }
        return new self($code);
    }

    public function toString(): string
    {
        return (string)$this->value;
    }

    public function equals(Code $code)
    {
        return $this->value === $code->toInt();
    }

    public function toInt(): int
    {
        return $this->value;
    }
}