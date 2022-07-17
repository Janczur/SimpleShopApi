<?php
declare(strict_types=1);

namespace App\Tests\DummyData;

use Symfony\Component\Validator\Constraints as Assert;

class DummyDTO
{
    public function __construct(
        #[Assert\Uuid]
        private readonly string $uuid,

        #[Assert\Length(
            min: 3,
            max: 30,
        )]
        private readonly string $name,
    ) {}

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }
}