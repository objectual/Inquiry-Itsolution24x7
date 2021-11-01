<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateBudgetAPIRequest;
use App\Http\Requests\Api\UpdateBudgetAPIRequest;
use App\Models\Budget;
use App\Repositories\Admin\BudgetRepository;
use App\Repositories\Admin\ProjectAttributeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Http\Response;

/**
 * Class BudgetController
 * @package App\Http\Controllers\Api
 */
class BudgetAPIController extends AppBaseController
{
    /** @var  BudgetRepository */
    private $budgetRepository;
    private $projectAttribute;

    public function __construct(BudgetRepository $budgetRepo, ProjectAttributeRepository $projectAttributeRepo)
    {
        $this->budgetRepository = $budgetRepo;
        $this->projectAttribute = $projectAttributeRepo;
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @return Response
     *
     * @SWG\Get(
     *      path="/budgets",
     *      summary="Get a listing of the Budgets.",
     *      tags={"Budget"},
     *      description="Get all Budgets",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      @SWG\Parameter(
     *          name="limit",
     *          description="Change the Default Record Count. If not found, Returns All Records in DB.",
     *          type="integer",
     *          required=false,
     *          in="query"
     *      ),
     *     @SWG\Parameter(
     *          name="offset",
     *          description="Change the Default Offset of the Query. If not found, 0 will be used.",
     *          type="integer",
     *          required=false,
     *          in="query"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Budget")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $this->budgetRepository->pushCriteria(new RequestCriteria($request));
        $this->budgetRepository->pushCriteria(new LimitOffsetCriteria($request));
        $budgets = $this->budgetRepository->all();

        return $this->sendResponse($budgets->toArray(), 'Budgets retrieved successfully');
    }

    /**
     * @param CreateBudgetAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/budgets",
     *      summary="Store a newly created Budget in storage",
     *      tags={"Budget"},
     *      description="Store Budget",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Budget that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Budget")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Budget"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */

    //        keys project_id,amount,experience,X
    public function store(Request $request)
    {
        $budgets = $this->budgetRepository->saveAPiRecord($request);
        $fullbudget = $this->projectAttribute->saveBudgetRecord($budgets->id, $request);
        return $this->sendResponse($fullbudget->toArray(), 'Budget saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/budgets/{id}",
     *      summary="Display the specified Budget",
     *      tags={"Budget"},
     *      description="Get Budget",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Budget",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Budget"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var Budget $budget */
        $budget = $this->budgetRepository->findWithoutFail($id);

        if (empty($budget)) {
            return $this->sendError('Budget not found');
        }

        return $this->sendResponse($budget->toArray(), 'Budget retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateBudgetAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/budgets/{id}",
     *      summary="Update the specified Budget in storage",
     *      tags={"Budget"},
     *      description="Update Budget",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Budget",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Budget that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Budget")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Budget"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateBudgetAPIRequest $request)
    {
        /** @var Budget $budget */
        $budget = $this->budgetRepository->findWithoutFail($id);

        if (empty($budget)) {
            return $this->sendError('Budget not found');
        }

        $budget = $this->budgetRepository->updateRecord($request, $id);

        return $this->sendResponse($budget->toArray(), 'Budget updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/budgets/{id}",
     *      summary="Remove the specified Budget from storage",
     *      tags={"Budget"},
     *      description="Delete Budget",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Budget",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var Budget $budget */
        $budget = $this->budgetRepository->findWithoutFail($id);

        if (empty($budget)) {
            return $this->sendError('Budget not found');
        }

        $this->budgetRepository->deleteRecord($id);

        return $this->sendResponse($id, 'Budget deleted successfully');
    }
}
