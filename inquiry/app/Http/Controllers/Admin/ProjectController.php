<?php

namespace App\Http\Controllers\Admin;

use App\Criteria\UserCriteria;
use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\ProjectDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateProjectRequest;
use App\Http\Requests\Admin\UpdateProjectRequest;
use App\Models\User;
use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\ProjectRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Admin\UserRepository;
use Laracasts\Flash\Flash;
use Illuminate\Http\Response;

class ProjectController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  ProjectRepository */
    private $projectRepository;
    private $userRepository;
    private $catRepository;

    public function __construct(ProjectRepository $projectRepo, UserRepository $userRepo, CategoryRepository $catRepo)
    {
        $this->projectRepository = $projectRepo;
        $this->catRepository = $catRepo;
        $this->userRepository = $userRepo;
        $this->ModelName = 'projects';
        $this->BreadCrumbName = 'Projects';
    }

    /**
     * Display a listing of the Project.
     *
     * @param ProjectDataTable $projectDataTable
     * @return Response
     */
    public function index(ProjectDataTable $projectDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $projectDataTable->render('admin.projects.index', ['title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for creating a new Project.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        $user = $this->userRepository
            ->resetCriteria()
            ->pushCriteria(new UserCriteria(['role' => User::CUSTOMER]))
            ->pluck('name', 'id');
        $category = $this->catRepository->pluck('name', 'id');
        return view('admin.projects.create')->with([
            'title'    => $this->BreadCrumbName,
            'user'     => $user,
            'category' => $category,
        ]);
    }

    /**
     * Store a newly created Project in storage.
     *
     * @param CreateProjectRequest $request
     *
     * @return Response
     */
    public function store(CreateProjectRequest $request)
    {
        $project = $this->projectRepository->saveRecord($request);

        Flash::success($this->BreadCrumbName . ' saved successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.projects.create'));
        } elseif (isset($request->translation)) {
            $redirect_to = redirect(route('admin.projects.edit', $project->id));
        } else {
            $redirect_to = redirect(route('admin.projects.index'));
        }
        return $redirect_to->with([
            'title' => $this->BreadCrumbName
        ]);
    }

    /**
     * Display the specified Project.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $project = $this->projectRepository->findWithoutFail($id);

        if (empty($project)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.projects.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $project);
        return view('admin.projects.show')->with(['project' => $project, 'title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for editing the specified Project.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $project = $this->projectRepository->findWithoutFail($id);

        if (empty($project)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.projects.index'));
        }
        $user = $this->userRepository
            ->resetCriteria()
            ->pushCriteria(new UserCriteria(['role' => User::CUSTOMER]))
            ->pluck('name', 'id');
        $category = $this->catRepository->pluck('name', 'id');
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $project);
        return view('admin.projects.edit')->with([
            'project' => $project,
            'user' => $user,
            'category' => $category,
            'title' => $this->BreadCrumbName]);
    }

    /**
     * Update the specified Project in storage.
     *
     * @param  int $id
     * @param UpdateProjectRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProjectRequest $request)
    {
        $project = $this->projectRepository->findWithoutFail($id);

        if (empty($project)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.projects.index'));
        }
        $project = $this->projectRepository->updateRecord($request, $project);
        Flash::success($this->BreadCrumbName . ' updated successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.projects.create'));
        } else {
            $redirect_to = redirect(route('admin.projects.index'));
        }
        return $redirect_to->with(['title' => $this->BreadCrumbName]);
    }

    /**
     * Remove the specified Project from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $project = $this->projectRepository->findWithoutFail($id);

        if (empty($project)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.projects.index'));
        }

        $this->projectRepository->deleteRecord($id);

        Flash::success($this->BreadCrumbName . ' deleted successfully.');
        return redirect(route('admin.projects.index'))->with(['title' => $this->BreadCrumbName]);
    }
}
