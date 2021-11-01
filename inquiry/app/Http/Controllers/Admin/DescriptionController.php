<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\DescriptionDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateDescriptionRequest;
use App\Http\Requests\Admin\UpdateDescriptionRequest;
use App\Repositories\Admin\DescriptionRepository;
use App\Http\Controllers\AppBaseController;
use Laracasts\Flash\Flash;
use Illuminate\Http\Response;

class DescriptionController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  DescriptionRepository */
    private $descriptionRepository;

    public function __construct(DescriptionRepository $descriptionRepo)
    {
        $this->descriptionRepository = $descriptionRepo;
        $this->ModelName = 'descriptions';
        $this->BreadCrumbName = 'Descriptions';
    }

    /**
     * Display a listing of the Description.
     *
     * @param DescriptionDataTable $descriptionDataTable
     * @return Response
     */
    public function index(DescriptionDataTable $descriptionDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return $descriptionDataTable->render('admin.descriptions.index', ['title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for creating a new Description.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return view('admin.descriptions.create')->with(['title' => $this->BreadCrumbName]);
    }

    /**
     * Store a newly created Description in storage.
     *
     * @param CreateDescriptionRequest $request
     *
     * @return Response
     */
    public function store(CreateDescriptionRequest $request)
    {
        $description = $this->descriptionRepository->saveRecord($request);

        Flash::success($this->BreadCrumbName . ' saved successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.descriptions.create'));
        } elseif (isset($request->translation)) {
            $redirect_to = redirect(route('admin.descriptions.edit', $description->id));
        } else {
            $redirect_to = redirect(route('admin.descriptions.index'));
        }
        return $redirect_to->with([
            'title' => $this->BreadCrumbName
        ]);
    }

    /**
     * Display the specified Description.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $description = $this->descriptionRepository->findWithoutFail($id);

        if (empty($description)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.descriptions.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $description);
        return view('admin.descriptions.show')->with(['description' => $description, 'title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for editing the specified Description.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $description = $this->descriptionRepository->findWithoutFail($id);

        if (empty($description)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.descriptions.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $description);
        return view('admin.descriptions.edit')->with(['description' => $description, 'title' => $this->BreadCrumbName]);
    }

    /**
     * Update the specified Description in storage.
     *
     * @param  int              $id
     * @param UpdateDescriptionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDescriptionRequest $request)
    {
        $description = $this->descriptionRepository->findWithoutFail($id);

        if (empty($description)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.descriptions.index'));
        }

        $description = $this->descriptionRepository->updateRecord($request, $description);

        Flash::success($this->BreadCrumbName . ' updated successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.descriptions.create'));
        } else {
            $redirect_to = redirect(route('admin.descriptions.index'));
        }
        return $redirect_to->with(['title' => $this->BreadCrumbName]);
    }

    /**
     * Remove the specified Description from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $description = $this->descriptionRepository->findWithoutFail($id);

        if (empty($description)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.descriptions.index'));
        }

        $this->descriptionRepository->deleteRecord($id);

        Flash::success($this->BreadCrumbName . ' deleted successfully.');
        return redirect(route('admin.descriptions.index'))->with(['title' => $this->BreadCrumbName]);
    }
}
