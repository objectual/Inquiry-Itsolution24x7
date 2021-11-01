<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DescriptionApiTest extends TestCase
{
    use MakeDescriptionTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateDescription()
    {
        $description = $this->fakeDescriptionData();
        $this->json('POST', '/api/v1/descriptions', $description);

        $this->assertApiResponse($description);
    }

    /**
     * @test
     */
    public function testReadDescription()
    {
        $description = $this->makeDescription();
        $this->json('GET', '/api/v1/descriptions/'.$description->id);

        $this->assertApiResponse($description->toArray());
    }

    /**
     * @test
     */
    public function testUpdateDescription()
    {
        $description = $this->makeDescription();
        $editedDescription = $this->fakeDescriptionData();

        $this->json('PUT', '/api/v1/descriptions/'.$description->id, $editedDescription);

        $this->assertApiResponse($editedDescription);
    }

    /**
     * @test
     */
    public function testDeleteDescription()
    {
        $description = $this->makeDescription();
        $this->json('DELETE', '/api/v1/descriptions/'.$description->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/descriptions/'.$description->id);

        $this->assertResponseStatus(404);
    }
}
