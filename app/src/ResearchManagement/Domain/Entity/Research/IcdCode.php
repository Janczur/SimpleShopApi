<?php
declare(strict_types=1);

namespace App\ResearchManagement\Domain\Entity\Research;

use InvalidArgumentException;

final class IcdCode
{
    // I followed this document https://stat.gov.pl/Klasyfikacje/doc/icd10/pdf/ICD10TomI.pdf
    public const VALID_ICD_CODE_REGEX = '/^[a-zA-Z]{1}[0-9]{2}(\.[0-9]{1,3})?$/';

    private function __construct(
        private readonly string $value
    ) {}

    public static function from(string $code): self
    {
        if (strlen($code) < 3) {
            throw new InvalidArgumentException('ICD code must be at least 3 characters long');
        }
        if (strlen($code) > 7) {
            throw new InvalidArgumentException('ICD code must be at most 7 characters long');
        }
        if (!preg_match(self::VALID_ICD_CODE_REGEX, $code)) {
            throw new InvalidArgumentException('Invalid ICD code');
        }
        return new self($code);
    }

    public function equals(?IcdCode $icdCode): bool
    {
        if ($icdCode === null) {
            return false;
        }
        return $this->value === $icdCode->value;
    }

    public function toString(): string
    {
        return $this->value;
    }
}