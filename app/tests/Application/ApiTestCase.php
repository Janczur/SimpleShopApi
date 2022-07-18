<?php
declare(strict_types=1);

namespace App\Tests\Application;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

abstract class ApiTestCase extends WebTestCase
{
    protected KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    protected function makeGetRequest(string $endpoint, array $params = []): Response
    {
        $this->client->request('GET', $endpoint, $params);
        return $this->client->getResponse();
    }

    protected function makePostRequest(string $endpoint, array $data = []): Response
    {
        $this->client->request('POST', $endpoint, [], [], [], json_encode($data));
        return $this->client->getResponse();
    }

    protected function makePatchRequest(string $endpoint, string $uuid, array $data = []): Response
    {
        $this->client->request('PATCH', $endpoint . '/' . $uuid, [], [], [], json_encode($data));
        return $this->client->getResponse();
    }

    protected function makeDeleteRequest(string $endpoint, string $uuid): Response
    {
        $this->client->request('DELETE', $endpoint . '/' . $uuid);
        return $this->client->getResponse();
    }
}