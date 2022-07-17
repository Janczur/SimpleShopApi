<?php
declare(strict_types=1);

namespace App\CategoryManagement\UI\Web\Controller;

use App\Shared\Infrastructure\Api\ApiController;

class DeleteCategoryController extends ApiController
{
    public function __invoke(): Response
    {
        return $this->createApiResponse(status: Response::HTTP_NO_CONTENT);
    }
}