<?php
declare(strict_types=1);

namespace App\ResearchManagement\UI\Web\Controller;

use App\ResearchManagement\Application\Command\Delete\DeleteResearch;
use App\ResearchManagement\Application\Query\FindByUuid\FindByUuid;
use App\ResearchManagement\Application\Query\Model\SingleResearchView;
use App\Shared\Domain\System\SystemInterface;
use App\Shared\Infrastructure\Api\ApiController;
use App\Shared\Infrastructure\Api\ApiResponse;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    '/researches/{uuid}',
    name: 'researches.delete',
    requirements: ['uuid' => '%routing.uuid%'],
    methods: ['DELETE']
)]
final class DeleteResearchController extends ApiController
{
    public function __invoke(string $uuid, SystemInterface $system): ApiResponse
    {
        /** @var SingleResearchView $research */
        if (!$research = $system->query(new FindByUuid($uuid))) {
            return $this->createApiResponse(status: Response::HTTP_NOT_FOUND);
        }
        $command = new DeleteResearch(Uuid::fromString($research->uuid));
        $system->dispatch($command);
        return $this->createApiResponse(status: Response::HTTP_NO_CONTENT);
    }
}