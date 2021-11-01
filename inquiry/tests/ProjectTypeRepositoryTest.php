<?php

use App\Models\ProjectType;
use App\Repositories\Admin\ProjectTypeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProjectTypeRepositoryTest extends TestCase
{
    use MakeProjectTypeTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ProjectTypeRepository
     */
    protected $projectTypeRepo;

    public function setUp()
    {
        parent::setUp();
        $this->projectTypeRepo = App::make(ProjectTypeRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateProjectType()
    {
        $projectType = $this->fakeProjectTypeData();
        $createdProjectType = $this->projectTypeRepo->create($projectType);
        $createdProjectType = $createdProjectType->toArray();
        $this->assertArrayHasKey('id', $createdProjectType);
        $this->assertNotNull($createdProjectType['id'], 'Created ProjectType must have id specified');
        $this->assertNotNull(ProjectType::find($createdProjectType['id']), 'ProjectType with given id must be in DB');
        $this->assertModelData($projectType, $createdProjectType);
    }

    /**
     * @test read
     */
    public function testReadProjectType()
    {
        $projectType = $this->makeProjectType();
        $dbProjectType = $this->projectTypeRepo->find($projectType->id);
        $dbProjectType = $dbProjectType->toArray();
        $this->assertModelData($projectType->toArray(), $dbProjectType);
    }

    /**
     * @test update
     */
    public function testUpdateProjectType()
    {
        $projectType = $this->makeProjectType();
        $fakeProjectType = $this->fakeProjectTypeData();
        $updatedProjectType = $this->projectTypeRepo->update($fakeProjectType, $projectType->id);
        $this->assertModelData($fakeProjectType, $updatedProjectType->toArray());
        $dbProjectType = $this->projectTypeRepo->find($projectType->id);
        $this->assertModelData($fakeProjectType, $dbProjectType->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteProjectType()
    {
        $projectType = $this->makeProjectType();
        $resp = $this->projectTypeRepo->delete($projectType->id);
        $this->assertTrue($resp);
        $this->assertNull(ProjectType::find($projectType->id), 'ProjectType should not exist in DB');
    }
}
