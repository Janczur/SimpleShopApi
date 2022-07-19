<?php
declare(strict_types=1);

namespace App\ResearchManagement\UI\Web\Controller;

use App\ResearchManagement\Application\Query\FindByCategorySlug\FindByCategorySlug;
use App\Shared\Domain\System\SystemInterface;
use App\Shared\Infrastructure\Api\ApiController;
use App\Shared\Infrastructure\Api\ApiResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    '/researches/category/{slug}',
    name: 'researches.category.index',
    methods: ['GET']
)]
final class ListResearchesFromCategoryController extends ApiController
{
    public function __invoke(string $slug, SystemInterface $system): ApiResponse
    {
        $researches = $system->query(new FindByCategorySlug($slug));
        if (empty($researches)) {
            return $this->createApiResponse(status: Response::HTTP_NO_CONTENT);
        }
        return $this->createApiResponse($researches);
    }

}