<?php
declare(strict_types=1);

namespace App\ResearchManagement\Domain\Exception;

use App\ResearchManagement\Domain\Entity\Research\Name;
use App\Shared\Domain\DomainError;

class ResearchExists extends DomainError
{
    public function __construct(
        private readonly Name $name,
    )
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'research_exists';
    }

    public function errorMessage(): string
    {
        return sprintf("Research with name '%s' already exists in current category", $this->name->toString());
    }
}