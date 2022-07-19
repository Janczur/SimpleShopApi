<?php
declare(strict_types=1);

namespace App\ResearchManagement\UI\Web\Controller;

use App\ResearchManagement\Application\Command\Create\CreateResearch;
use App\ResearchManagement\Domain\Repository\Researches;
use App\Shared\Domain\System\SystemInterface;
use App\Shared\Infrastructure\Api\ApiController;
use App\Shared\Infrastructure\Api\ApiResponse;
use App\Shared\Infrastructure\Mapper\RequestObjectMapper;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    '/researches',
    name: 'researches.create',
    methods: ['POST']
)]
final class CreateResearchController extends ApiController
{
    public function __invoke(RequestObjectMapper $requestObjectMapper, SystemInterface $system, Researches $researches): ApiResponse
    {
        /** @var CreateResearch $command */
        $command = $requestObjectMapper->map(CreateResearch::class);
        $system->dispatch($command);

        return $this->createApiResponse(status: Response::HTTP_CREATED);
    }
}