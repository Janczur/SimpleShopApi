<?php
declare(strict_types=1);

namespace App\ResearchManagement\Application\Query\FindByUuid;

use App\Shared\Domain\System\CQRS\Query;

final class FindByUuid implements Query

{
    public function __construct(
        private readonly string $uuid
    ) {}

    public function uuid(): string
    {
        return $this->uuid;
    }
}