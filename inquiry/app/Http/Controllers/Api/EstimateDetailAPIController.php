<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateEstimateDetailAPIRequest;
use App\Http\Requests\Api\UpdateEstimateDetailAPIRequest;
use App\Models\EstimateDetail;
use App\Repositories\Admin\EstimateDetailRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Http\Response;

/**
 * Class EstimateDetailController
 * @package App\Http\Controllers\Api
 */

class EstimateDetailAPIController extends AppBaseController
{
    /** @var  EstimateDetailRepository */
    private $estimateDetailRepository;

    public function __construct(EstimateDetailRepository $estimateDetailRepo)
    {
        $this->estimateDetailRepository = $estimateDetailRepo;
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @return Response
     *
     * @SWG\Get(
     *      path="/estimate-details",
     *      summary="Get a listing of the EstimateDetails.",
     *      tags={"EstimateDetail"},
     *      description="Get all EstimateDetails",
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
     *                  @SWG\Items(ref="#/definitions/EstimateDetail")
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
        $this->estimateDetailRepository->pushCriteria(new RequestCriteria($request));
        $this->estimateDetailRepository->pushCriteria(new LimitOffsetCriteria($request));
        $estimateDetails = $this->estimateDetailRepository->all();

        return $this->sendResponse($estimateDetails->toArray(), 'Estimate Details retrieved successfully');
    }

    /**
     * @param CreateEstimateDetailAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/estimate-details",
     *      summary="Store a newly created EstimateDetail in storage",
     *      tags={"EstimateDetail"},
     *      description="Store EstimateDetail",
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
     *          description="EstimateDetail that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/EstimateDetail")
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
     *                  ref="#/definitions/EstimateDetail"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateEstimateDetailAPIRequest $request)
    {
        $estimateDetails = $this->estimateDetailRepository->saveRecord($request);

        return $this->sendResponse($estimateDetails->toArray(), 'Estimate Detail saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/estimate-details/{id}",
     *      summary="Display the specified EstimateDetail",
     *      tags={"EstimateDetail"},
     *      description="Get EstimateDetail",
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
     *          description="id of EstimateDetail",
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
     *                  ref="#/definitions/EstimateDetail"
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
        /** @var EstimateDetail $estimateDetail */
        $estimateDetail = $this->estimateDetailRepository->findWithoutFail($id);

        if (empty($estimateDetail)) {
            return $this->sendError('Estimate Detail not found');
        }

        return $this->sendResponse($estimateDetail->toArray(), 'Estimate Detail retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateEstimateDetailAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/estimate-details/{id}",
     *      summary="Update the specified EstimateDetail in storage",
     *      tags={"EstimateDetail"},
     *      description="Update EstimateDetail",
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
     *          description="id of EstimateDetail",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="EstimateDetail that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/EstimateDetail")
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
     *                  ref="#/definitions/EstimateDetail"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateEstimateDetailAPIRequest $request)
    {
        /** @var EstimateDetail $estimateDetail */
        $estimateDetail = $this->estimateDetailRepository->findWithoutFail($id);

        if (empty($estimateDetail)) {
            return $this->sendError('Estimate Detail not found');
        }

        $estimateDetail = $this->estimateDetailRepository->updateRecord($request, $id);

        return $this->sendResponse($estimateDetail->toArray(), 'EstimateDetail updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/estimate-details/{id}",
     *      summary="Remove the specified EstimateDetail from storage",
     *      tags={"EstimateDetail"},
     *      description="Delete EstimateDetail",
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
     *          description="id of EstimateDetail",
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
        /** @var EstimateDetail $estimateDetail */
        $estimateDetail = $this->estimateDetailRepository->findWithoutFail($id);

        if (empty($estimateDetail)) {
            return $this->sendError('Estimate Detail not found');
        }

        $this->estimateDetailRepository->deleteRecord($id);

        return $this->sendResponse($id, 'Estimate Detail deleted successfully');
    }
}
