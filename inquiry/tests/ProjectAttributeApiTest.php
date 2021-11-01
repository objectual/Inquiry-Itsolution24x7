<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProjectAttributeApiTest extends TestCase
{
    use MakeProjectAttributeTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateProjectAttribute()
    {
        $projectAttribute = $this->fakeProjectAttributeData();
        $this->json('POST', '/api/v1/projectAttributes', $projectAttribute);

        $this->assertApiResponse($projectAttribute);
    }

    /**
     * @test
     */
    public function testReadProjectAttribute()
    {
        $projectAttribute = $this->makeProjectAttribute();
        $this->json('GET', '/api/v1/projectAttributes/'.$projectAttribute->id);

        $this->assertApiResponse($projectAttribute->toArray());
    }

    /**
     * @test
     */
    public function testUpdateProjectAttribute()
    {
        $projectAttribute = $this->makeProjectAttribute();
        $editedProjectAttribute = $this->fakeProjectAttributeData();

        $this->json('PUT', '/api/v1/projectAttributes/'.$projectAttribute->id, $editedProjectAttribute);

        $this->assertApiResponse($editedProjectAttribute);
    }

    /**
     * @test
     */
    public function testDeleteProjectAttribute()
    {
        $projectAttribute = $this->makeProjectAttribute();
        $this->json('DELETE', '/api/v1/projectAttributes/'.$projectAttribute->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/projectAttributes/'.$projectAttribute->id);

        $this->assertResponseStatus(404);
    }
}
