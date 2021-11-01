<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BudgetApiTest extends TestCase
{
    use MakeBudgetTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateBudget()
    {
        $budget = $this->fakeBudgetData();
        $this->json('POST', '/api/v1/budgets', $budget);

        $this->assertApiResponse($budget);
    }

    /**
     * @test
     */
    public function testReadBudget()
    {
        $budget = $this->makeBudget();
        $this->json('GET', '/api/v1/budgets/'.$budget->id);

        $this->assertApiResponse($budget->toArray());
    }

    /**
     * @test
     */
    public function testUpdateBudget()
    {
        $budget = $this->makeBudget();
        $editedBudget = $this->fakeBudgetData();

        $this->json('PUT', '/api/v1/budgets/'.$budget->id, $editedBudget);

        $this->assertApiResponse($editedBudget);
    }

    /**
     * @test
     */
    public function testDeleteBudget()
    {
        $budget = $this->makeBudget();
        $this->json('DELETE', '/api/v1/budgets/'.$budget->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/budgets/'.$budget->id);

        $this->assertResponseStatus(404);
    }
}
