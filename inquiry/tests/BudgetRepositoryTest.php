<?php

use App\Models\Budget;
use App\Repositories\Admin\BudgetRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BudgetRepositoryTest extends TestCase
{
    use MakeBudgetTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var BudgetRepository
     */
    protected $budgetRepo;

    public function setUp()
    {
        parent::setUp();
        $this->budgetRepo = App::make(BudgetRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateBudget()
    {
        $budget = $this->fakeBudgetData();
        $createdBudget = $this->budgetRepo->create($budget);
        $createdBudget = $createdBudget->toArray();
        $this->assertArrayHasKey('id', $createdBudget);
        $this->assertNotNull($createdBudget['id'], 'Created Budget must have id specified');
        $this->assertNotNull(Budget::find($createdBudget['id']), 'Budget with given id must be in DB');
        $this->assertModelData($budget, $createdBudget);
    }

    /**
     * @test read
     */
    public function testReadBudget()
    {
        $budget = $this->makeBudget();
        $dbBudget = $this->budgetRepo->find($budget->id);
        $dbBudget = $dbBudget->toArray();
        $this->assertModelData($budget->toArray(), $dbBudget);
    }

    /**
     * @test update
     */
    public function testUpdateBudget()
    {
        $budget = $this->makeBudget();
        $fakeBudget = $this->fakeBudgetData();
        $updatedBudget = $this->budgetRepo->update($fakeBudget, $budget->id);
        $this->assertModelData($fakeBudget, $updatedBudget->toArray());
        $dbBudget = $this->budgetRepo->find($budget->id);
        $this->assertModelData($fakeBudget, $dbBudget->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteBudget()
    {
        $budget = $this->makeBudget();
        $resp = $this->budgetRepo->delete($budget->id);
        $this->assertTrue($resp);
        $this->assertNull(Budget::find($budget->id), 'Budget should not exist in DB');
    }
}
