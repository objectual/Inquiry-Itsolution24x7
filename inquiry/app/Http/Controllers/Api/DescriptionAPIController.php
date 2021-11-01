<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateDescriptionAPIRequest;
use App\Http\Requests\Api\UpdateDescriptionAPIRequest;
use App\Models\Description;
use App\Repositories\Admin\DescriptionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Http\Response;

/**
 * Class DescriptionController
 * @package App\Http\Controllers\Api
 */

class DescriptionAPIController extends AppBaseController
{
    /** @var  DescriptionRepository */
    private $descriptionRepository;

    public function __construct(DescriptionRepository $descriptionRepo)
    {
        $this->descriptionRepository = $descriptionRepo;
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @return Response
     *
     * @SWG\Get(
     *      path="/descriptions",
     *      summary="Get a listing of the Descriptions.",
     *      tags={"Description"},
     *      description="Get all Descriptions",
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
     *                  @SWG\Items(ref="#/definitions/Description")
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
        $this->descriptionRepository->pushCriteria(new RequestCriteria($request));
        $this->descriptionRepository->pushCriteria(new LimitOffsetCriteria($request));
        $descriptions = $this->descriptionRepository->all();

        return $this->sendResponse($descriptions->toArray(), 'Descriptions retrieved successfully');
    }

    /**
     * @param CreateDescriptionAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/descriptions",
     *      summary="Store a newly created Description in storage",
     *      tags={"Description"},
     *      description="Store Description",
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
     *          description="Description that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Description")
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
     *                  ref="#/definitions/Description"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateDescriptionAPIRequest $request)
    {
        $descriptions = $this->descriptionRepository->saveRecord($request);

        return $this->sendResponse($descriptions->toArray(), 'Description saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/descriptions/{id}",
     *      summary="Display the specified Description",
     *      tags={"Description"},
     *      description="Get Description",
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
     *          description="id of Description",
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
     *                  ref="#/definitions/Description"
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
        /** @var Description $description */
        $description = $this->descriptionRepository->findWithoutFail($id);

        if (empty($description)) {
            return $this->sendError('Description not found');
        }

        return $this->sendResponse($description->toArray(), 'Description retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateDescriptionAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/descriptions/{id}",
     *      summary="Update the specified Description in storage",
     *      tags={"Description"},
     *      description="Update Description",
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
     *          description="id of Description",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Description that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Description")
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
     *                  ref="#/definitions/Description"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateDescriptionAPIRequest $request)
    {
        /** @var Description $description */
        $description = $this->descriptionRepository->findWithoutFail($id);

        if (empty($description)) {
            return $this->sendError('Description not found');
        }

        $description = $this->descriptionRepository->updateRecord($request, $id);

        return $this->sendResponse($description->toArray(), 'Description updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/descriptions/{id}",
     *      summary="Remove the specified Description from storage",
     *      tags={"Description"},
     *      description="Delete Description",
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
     *          description="id of Description",
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
        /** @var Description $description */
        $description = $this->descriptionRepository->findWithoutFail($id);

        if (empty($description)) {
            return $this->sendError('Description not found');
        }

        $this->descriptionRepository->deleteRecord($id);

        return $this->sendResponse($id, 'Description deleted successfully');
    }
}
