<?php
declare(strict_types=1);

namespace App\ResearchManagement\UI\Web\Controller;

use App\ResearchManagement\Application\Query\FindBySlug\FindBySlug;
use App\Shared\Domain\System\SystemInterface;
use App\Shared\Infrastructure\Api\ApiController;
use App\Shared\Infrastructure\Api\ApiResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    '/researches/{slug}',
    name: 'researches.show',
    methods: ['GET']
)]
final class ShowResearchController extends ApiController
{
    public function __invoke(string $slug, SystemInterface $system): ApiResponse
    {
        if (!$research = $system->query(new FindBySlug($slug))) {
            return $this->createApiResponse(status: Response::HTTP_NOT_FOUND);
        }
        return $this->createApiResponse($research);
    }
}