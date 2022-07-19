<?php
declare(strict_types=1);

namespace App\CategoryManagement\UI\Web\Controller;

use App\CategoryManagement\Application\Command\Create\CreateCategory;
use App\CategoryManagement\Domain\Service\CategoryUniquenessValidator;
use App\Shared\Domain\System\SystemInterface;
use App\Shared\Infrastructure\Api\ApiController;
use App\Shared\Infrastructure\Mapper\RequestObjectMapper;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categories', name: 'categories.create', methods: ['POST'])]
final class CreateCategoryController extends ApiController
{
    public function __invoke(RequestObjectMapper $requestObjectMapper, SystemInterface $system, CategoryUniquenessValidator $checker): Response
    {
        /** @var CreateCategory $command */
        $command = $requestObjectMapper->map(CreateCategory::class);
        $system->dispatch($command);

        return $this->createApiResponse(status: Response::HTTP_CREATED);
    }
}