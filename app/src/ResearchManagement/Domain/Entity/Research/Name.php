<?php
declare(strict_types=1);

namespace App\ResearchManagement\Domain\Entity\Research;

use InvalidArgumentException;

final class Name
{
    public const VALID_RESEARCH_NAME_REGEX = '/^[\p{L}0-9\-.,\s]+$/u';

    private function __construct(
        private readonly string $value
    ) {}

    public static function from(string $name): self
    {
        if (!preg_match(self::VALID_RESEARCH_NAME_REGEX, $name)) {
            throw new InvalidArgumentException(
                'Research name can only contain letters, numbers, spaces, dashes, commas and dots'
            );
        }
        if (strlen($name) > 100) {
            throw new InvalidArgumentException('Name is too long');
        }
        return new self($name);
    }

    public function toString(): string
    {
        return $this->value;
    }
}