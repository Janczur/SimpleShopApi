<?php
declare(strict_types=1);

namespace App\ResearchManagement\UI\Web\Controller;

use App\ResearchManagement\Application\Command\Rename\RenameResearch;
use App\ResearchManagement\Application\DTO\RenameResearchDTO;
use App\ResearchManagement\Application\Query\FindByUuid\FindByUuid;
use App\ResearchManagement\Application\Query\Model\SingleResearchView;
use App\Shared\Domain\System\SystemInterface;
use App\Shared\Infrastructure\Api\ApiController;
use App\Shared\Infrastructure\Api\ApiResponse;
use App\Shared\Infrastructure\Mapper\RequestObjectMapper;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    '/researches/rename/{uuid}',
    name: 'researches.rename',
    requirements: ['uuid' => '%routing.uuid%'],
    methods: ['PATCH']
)]
final class RenameResearchController extends ApiController
{
    public function __invoke(string $uuid, RequestObjectMapper $requestObjectMapper, SystemInterface $system): ApiResponse
    {
        /** @var SingleResearchView $category */
        if (!$category = $system->query(new FindByUuid($uuid))) {
            return $this->createApiResponse(status: Response::HTTP_NOT_FOUND);
        }
        /** @var RenameResearchDTO $dto */
        $dto = $requestObjectMapper->map(RenameResearchDTO::class);
        $system->dispatch(new RenameResearch($category->uuid, $dto));
        return $this->createApiResponse(status: Response::HTTP_NO_CONTENT);
    }
}