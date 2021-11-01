<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateProjectTypeAPIRequest;
use App\Http\Requests\Api\UpdateProjectTypeAPIRequest;
use App\Models\ProjectType;
use App\Repositories\Admin\ProjectTypeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Http\Response;

/**
 * Class ProjectTypeController
 * @package App\Http\Controllers\Api
 */

class ProjectTypeAPIController extends AppBaseController
{
    /** @var  ProjectTypeRepository */
    private $projectTypeRepository;

    public function __construct(ProjectTypeRepository $projectTypeRepo)
    {
        $this->projectTypeRepository = $projectTypeRepo;
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @return Response
     *
     * @SWG\Get(
     *      path="/project-types",
     *      summary="Get a listing of the ProjectTypes.",
     *      tags={"ProjectType"},
     *      description="Get all ProjectTypes",
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
     *                  @SWG\Items(ref="#/definitions/ProjectType")
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
        $this->projectTypeRepository->pushCriteria(new RequestCriteria($request));
        $this->projectTypeRepository->pushCriteria(new LimitOffsetCriteria($request));
        $projectTypes = $this->projectTypeRepository->all();

        return $this->sendResponse($projectTypes->toArray(), 'Project Types retrieved successfully');
    }

    /**
     * @param CreateProjectTypeAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/project-types",
     *      summary="Store a newly created ProjectType in storage",
     *      tags={"ProjectType"},
     *      description="Store ProjectType",
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
     *          description="ProjectType that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ProjectType")
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
     *                  ref="#/definitions/ProjectType"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateProjectTypeAPIRequest $request)
    {
        $projectTypes = $this->projectTypeRepository->saveRecord($request);

        return $this->sendResponse($projectTypes->toArray(), 'Project Type saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/project-types/{id}",
     *      summary="Display the specified ProjectType",
     *      tags={"ProjectType"},
     *      description="Get ProjectType",
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
     *          description="id of ProjectType",
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
     *                  ref="#/definitions/ProjectType"
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
        /** @var ProjectType $projectType */
        $projectType = $this->projectTypeRepository->findWithoutFail($id);

        if (empty($projectType)) {
            return $this->sendError('Project Type not found');
        }

        return $this->sendResponse($projectType->toArray(), 'Project Type retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateProjectTypeAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/project-types/{id}",
     *      summary="Update the specified ProjectType in storage",
     *      tags={"ProjectType"},
     *      description="Update ProjectType",
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
     *          description="id of ProjectType",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ProjectType that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ProjectType")
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
     *                  ref="#/definitions/ProjectType"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateProjectTypeAPIRequest $request)
    {
        /** @var ProjectType $projectType */
        $projectType = $this->projectTypeRepository->findWithoutFail($id);

        if (empty($projectType)) {
            return $this->sendError('Project Type not found');
        }

        $projectType = $this->projectTypeRepository->updateRecord($request, $id);

        return $this->sendResponse($projectType->toArray(), 'ProjectType updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/project-types/{id}",
     *      summary="Remove the specified ProjectType from storage",
     *      tags={"ProjectType"},
     *      description="Delete ProjectType",
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
     *          description="id of ProjectType",
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
        /** @var ProjectType $projectType */
        $projectType = $this->projectTypeRepository->findWithoutFail($id);

        if (empty($projectType)) {
            return $this->sendError('Project Type not found');
        }

        $this->projectTypeRepository->deleteRecord($id);

        return $this->sendResponse($id, 'Project Type deleted successfully');
    }
}
