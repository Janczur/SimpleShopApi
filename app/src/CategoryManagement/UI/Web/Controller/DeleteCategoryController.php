<?php
declare(strict_types=1);

namespace App\CategoryManagement\UI\Web\Controller;

use App\CategoryManagement\Application\Command\Delete\DeleteCategory;
use App\CategoryManagement\Application\Query\FindByUuid\FindByUuid;
use App\Shared\Domain\System\SystemInterface;
use App\Shared\Infrastructure\Api\ApiController;
use App\Shared\Infrastructure\Api\ApiResponse;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    '/categories/{uuid}',
    name: 'categories.delete',
    requirements: ['uuid' => '%routing.uuid%'],
    methods: ['DELETE']
)]
class DeleteCategoryController extends ApiController
{
    public function __invoke(string $uuid, SystemInterface $system): ApiResponse
    {
        if (!$category = $system->query(new FindByUuid($uuid))) {
            return $this->createApiResponse(status: Response::HTTP_NOT_FOUND);
        }
        $command = new DeleteCategory(Uuid::fromString($category->uuid));
        $system->dispatch($command);
        return $this->createApiResponse(status: Response::HTTP_NO_CONTENT);
    }
}