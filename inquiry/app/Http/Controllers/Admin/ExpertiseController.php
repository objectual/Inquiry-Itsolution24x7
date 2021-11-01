<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\ExpertiseDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateExpertiseRequest;
use App\Http\Requests\Admin\UpdateExpertiseRequest;
use App\Repositories\Admin\ExpertiseRepository;
use App\Http\Controllers\AppBaseController;
use Laracasts\Flash\Flash;
use Illuminate\Http\Response;

class ExpertiseController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  ExpertiseRepository */
    private $expertiseRepository;

    public function __construct(ExpertiseRepository $expertiseRepo)
    {
        $this->expertiseRepository = $expertiseRepo;
        $this->ModelName = 'expertises';
        $this->BreadCrumbName = 'Expertises';
    }

    /**
     * Display a listing of the Expertise.
     *
     * @param ExpertiseDataTable $expertiseDataTable
     * @return Response
     */
    public function index(ExpertiseDataTable $expertiseDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return $expertiseDataTable->render('admin.expertises.index', ['title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for creating a new Expertise.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return view('admin.expertises.create')->with(['title' => $this->BreadCrumbName]);
    }

    /**
     * Store a newly created Expertise in storage.
     *
     * @param CreateExpertiseRequest $request
     *
     * @return Response
     */
    public function store(CreateExpertiseRequest $request)
    {
        $expertise = $this->expertiseRepository->saveRecord($request);

        Flash::success($this->BreadCrumbName . ' saved successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.expertises.create'));
        } elseif (isset($request->translation)) {
            $redirect_to = redirect(route('admin.expertises.edit', $expertise->id));
        } else {
            $redirect_to = redirect(route('admin.expertises.index'));
        }
        return $redirect_to->with([
            'title' => $this->BreadCrumbName
        ]);
    }

    /**
     * Display the specified Expertise.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $expertise = $this->expertiseRepository->findWithoutFail($id);

        if (empty($expertise)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.expertises.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $expertise);
        return view('admin.expertises.show')->with(['expertise' => $expertise, 'title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for editing the specified Expertise.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $expertise = $this->expertiseRepository->findWithoutFail($id);

        if (empty($expertise)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.expertises.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $expertise);
        return view('admin.expertises.edit')->with(['expertise' => $expertise, 'title' => $this->BreadCrumbName]);
    }

    /**
     * Update the specified Expertise in storage.
     *
     * @param  int              $id
     * @param UpdateExpertiseRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateExpertiseRequest $request)
    {
        $expertise = $this->expertiseRepository->findWithoutFail($id);

        if (empty($expertise)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.expertises.index'));
        }

        $expertise = $this->expertiseRepository->updateRecord($request, $expertise);

        Flash::success($this->BreadCrumbName . ' updated successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.expertises.create'));
        } else {
            $redirect_to = redirect(route('admin.expertises.index'));
        }
        return $redirect_to->with(['title' => $this->BreadCrumbName]);
    }

    /**
     * Remove the specified Expertise from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $expertise = $this->expertiseRepository->findWithoutFail($id);

        if (empty($expertise)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.expertises.index'));
        }

        $this->expertiseRepository->deleteRecord($id);

        Flash::success($this->BreadCrumbName . ' deleted successfully.');
        return redirect(route('admin.expertises.index'))->with(['title' => $this->BreadCrumbName]);
    }
}
