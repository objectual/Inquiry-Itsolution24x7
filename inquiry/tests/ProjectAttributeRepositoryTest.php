<?php

use App\Models\ProjectAttribute;
use App\Repositories\Admin\ProjectAttributeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProjectAttributeRepositoryTest extends TestCase
{
    use MakeProjectAttributeTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ProjectAttributeRepository
     */
    protected $projectAttributeRepo;

    public function setUp()
    {
        parent::setUp();
        $this->projectAttributeRepo = App::make(ProjectAttributeRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateProjectAttribute()
    {
        $projectAttribute = $this->fakeProjectAttributeData();
        $createdProjectAttribute = $this->projectAttributeRepo->create($projectAttribute);
        $createdProjectAttribute = $createdProjectAttribute->toArray();
        $this->assertArrayHasKey('id', $createdProjectAttribute);
        $this->assertNotNull($createdProjectAttribute['id'], 'Created ProjectAttribute must have id specified');
        $this->assertNotNull(ProjectAttribute::find($createdProjectAttribute['id']), 'ProjectAttribute with given id must be in DB');
        $this->assertModelData($projectAttribute, $createdProjectAttribute);
    }

    /**
     * @test read
     */
    public function testReadProjectAttribute()
    {
        $projectAttribute = $this->makeProjectAttribute();
        $dbProjectAttribute = $this->projectAttributeRepo->find($projectAttribute->id);
        $dbProjectAttribute = $dbProjectAttribute->toArray();
        $this->assertModelData($projectAttribute->toArray(), $dbProjectAttribute);
    }

    /**
     * @test update
     */
    public function testUpdateProjectAttribute()
    {
        $projectAttribute = $this->makeProjectAttribute();
        $fakeProjectAttribute = $this->fakeProjectAttributeData();
        $updatedProjectAttribute = $this->projectAttributeRepo->update($fakeProjectAttribute, $projectAttribute->id);
        $this->assertModelData($fakeProjectAttribute, $updatedProjectAttribute->toArray());
        $dbProjectAttribute = $this->projectAttributeRepo->find($projectAttribute->id);
        $this->assertModelData($fakeProjectAttribute, $dbProjectAttribute->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteProjectAttribute()
    {
        $projectAttribute = $this->makeProjectAttribute();
        $resp = $this->projectAttributeRepo->delete($projectAttribute->id);
        $this->assertTrue($resp);
        $this->assertNull(ProjectAttribute::find($projectAttribute->id), 'ProjectAttribute should not exist in DB');
    }
}
