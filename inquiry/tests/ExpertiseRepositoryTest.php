<?php

use App\Models\Expertise;
use App\Repositories\Admin\ExpertiseRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExpertiseRepositoryTest extends TestCase
{
    use MakeExpertiseTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ExpertiseRepository
     */
    protected $expertiseRepo;

    public function setUp()
    {
        parent::setUp();
        $this->expertiseRepo = App::make(ExpertiseRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateExpertise()
    {
        $expertise = $this->fakeExpertiseData();
        $createdExpertise = $this->expertiseRepo->create($expertise);
        $createdExpertise = $createdExpertise->toArray();
        $this->assertArrayHasKey('id', $createdExpertise);
        $this->assertNotNull($createdExpertise['id'], 'Created Expertise must have id specified');
        $this->assertNotNull(Expertise::find($createdExpertise['id']), 'Expertise with given id must be in DB');
        $this->assertModelData($expertise, $createdExpertise);
    }

    /**
     * @test read
     */
    public function testReadExpertise()
    {
        $expertise = $this->makeExpertise();
        $dbExpertise = $this->expertiseRepo->find($expertise->id);
        $dbExpertise = $dbExpertise->toArray();
        $this->assertModelData($expertise->toArray(), $dbExpertise);
    }

    /**
     * @test update
     */
    public function testUpdateExpertise()
    {
        $expertise = $this->makeExpertise();
        $fakeExpertise = $this->fakeExpertiseData();
        $updatedExpertise = $this->expertiseRepo->update($fakeExpertise, $expertise->id);
        $this->assertModelData($fakeExpertise, $updatedExpertise->toArray());
        $dbExpertise = $this->expertiseRepo->find($expertise->id);
        $this->assertModelData($fakeExpertise, $dbExpertise->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteExpertise()
    {
        $expertise = $this->makeExpertise();
        $resp = $this->expertiseRepo->delete($expertise->id);
        $this->assertTrue($resp);
        $this->assertNull(Expertise::find($expertise->id), 'Expertise should not exist in DB');
    }
}
