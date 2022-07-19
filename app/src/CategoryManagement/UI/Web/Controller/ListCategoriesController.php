<?php
declare(strict_types=1);

namespace App\CategoryManagement\UI\Web\Controller;

use App\CategoryManagement\Application\Query\FindAll\FindAll;
use App\Shared\Domain\System\SystemInterface;
use App\Shared\Infrastructure\Api\ApiController;
use App\Shared\Infrastructure\Api\ApiResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    '/categories',
    name: 'categories.index',
    methods: ['GET']
)]
final class ListCategoriesController extends ApiController
{
    public function __invoke(SystemInterface $system): ApiResponse
    {
        $categories = $system->query(new FindAll());
        if (empty($categories)) {
            return $this->createApiResponse(status: Response::HTTP_NO_CONTENT);
        }
        return $this->createApiResponse($categories);
    }
}