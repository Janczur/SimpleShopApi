<?php
declare(strict_types=1);

namespace App\ResearchManagement\UI\Web\Controller;

use App\ResearchManagement\Application\Query\FindByUuid\FindByUuid;
use App\Shared\Domain\System\SystemInterface;
use App\Shared\Infrastructure\Api\ApiController;
use App\Shared\Infrastructure\Api\ApiResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    '/researches/{uuid}',
    name: 'researches.show',
    requirements: ['uuid' => '%routing.uuid%'],
    methods: ['GET']
)]
class ShowResearchController extends ApiController
{
    public function __invoke(string $uuid, SystemInterface $system): ApiResponse
    {
        if (!$research = $system->query(new FindByUuid($uuid))) {
            return $this->createApiResponse(status: Response::HTTP_NOT_FOUND);
        }
        return $this->createApiResponse($research);
    }
}