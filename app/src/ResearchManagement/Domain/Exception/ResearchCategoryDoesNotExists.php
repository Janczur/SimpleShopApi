<?php
declare(strict_types=1);

namespace App\ResearchManagement\Domain\Exception;

use App\Shared\Domain\DomainError;

class ResearchCategoryDoesNotExists extends DomainError
{
    public function errorCode(): string
    {
        return 'research_category_does_not_exists';
    }

    public function errorMessage(): string
    {
        return "Research category does not exists";
    }
}