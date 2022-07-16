<?php
declare(strict_types=1);

namespace App\CategoryManagement\UI\Web\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categories', name: 'category.create', methods: ['POST'])]
class CreateCategoryController
{
    public function __invoke($name = 'World'): Response
    {
        return new Response(sprintf('Hello %s!', $name));
    }
}