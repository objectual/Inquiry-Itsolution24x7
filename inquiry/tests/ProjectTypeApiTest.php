<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProjectTypeApiTest extends TestCase
{
    use MakeProjectTypeTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateProjectType()
    {
        $projectType = $this->fakeProjectTypeData();
        $this->json('POST', '/api/v1/projectTypes', $projectType);

        $this->assertApiResponse($projectType);
    }

    /**
     * @test
     */
    public function testReadProjectType()
    {
        $projectType = $this->makeProjectType();
        $this->json('GET', '/api/v1/projectTypes/'.$projectType->id);

        $this->assertApiResponse($projectType->toArray());
    }

    /**
     * @test
     */
    public function testUpdateProjectType()
    {
        $projectType = $this->makeProjectType();
        $editedProjectType = $this->fakeProjectTypeData();

        $this->json('PUT', '/api/v1/projectTypes/'.$projectType->id, $editedProjectType);

        $this->assertApiResponse($editedProjectType);
    }

    /**
     * @test
     */
    public function testDeleteProjectType()
    {
        $projectType = $this->makeProjectType();
        $this->json('DELETE', '/api/v1/projectTypes/'.$projectType->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/projectTypes/'.$projectType->id);

        $this->assertResponseStatus(404);
    }
}
