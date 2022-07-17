<?php

namespace App\Shared\Infrastructure\Api;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponse extends JsonResponse
{
    public function __construct($json = null, $status = 200, $headers = [])
    {
        $headers = array_merge(
            ['Content-Type' => 'application/vnd.api+json'],
            $headers
        );
        parent::__construct($json, $status, $headers, true);
    }

    public function getContent(): false|string
    {
        return parent::getContent();
    }
}