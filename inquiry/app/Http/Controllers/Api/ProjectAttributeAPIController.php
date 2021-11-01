<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateProjectAttributeAPIRequest;
use App\Http\Requests\Api\UpdateProjectAttributeAPIRequest;
use App\Models\Attachment;
use App\Models\ProjectAttribute;
use App\Models\ProjectType;
use App\Models\Question;
use App\Repositories\Admin\ProjectAttributeRepository;
use App\Repositories\Admin\ProjectTypeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Storage;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Http\Response;

/**
 * Class ProjectAttributeController
 * @package App\Http\Controllers\Api
 */
class ProjectAttributeAPIController extends AppBaseController
{
    /** @var  ProjectAttributeRepository */
    private $projectAttributeRepository;
    private $projectTypeRepository;

    public function __construct(ProjectAttributeRepository $projectAttributeRepo, ProjectTypeRepository $projectRepo)
    {
        $this->projectAttributeRepository = $projectAttributeRepo;
        $this->projectTypeRepository = $projectRepo;
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @return Response
     *
     * @SWG\Get(
     *      path="/project-attributes",
     *      summary="Get a listing of the ProjectAttributes.",
     *      tags={"ProjectAttribute"},
     *      description="Get all ProjectAttributes",
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
     *                  @SWG\Items(ref="#/definitions/ProjectAttribute")
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
        $this->projectAttributeRepository->pushCriteria(new RequestCriteria($request));
        $this->projectAttributeRepository->pushCriteria(new LimitOffsetCriteria($request));
        $projectAttributes = $this->projectAttributeRepository->all();

        return $this->sendResponse($projectAttributes->toArray(), 'Project Attributes retrieved successfully');
    }

    /**
     * @param CreateProjectAttributeAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/project-attributes",
     *      summary="Store a newly created ProjectAttribute in storage",
     *      tags={"ProjectAttribute"},
     *      description="Store ProjectAttribute",
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
     *          description="ProjectAttribute that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ProjectAttribute")
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
     *                  ref="#/definitions/ProjectAttribute"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */

//key: "instance_type"
//"question"
//"instance_id"
//"concept"
//"specification"
//"attachment"
//"describe"
//"designing"
//"developing"
//"project_managment"
//"business_analyst"
//"QA"
//"paypal"
//"cloud"
//"social"
//"other"
//"other_text"
    public function store(Request $request)
    {

        if ($request->instance_type == 1) {
            if ($request->describe == null) {
                return $this->sendErrorWithData([], 401, 'Select any one description in the list');
            }
            $validatedData = $request->validate([
                'describe' => 'required',
            ], [
                'describe.required' => 'Select any one description in the list',
            ]);
        } elseif ($request->instance_type == 2) {
            if ($request->has('validate')) {
                $validatedData = $request->validate([
                    'validate' => 'required',
                ], [
                    'validate.required' => 'Select any one project type in the given list',
                ]);
            }
        }

        if ($request->has('apiValidation')) {
            $validatedData = $request->validate([
                'apiValidation' => 'required',
            ], [
                'validate.required' => 'Select any one of API which you want in the given list',
            ]);
        }

        $validatedData = $request->validate([
            'attachment' => 'required',

        ], [
            'attachment.required' => 'Attachment is required',

        ]);

        $input = [];
        $input['project_id'] = $request->instance_id;
        $input['type'] = $request->instance_type;
        $detail = ProjectType::where('project_id', $request->instance_id)->first();
        if ($detail == null) {
            $projectType = $this->projectTypeRepository->saveRecord($input);
            $detail = $projectType;
        } else {
            $projectType = $this->projectTypeRepository->updateRecord($input, $detail);
        }

        $input['instance_id'] = $projectType->id;
        $input['describe'] = $request->describe;
        $input['designing'] = $request->designing;
        $input['developing'] = $request->developing;
        $input['project_management'] = $request->project_managment;
        $input['business_analyst'] = $request->business_analyst;
        $input['QA'] = $request->QA;
        $input['paypal'] = $request->paypal;
        $input['cloud'] = $request->cloud;
        $input['social'] = $request->social;
        $input['other'] = $request->other;
        $input['stage'] = $request->stage;
        $input['concept'] = $request->concept;
        $input['specification'] = $request->specification;
        $input['othertext'] = $request->other_text;
        $input['otherapi'] = $request->other;


        $feature = [];
        if ($request->instance_type == ProjectType::ONETIME) {
            $feature['instance_id'] = $input['instance_id'];
            $feature['instance_type'] = 'OneTime';
            $feature['content'] = json_encode([
                'describe'      => $input['describe'],
                'othertext'     => $input['othertext'],
                'specification' => $input['specification'],
                'concept'       => $input['concept'],
                'paypal'        => $input['paypal'],
                'cloud'         => $input['cloud'],
                'social'        => $input['social'],
                'otherapi'      => $input['other'],
                'stage'         => $input['stage'],
                'othertext'     => $input['othertext'],
            ]);


        }

        if ($request->instance_type == ProjectType::ONGOING) {
            $feature['instance_id'] = $input['instance_id'];
            $feature['instance_type'] = 'Ongoing';
            $feature['content'] = json_encode([
                'designer'        => $input['designing'],
                'developer'       => $input['developing'],
                'project_manager' => $input['project_management'],
                'analyst'         => $input['business_analyst'],
                'qa'              => $input['QA'],
                'other'           => $input['other'],
                'othertext'       => $input['othertext'],
                'specification'   => $input['specification'],
                'concept'         => $input['concept'],
                'paypal'          => $input['paypal'],
                'cloud'           => $input['cloud'],
                'social'          => $input['social'],
                'otherapi'        => $input['other'],
                'stage'           => $input['stage'],
                'othertext'       => $input['othertext'],
            ]);
//            $feature['amount'] = isset($request->amount) ? $request->amount : null;
        }

        if ($request->instance_type == ProjectType::NOTSURE) {
            $feature['instance_id'] = $input['instance_id'];
            $feature['instance_type'] = 'NotSure';
            $feature['content'] = json_encode([
                'othertext'     => $input['othertext'],
                'specification' => $input['specification'],
                'concept'       => $input['concept'],
                'paypal'        => $input['paypal'],
                'cloud'         => $input['cloud'],
                'social'        => $input['social'],
                'otherapi'      => $input['otherapi'],
                'stage'         => $input['stage'],
            ]);
        }


        $project = ProjectAttribute::where('instance_id', $detail->id)->first();

        if ($project !== null) {
            ProjectAttribute::where('instance_id', $project->id)->update($feature);
            $project = ProjectAttribute::where('instance_id', $detail->id)->first();
            $attributes = $project->id;
        } else {
            $project = ProjectAttribute::create($feature);
            $attributes = $project->id;
        }

        if ($request->stage == 1) {
            if ($request->has('attachment')) {
                $attachment = Attachment::where('instance_id', $attributes)->get();
                if ($attachment) {
                    foreach ($attachment as $atc)
                        Attachment::where('id', $atc->id)->delete();
                }
                $files = $request->file('attachment');
                $files = is_array($files) ? $files : [$files];
                foreach ($files as $file) {
                    $input['instance_id'] = $attributes;
                    $input['instance_type'] = 'specification-stage';
                    $input['attachment'] = Storage::putFile('stage', $file);
                    Attachment::create($input);
                }
            }
        }
        if ($request->stage == 2) {
            if ($request->has('design')) {
                $attachment = Attachment::where('instance_id', $attributes)->get();
                if ($attachment) {
                    foreach ($attachment as $atc)
                        Attachment::where('id', $atc->id)->delete();
                }
                $files = $request->file('design');
                $files = is_array($files) ? $files : [$files];
                foreach ($files as $file) {
                    $input['instance_id'] = $attributes;
                    $input['instance_type'] = 'design-stage';
                    $input['attachment'] = Storage::putFile('stage', $file);
                    Attachment::create($input);
                }
            }
        }

        $var = json_decode($request->question);
        $question = $var;
        foreach ($question as $row) {
            $list['project_id'] = $request->instance_id;
            $list['question'] = $row->question;
            Question::create($list);
        }
        return $this->sendResponse($project->toArray(), 'Project Attribute saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/project-attributes/{id}",
     *      summary="Display the specified ProjectAttribute",
     *      tags={"ProjectAttribute"},
     *      description="Get ProjectAttribute",
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
     *          description="id of ProjectAttribute",
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
     *                  ref="#/definitions/ProjectAttribute"
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
        /** @var ProjectAttribute $projectAttribute */
        $projectAttribute = $this->projectAttributeRepository->findWithoutFail($id);

        if (empty($projectAttribute)) {
            return $this->sendError('Project Attribute not found');
        }

        return $this->sendResponse($projectAttribute->toArray(), 'Project Attribute retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateProjectAttributeAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/project-attributes/{id}",
     *      summary="Update the specified ProjectAttribute in storage",
     *      tags={"ProjectAttribute"},
     *      description="Update ProjectAttribute",
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
     *          description="id of ProjectAttribute",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ProjectAttribute that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ProjectAttribute")
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
     *                  ref="#/definitions/ProjectAttribute"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateProjectAttributeAPIRequest $request)
    {
        /** @var ProjectAttribute $projectAttribute */
        $projectAttribute = $this->projectAttributeRepository->findWithoutFail($id);

        if (empty($projectAttribute)) {
            return $this->sendError('Project Attribute not found');
        }

        $projectAttribute = $this->projectAttributeRepository->updateRecord($request, $id);

        return $this->sendResponse($projectAttribute->toArray(), 'ProjectAttribute updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/project-attributes/{id}",
     *      summary="Remove the specified ProjectAttribute from storage",
     *      tags={"ProjectAttribute"},
     *      description="Delete ProjectAttribute",
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
     *          description="id of ProjectAttribute",
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
        /** @var ProjectAttribute $projectAttribute */
        $projectAttribute = $this->projectAttributeRepository->findWithoutFail($id);

        if (empty($projectAttribute)) {
            return $this->sendError('Project Attribute not found');
        }

        $this->projectAttributeRepository->deleteRecord($id);

        return $this->sendResponse($id, 'Project Attribute deleted successfully');
    }
}
