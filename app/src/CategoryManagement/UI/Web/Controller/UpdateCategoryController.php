<?php
declare(strict_types=1);

namespace App\CategoryManagement\UI\Web\Controller;

use App\CategoryManagement\Application\Command\Update\UpdateCategory;
use App\CategoryManagement\Application\DTO\UpdateCategoryDTO;
use App\CategoryManagement\Application\Query\FindByUuid\FindByUuid;
use App\CategoryManagement\Application\Query\Model\CategoryView;
use App\Shared\Domain\System\SystemInterface;
use App\Shared\Infrastructure\Api\ApiController;
use App\Shared\Infrastructure\Api\ApiResponse;
use App\Shared\Infrastructure\Mapper\RequestObjectMapper;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    '/categories/{uuid}',
    name: 'category.update',
    requirements: ['uuid' => '%routing.uuid%'],
    methods: ['PATCH']
)]
class UpdateCategoryController extends ApiController
{
    public function __invoke(string $uuid, RequestObjectMapper $requestObjectMapper, SystemInterface $system): ApiResponse
    {
        /** @var CategoryView $category */
        if (!$category = $system->query(new FindByUuid($uuid))) {
            return $this->createApiResponse(status: Response::HTTP_NOT_FOUND);
        }
        /** @var UpdateCategoryDTO $dto */
        $dto = $requestObjectMapper->map(UpdateCategoryDTO::class);
        $system->dispatch(new UpdateCategory($category->uuid, $dto));
        return $this->createApiResponse(status: Response::HTTP_NO_CONTENT);
    }
}