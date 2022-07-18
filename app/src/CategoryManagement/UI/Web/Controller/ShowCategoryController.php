<?php
declare(strict_types=1);

namespace App\CategoryManagement\UI\Web\Controller;

use App\CategoryManagement\Application\Query\FindByUuid\FindByUuid;
use App\Shared\Domain\System\SystemInterface;
use App\Shared\Infrastructure\Api\ApiController;
use App\Shared\Infrastructure\Api\ApiResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route(
    '/categories/{uuid}',
    name: 'categories.show',
    requirements: ['uuid' => '%routing.uuid%'],
    methods: ['GET']
)]
class ShowCategoryController extends ApiController
{
    public function __invoke(string $uuid, SystemInterface $system, SerializerInterface $serializer): ApiResponse
    {
        if (!$category = $system->query(new FindByUuid($uuid))) {
            return $this->createApiResponse(status: Response::HTTP_NOT_FOUND);
        }
        return $this->createApiResponse($category);
    }
}