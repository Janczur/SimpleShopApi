<?php
declare(strict_types=1);

namespace App\CategoryManagement\Domain\Exception;

use App\CategoryManagement\Domain\Entity\Category\Name;
use App\Shared\Domain\DomainError;

class CategoryExists extends DomainError
{
    public function __construct(private readonly Name $name)
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'category_exists';
    }

    public function errorMessage(): string
    {
        return sprintf('Category with name %s already exists', $this->name->asString());
    }
}