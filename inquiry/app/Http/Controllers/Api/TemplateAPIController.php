<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateTemplateAPIRequest;
use App\Http\Requests\Api\UpdateTemplateAPIRequest;
use App\Models\Template;
use App\Repositories\Admin\TemplateRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Http\Response;

/**
 * Class TemplateController
 * @package App\Http\Controllers\Api
 */

class TemplateAPIController extends AppBaseController
{
    /** @var  TemplateRepository */
    private $templateRepository;

    public function __construct(TemplateRepository $templateRepo)
    {
        $this->templateRepository = $templateRepo;
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @return Response
     *
     * @SWG\Get(
     *      path="/templates",
     *      summary="Get a listing of the Templates.",
     *      tags={"Template"},
     *      description="Get all Templates",
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
     *                  @SWG\Items(ref="#/definitions/Template")
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
        $this->templateRepository->pushCriteria(new RequestCriteria($request));
        $this->templateRepository->pushCriteria(new LimitOffsetCriteria($request));
        $templates = $this->templateRepository->all();

        return $this->sendResponse($templates->toArray(), 'Templates retrieved successfully');
    }

    /**
     * @param CreateTemplateAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/templates",
     *      summary="Store a newly created Template in storage",
     *      tags={"Template"},
     *      description="Store Template",
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
     *          description="Template that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Template")
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
     *                  ref="#/definitions/Template"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateTemplateAPIRequest $request)
    {
        $templates = $this->templateRepository->saveRecord($request);

        return $this->sendResponse($templates->toArray(), 'Template saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/templates/{id}",
     *      summary="Display the specified Template",
     *      tags={"Template"},
     *      description="Get Template",
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
     *          description="id of Template",
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
     *                  ref="#/definitions/Template"
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
        /** @var Template $template */
        $template = $this->templateRepository->findWithoutFail($id);

        if (empty($template)) {
            return $this->sendError('Template not found');
        }

        return $this->sendResponse($template->toArray(), 'Template retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateTemplateAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/templates/{id}",
     *      summary="Update the specified Template in storage",
     *      tags={"Template"},
     *      description="Update Template",
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
     *          description="id of Template",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Template that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Template")
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
     *                  ref="#/definitions/Template"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateTemplateAPIRequest $request)
    {
        /** @var Template $template */
        $template = $this->templateRepository->findWithoutFail($id);

        if (empty($template)) {
            return $this->sendError('Template not found');
        }

        $template = $this->templateRepository->updateRecord($request, $id);

        return $this->sendResponse($template->toArray(), 'Template updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/templates/{id}",
     *      summary="Remove the specified Template from storage",
     *      tags={"Template"},
     *      description="Delete Template",
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
     *          description="id of Template",
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
        /** @var Template $template */
        $template = $this->templateRepository->findWithoutFail($id);

        if (empty($template)) {
            return $this->sendError('Template not found');
        }

        $this->templateRepository->deleteRecord($id);

        return $this->sendResponse($id, 'Template deleted successfully');
    }
}
