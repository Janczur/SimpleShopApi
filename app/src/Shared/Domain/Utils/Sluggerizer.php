<?php
declare(strict_types=1);

namespace App\Shared\Domain\Utils;

final class Sluggerizer
{
    public static function slugify(string $value): string
    {
        $lowered = mb_strtolower($value);
        $withoutPolishChars = str_replace(
            ['ą', 'ć', 'ę', 'ł', 'ń', 'ó', 'ś', 'ź', 'ż'],
            ['a', 'c', 'e', 'l', 'n', 'o', 's', 'z', 'z'],
            $lowered
        );
        return preg_replace('/[^a-z0-9]+/', '-', $withoutPolishChars);
    }
}