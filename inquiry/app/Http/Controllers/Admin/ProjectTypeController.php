<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\ProjectTypeDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateProjectTypeRequest;
use App\Http\Requests\Admin\UpdateProjectTypeRequest;
use App\Repositories\Admin\ProjectTypeRepository;
use App\Http\Controllers\AppBaseController;
use Laracasts\Flash\Flash;
use Illuminate\Http\Response;

class ProjectTypeController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  ProjectTypeRepository */
    private $projectTypeRepository;

    public function __construct(ProjectTypeRepository $projectTypeRepo)
    {
        $this->projectTypeRepository = $projectTypeRepo;
        $this->ModelName = 'project-types';
        $this->BreadCrumbName = 'Project Types';
    }

    /**
     * Display a listing of the ProjectType.
     *
     * @param ProjectTypeDataTable $projectTypeDataTable
     * @return Response
     */
    public function index(ProjectTypeDataTable $projectTypeDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return $projectTypeDataTable->render('admin.project_types.index', ['title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for creating a new ProjectType.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return view('admin.project_types.create')->with(['title' => $this->BreadCrumbName]);
    }

    /**
     * Store a newly created ProjectType in storage.
     *
     * @param CreateProjectTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateProjectTypeRequest $request)
    {
        $projectType = $this->projectTypeRepository->saveRecord($request);

        Flash::success($this->BreadCrumbName . ' saved successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.project-types.create'));
        } elseif (isset($request->translation)) {
            $redirect_to = redirect(route('admin.project-types.edit', $projectType->id));
        } else {
            $redirect_to = redirect(route('admin.project-types.index'));
        }
        return $redirect_to->with([
            'title' => $this->BreadCrumbName
        ]);
    }

    /**
     * Display the specified ProjectType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $projectType = $this->projectTypeRepository->findWithoutFail($id);

        if (empty($projectType)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.project-types.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $projectType);
        return view('admin.project_types.show')->with(['projectType' => $projectType, 'title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for editing the specified ProjectType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $projectType = $this->projectTypeRepository->findWithoutFail($id);

        if (empty($projectType)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.project-types.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $projectType);
        return view('admin.project_types.edit')->with(['projectType' => $projectType, 'title' => $this->BreadCrumbName]);
    }

    /**
     * Update the specified ProjectType in storage.
     *
     * @param  int              $id
     * @param UpdateProjectTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProjectTypeRequest $request)
    {
        $projectType = $this->projectTypeRepository->findWithoutFail($id);

        if (empty($projectType)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.project-types.index'));
        }

        $projectType = $this->projectTypeRepository->updateRecord($request, $projectType);

        Flash::success($this->BreadCrumbName . ' updated successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.project-types.create'));
        } else {
            $redirect_to = redirect(route('admin.project-types.index'));
        }
        return $redirect_to->with(['title' => $this->BreadCrumbName]);
    }

    /**
     * Remove the specified ProjectType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $projectType = $this->projectTypeRepository->findWithoutFail($id);

        if (empty($projectType)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.project-types.index'));
        }

        $this->projectTypeRepository->deleteRecord($id);

        Flash::success($this->BreadCrumbName . ' deleted successfully.');
        return redirect(route('admin.project-types.index'))->with(['title' => $this->BreadCrumbName]);
    }
}
