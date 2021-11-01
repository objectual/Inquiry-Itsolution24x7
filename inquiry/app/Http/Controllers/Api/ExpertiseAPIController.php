<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateExpertiseAPIRequest;
use App\Http\Requests\Api\UpdateExpertiseAPIRequest;
use App\Models\Expertise;
use App\Models\ProjectExpertise;
use App\Repositories\Admin\ExpertiseRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Http\Response;

/**
 * Class ExpertiseController
 * @package App\Http\Controllers\Api
 */
class ExpertiseAPIController extends AppBaseController
{
    /** @var  ExpertiseRepository */
    private $expertiseRepository;

    public function __construct(ExpertiseRepository $expertiseRepo)
    {
        $this->expertiseRepository = $expertiseRepo;
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @return Response
     *
     * @SWG\Get(
     *      path="/expertises",
     *      summary="Get a listing of the Expertises.",
     *      tags={"Expertise"},
     *      description="Get all Expertises",
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
     *                  @SWG\Items(ref="#/definitions/Expertise")
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
        $this->expertiseRepository->pushCriteria(new RequestCriteria($request));
        $this->expertiseRepository->pushCriteria(new LimitOffsetCriteria($request));
        $expertises = $this->expertiseRepository->all();

        return $this->sendResponse($expertises->toArray(), 'Expertises retrieved successfully');
    }

    /**
     * @param CreateExpertiseAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/expertises",
     *      summary="Store a newly created Expertise in storage",
     *      tags={"Expertise"},
     *      description="Store Expertise",
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
     *          description="Expertise that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Expertise")
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
     *                  ref="#/definitions/Expertise"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(Request $request)
    {
        $expert = $request->all();
        $var = $expert['expertise_id'];
        foreach ($var as $row) {
            $data['project_id'] = $request->project_id;
            $data['expertise_id'] = $row;
            $expert = ProjectExpertise::where(['project_id' => $request->project_id, 'expertise_id' => $row])->first();
            if ($expert !== null) {
                ProjectExpertise::where('id', $expert->id)->update($data);
            } else {
                ProjectExpertise::create($data);
            }
        }
        $expertises = ProjectExpertise::where('project_id', $request->project_id)->get();
        return $this->sendResponse($expertises->toArray(), 'Expertise saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/expertises/{id}",
     *      summary="Display the specified Expertise",
     *      tags={"Expertise"},
     *      description="Get Expertise",
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
     *          description="id of Expertise",
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
     *                  ref="#/definitions/Expertise"
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
        /** @var Expertise $expertise */
        $expertise = $this->expertiseRepository->findWithoutFail($id);

        if (empty($expertise)) {
            return $this->sendError('Expertise not found');
        }

        return $this->sendResponse($expertise->toArray(), 'Expertise retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateExpertiseAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/expertises/{id}",
     *      summary="Update the specified Expertise in storage",
     *      tags={"Expertise"},
     *      description="Update Expertise",
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
     *          description="id of Expertise",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Expertise that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Expertise")
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
     *                  ref="#/definitions/Expertise"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateExpertiseAPIRequest $request)
    {
        /** @var Expertise $expertise */
        $expertise = $this->expertiseRepository->findWithoutFail($id);

        if (empty($expertise)) {
            return $this->sendError('Expertise not found');
        }

        $expertise = $this->expertiseRepository->updateRecord($request, $id);

        return $this->sendResponse($expertise->toArray(), 'Expertise updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/expertises/{id}",
     *      summary="Remove the specified Expertise from storage",
     *      tags={"Expertise"},
     *      description="Delete Expertise",
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
     *          description="id of Expertise",
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
        /** @var Expertise $expertise */
        $expertise = $this->expertiseRepository->findWithoutFail($id);

        if (empty($expertise)) {
            return $this->sendError('Expertise not found');
        }

        $this->expertiseRepository->deleteRecord($id);

        return $this->sendResponse($id, 'Expertise deleted successfully');
    }
}
