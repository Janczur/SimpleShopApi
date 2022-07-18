<?php

namespace App\Tests\Factory\Research;

use App\ResearchManagement\Domain\Entity\Research;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Research>
 *
 * @method static Research|Proxy createOne(array $attributes = [])
 * @method static Research[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Research|Proxy find(object|array|mixed $criteria)
 * @method static Research|Proxy findOrCreate(array $attributes)
 * @method static Research|Proxy first(string $sortedField = 'id')
 * @method static Research|Proxy last(string $sortedField = 'id')
 * @method static Research|Proxy random(array $attributes = [])
 * @method static Research|Proxy randomOrCreate(array $attributes = [])
 * @method static Research[]|Proxy[] all()
 * @method static Research[]|Proxy[] findBy(array $attributes)
 * @method static Research[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Research[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method Research|Proxy create(array|callable $attributes = [])
 */
final class ResearchFactory extends ModelFactory
{

    protected static function getClass(): string
    {
        return Research::class;
    }

    protected function getDefaults(): array
    {
        return [
            'uuid' => Uuid::uuid4(),
            'name' => $name = Research\Name::from(self::faker()->word),
            'slug' => Research\Slug::fromName($name),
            'code' => Research\Code::from(self::faker()->numerify('####')),
            'icdCode' => Research\IcdCode::from(self::faker()->bothify('?##')),
            'categoryUuid' => null,
            'shortDescription' => self::faker()->text,
            'description' => self::faker()->text,
            'createdAt' => DateTimeImmutable::createFromMutable(self::faker()->datetime()),
            'updatedAt' => DateTimeImmutable::createFromMutable(self::faker()->datetime()),
        ];
    }
}
