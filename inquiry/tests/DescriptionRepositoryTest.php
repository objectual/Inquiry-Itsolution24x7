<?php

use App\Models\Description;
use App\Repositories\Admin\DescriptionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DescriptionRepositoryTest extends TestCase
{
    use MakeDescriptionTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var DescriptionRepository
     */
    protected $descriptionRepo;

    public function setUp()
    {
        parent::setUp();
        $this->descriptionRepo = App::make(DescriptionRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateDescription()
    {
        $description = $this->fakeDescriptionData();
        $createdDescription = $this->descriptionRepo->create($description);
        $createdDescription = $createdDescription->toArray();
        $this->assertArrayHasKey('id', $createdDescription);
        $this->assertNotNull($createdDescription['id'], 'Created Description must have id specified');
        $this->assertNotNull(Description::find($createdDescription['id']), 'Description with given id must be in DB');
        $this->assertModelData($description, $createdDescription);
    }

    /**
     * @test read
     */
    public function testReadDescription()
    {
        $description = $this->makeDescription();
        $dbDescription = $this->descriptionRepo->find($description->id);
        $dbDescription = $dbDescription->toArray();
        $this->assertModelData($description->toArray(), $dbDescription);
    }

    /**
     * @test update
     */
    public function testUpdateDescription()
    {
        $description = $this->makeDescription();
        $fakeDescription = $this->fakeDescriptionData();
        $updatedDescription = $this->descriptionRepo->update($fakeDescription, $description->id);
        $this->assertModelData($fakeDescription, $updatedDescription->toArray());
        $dbDescription = $this->descriptionRepo->find($description->id);
        $this->assertModelData($fakeDescription, $dbDescription->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteDescription()
    {
        $description = $this->makeDescription();
        $resp = $this->descriptionRepo->delete($description->id);
        $this->assertTrue($resp);
        $this->assertNull(Description::find($description->id), 'Description should not exist in DB');
    }
}
