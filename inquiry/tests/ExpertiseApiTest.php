<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExpertiseApiTest extends TestCase
{
    use MakeExpertiseTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateExpertise()
    {
        $expertise = $this->fakeExpertiseData();
        $this->json('POST', '/api/v1/expertises', $expertise);

        $this->assertApiResponse($expertise);
    }

    /**
     * @test
     */
    public function testReadExpertise()
    {
        $expertise = $this->makeExpertise();
        $this->json('GET', '/api/v1/expertises/'.$expertise->id);

        $this->assertApiResponse($expertise->toArray());
    }

    /**
     * @test
     */
    public function testUpdateExpertise()
    {
        $expertise = $this->makeExpertise();
        $editedExpertise = $this->fakeExpertiseData();

        $this->json('PUT', '/api/v1/expertises/'.$expertise->id, $editedExpertise);

        $this->assertApiResponse($editedExpertise);
    }

    /**
     * @test
     */
    public function testDeleteExpertise()
    {
        $expertise = $this->makeExpertise();
        $this->json('DELETE', '/api/v1/expertises/'.$expertise->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/expertises/'.$expertise->id);

        $this->assertResponseStatus(404);
    }
}
