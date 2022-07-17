<?php

namespace App\Shared\Infrastructure\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;

abstract class ApiController extends AbstractController
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    protected function createApiResponse(array|string|null $data = null, int $status = 200, array $headers = []): ApiResponse
    {
        $json = $this->serializer->serialize($data, 'json');

        return new ApiResponse($json, $status, $headers);
    }
}