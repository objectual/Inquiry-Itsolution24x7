<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateProjectAPIRequest;
use App\Http\Requests\Api\UpdateProjectAPIRequest;
use App\Models\Attachment;
use App\Models\Description;
use App\Models\Project;
use App\Repositories\Admin\ProjectRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Storage;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Http\Response;

/**
 * Class ProjectController
 * @package App\Http\Controllers\Api
 */
class ProjectAPIController extends AppBaseController
{
    /** @var  ProjectRepository */
    private $projectRepository;

    public function __construct(ProjectRepository $projectRepo)
    {
        $this->projectRepository = $projectRepo;
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @return Response
     *
     * @SWG\Get(
     *      path="/projects",
     *      summary="Get a listing of the Projects.",
     *      tags={"Project"},
     *      description="Get all Projects",
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
     *                  @SWG\Items(ref="#/definitions/Project")
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
        $this->projectRepository->pushCriteria(new RequestCriteria($request));
        $this->projectRepository->pushCriteria(new LimitOffsetCriteria($request));
        $projects = $this->projectRepository->all();

        return $this->sendResponse($projects->toArray(), 'Projects retrieved successfully');
    }

    /**
     * @param CreateProjectAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/projects",
     *      summary="Store a newly created Project in storage",
     *      tags={"Project"},
     *      description="Store Project",
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
     *          description="Project that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Project")
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
     *                  ref="#/definitions/Project"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateProjectAPIRequest $request)
    {
        if (isset($request->project_id)) {
            $projects = $this->projectRepository->updateApiRecord($request, $request->project_id);
            $input = [];
            $input['project_id'] = $projects->id;
            $input['details'] = $request->description;
            Description::where('project_id', $request->project_id)->update($input);
        } else {
            $projects = $this->projectRepository->saveRecord($request);
            $input = [];
            $input['project_id'] = $projects->id;
            $input['details'] = $request->description;
            Description::create($input);
        }

        if ($request->has('attachment')) {
            $attachment = Attachment::where('instance_id', $projects->id)->get();
            if ($attachment) {
                foreach ($attachment as $atc)
                    Attachment::where('id', $atc->id)->delete();
            }
            $files = $request->file('attachment');
            $files = is_array($files) ? $files : [$files];
            foreach ($files as $file) {
                $input['instance_id'] = $projects->id;
                $input['instance_type'] = 'app-description';
                $input['attachment'] = Storage::putFile('app-description', $file);

                Attachment::create($input);
            }

        }
        return $this->sendResponse($projects->toArray(), 'Project saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/projects/{id}",
     *      summary="Display the specified Project",
     *      tags={"Project"},
     *      description="Get Project",
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
     *          description="id of Project",
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
     *                  ref="#/definitions/Project"
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
        /** @var Project $project */
        $project = $this->projectRepository->findWithoutFail($id);

        if (empty($project)) {
            return $this->sendError('Project not found');
        }

        return $this->sendResponse($project->toArray(), 'Project retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateProjectAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/projects/{id}",
     *      summary="Update the specified Project in storage",
     *      tags={"Project"},
     *      description="Update Project",
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
     *          description="id of Project",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Project that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Project")
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
     *                  ref="#/definitions/Project"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateProjectAPIRequest $request)
    {
        /** @var Project $project */
        $project = $this->projectRepository->findWithoutFail($id);

        if (empty($project)) {
            return $this->sendError('Project not found');
        }

        $project = $this->projectRepository->updateRecord($request, $id);

        return $this->sendResponse($project->toArray(), 'Project updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/projects/{id}",
     *      summary="Remove the specified Project from storage",
     *      tags={"Project"},
     *      description="Delete Project",
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
     *          description="id of Project",
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
        /** @var Project $project */
        $project = $this->projectRepository->findWithoutFail($id);

        if (empty($project)) {
            return $this->sendError('Project not found');
        }

        $this->projectRepository->deleteRecord($id);

        return $this->sendResponse($id, 'Project deleted successfully');
    }

    public function review($id)
    {
        if ($id) {
            $valid = $this->projectRepository->verifyProject($id);
            $email = $this->projectRepository->verifyUser($id);
            if ($valid == 0) {
                return $this->sendError($id, 'Project Not Verified');
            }
        } else {
            return $this->sendError($id, 'Project Not Exist');
        }
        $project_id = $id;
        $project = Project::where('id', $project_id)->first();

        return $this->sendResponse($project->toArray(), 'Project Review');
        if (isset($project->project_type->project_attributes->content)) {
            $attributes = json_decode($project->project_type->project_attributes->content);
        } else {
            $attributes = null;
        }
        //dd($project->project_type->project_attributes->content);
        if (isset($project->project_type->type)) {
            if ($project->project_type->type == 1) {
                $describe = $this->projectTypeRepository->projecttype($attributes);
            } elseif ($project->project_type->type == 2) {
                $describe = $this->projectTypeRepository->projectwork($attributes);
            } else {
                $describe = '';
            }
        } else {
            $describe = null;
        }
//        if ($attributes != null) {
//            $api = $this->projectTypeRepository->api($attributes);
//
//            if ($request->stage !== 2) {
//                $stage = $this->projectTypeRepository->stage($attributes);
//            } else {
//                $stage = '';
//            }
//        } else {
//            $api = null;
//            $stage = null;
//        }
        $exist = Project::where('id', $request->project_id)->first();
        if (isset($project->budget->budget_attributes->content)) {
            $budget = json_decode($project->budget->budget_attributes->content);
        } else {
            $budget = null;
        }
        $name = \Request::route()->getName();
        if (isset($email)) {
            $url = url('title', ['email', $email]);
        }


    }

}
