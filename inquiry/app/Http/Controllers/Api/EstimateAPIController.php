<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateEstimateAPIRequest;
use App\Http\Requests\Api\UpdateEstimateAPIRequest;
use App\Models\Estimate;
use App\Repositories\Admin\EstimateRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Http\Response;

/**
 * Class EstimateController
 * @package App\Http\Controllers\Api
 */

class EstimateAPIController extends AppBaseController
{
    /** @var  EstimateRepository */
    private $estimateRepository;

    public function __construct(EstimateRepository $estimateRepo)
    {
        $this->estimateRepository = $estimateRepo;
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @return Response
     *
     * @SWG\Get(
     *      path="/estimates",
     *      summary="Get a listing of the Estimates.",
     *      tags={"Estimate"},
     *      description="Get all Estimates",
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
     *                  @SWG\Items(ref="#/definitions/Estimate")
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
        $this->estimateRepository->pushCriteria(new RequestCriteria($request));
        $this->estimateRepository->pushCriteria(new LimitOffsetCriteria($request));
        $estimates = $this->estimateRepository->all();

        return $this->sendResponse($estimates->toArray(), 'Estimates retrieved successfully');
    }

    /**
     * @param CreateEstimateAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/estimates",
     *      summary="Store a newly created Estimate in storage",
     *      tags={"Estimate"},
     *      description="Store Estimate",
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
     *          description="Estimate that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Estimate")
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
     *                  ref="#/definitions/Estimate"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateEstimateAPIRequest $request)
    {
        $estimates = $this->estimateRepository->saveRecord($request);

        return $this->sendResponse($estimates->toArray(), 'Estimate saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/estimates/{id}",
     *      summary="Display the specified Estimate",
     *      tags={"Estimate"},
     *      description="Get Estimate",
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
     *          description="id of Estimate",
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
     *                  ref="#/definitions/Estimate"
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
        /** @var Estimate $estimate */
        $estimate = $this->estimateRepository->findWithoutFail($id);

        if (empty($estimate)) {
            return $this->sendError('Estimate not found');
        }

        return $this->sendResponse($estimate->toArray(), 'Estimate retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateEstimateAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/estimates/{id}",
     *      summary="Update the specified Estimate in storage",
     *      tags={"Estimate"},
     *      description="Update Estimate",
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
     *          description="id of Estimate",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Estimate that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Estimate")
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
     *                  ref="#/definitions/Estimate"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateEstimateAPIRequest $request)
    {
        /** @var Estimate $estimate */
        $estimate = $this->estimateRepository->findWithoutFail($id);

        if (empty($estimate)) {
            return $this->sendError('Estimate not found');
        }

        $estimate = $this->estimateRepository->updateRecord($request, $id);

        return $this->sendResponse($estimate->toArray(), 'Estimate updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/estimates/{id}",
     *      summary="Remove the specified Estimate from storage",
     *      tags={"Estimate"},
     *      description="Delete Estimate",
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
     *          description="id of Estimate",
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
        /** @var Estimate $estimate */
        $estimate = $this->estimateRepository->findWithoutFail($id);

        if (empty($estimate)) {
            return $this->sendError('Estimate not found');
        }

        $this->estimateRepository->deleteRecord($id);

        return $this->sendResponse($id, 'Estimate deleted successfully');
    }
}
