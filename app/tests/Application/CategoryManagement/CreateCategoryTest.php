<?php
declare(strict_types=1);

namespace App\Tests\Application\CategoryManagement;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CreateCategoryTest extends WebTestCase
{

    /** @test */
    public function categoryCanBeCreated(): void
    {
        $response = $this->makePostRequestWithData(['name' => 'Test']);

        $this->assertEquals(201, $response->getStatusCode());
    }

    private function makePostRequestWithData(array $data): Response
    {
        $client = static::createClient();
        $client->request('POST', '/categories', [], [], [], json_encode($data));
        return $client->getResponse();
    }

    /** @test */
    public function cannotCreateCategoryWithInvalidName(): void
    {
        $response = $this->makePostRequestWithData(['name' => 'Inv@!id name...']);

        $this->assertEquals(422, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            '{"errors":{"name":["Category name can only contain letters, numbers, spaces, dashes and underscores"]},"status":422,"type":"validation_failed","title":"Validation failed"}',
            $response->getContent()
        );
    }

}