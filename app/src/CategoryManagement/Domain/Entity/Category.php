<?php
declare(strict_types=1);

namespace App\CategoryManagement\Domain\Entity;

use App\CategoryManagement\Domain\Entity\Category\Name;
use Symfony\Component\Uid\Uuid;

class Category
{
    public function __construct(
        private Uuid $uuid,
        private Name $name
    ) {}
}