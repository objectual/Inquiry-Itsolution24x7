<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\ProjectAttributeDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateProjectAttributeRequest;
use App\Http\Requests\Admin\UpdateProjectAttributeRequest;
use App\Repositories\Admin\ProjectAttributeRepository;
use App\Http\Controllers\AppBaseController;
use Laracasts\Flash\Flash;
use Illuminate\Http\Response;

class ProjectAttributeController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  ProjectAttributeRepository */
    private $projectAttributeRepository;

    public function __construct(ProjectAttributeRepository $projectAttributeRepo)
    {
        $this->projectAttributeRepository = $projectAttributeRepo;
        $this->ModelName = 'project-attributes';
        $this->BreadCrumbName = 'Project Attributes';
    }

    /**
     * Display a listing of the ProjectAttribute.
     *
     * @param ProjectAttributeDataTable $projectAttributeDataTable
     * @return Response
     */
    public function index(ProjectAttributeDataTable $projectAttributeDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return $projectAttributeDataTable->render('admin.project_attributes.index', ['title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for creating a new ProjectAttribute.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return view('admin.project_attributes.create')->with(['title' => $this->BreadCrumbName]);
    }

    /**
     * Store a newly created ProjectAttribute in storage.
     *
     * @param CreateProjectAttributeRequest $request
     *
     * @return Response
     */
    public function store(CreateProjectAttributeRequest $request)
    {
        $projectAttribute = $this->projectAttributeRepository->saveRecord($request);

        Flash::success($this->BreadCrumbName . ' saved successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.project-attributes.create'));
        } elseif (isset($request->translation)) {
            $redirect_to = redirect(route('admin.project-attributes.edit', $projectAttribute->id));
        } else {
            $redirect_to = redirect(route('admin.project-attributes.index'));
        }
        return $redirect_to->with([
            'title' => $this->BreadCrumbName
        ]);
    }

    /**
     * Display the specified ProjectAttribute.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $projectAttribute = $this->projectAttributeRepository->findWithoutFail($id);

        if (empty($projectAttribute)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.project-attributes.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $projectAttribute);
        return view('admin.project_attributes.show')->with(['projectAttribute' => $projectAttribute, 'title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for editing the specified ProjectAttribute.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $projectAttribute = $this->projectAttributeRepository->findWithoutFail($id);

        if (empty($projectAttribute)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.project-attributes.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $projectAttribute);
        return view('admin.project_attributes.edit')->with(['projectAttribute' => $projectAttribute, 'title' => $this->BreadCrumbName]);
    }

    /**
     * Update the specified ProjectAttribute in storage.
     *
     * @param  int              $id
     * @param UpdateProjectAttributeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProjectAttributeRequest $request)
    {
        $projectAttribute = $this->projectAttributeRepository->findWithoutFail($id);

        if (empty($projectAttribute)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.project-attributes.index'));
        }

        $projectAttribute = $this->projectAttributeRepository->updateRecord($request, $projectAttribute);

        Flash::success($this->BreadCrumbName . ' updated successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.project-attributes.create'));
        } else {
            $redirect_to = redirect(route('admin.project-attributes.index'));
        }
        return $redirect_to->with(['title' => $this->BreadCrumbName]);
    }

    /**
     * Remove the specified ProjectAttribute from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $projectAttribute = $this->projectAttributeRepository->findWithoutFail($id);

        if (empty($projectAttribute)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.project-attributes.index'));
        }

        $this->projectAttributeRepository->deleteRecord($id);

        Flash::success($this->BreadCrumbName . ' deleted successfully.');
        return redirect(route('admin.project-attributes.index'))->with(['title' => $this->BreadCrumbName]);
    }
}
