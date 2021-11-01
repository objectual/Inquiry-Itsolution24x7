<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\EstimateDetailDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateEstimateDetailRequest;
use App\Http\Requests\Admin\UpdateEstimateDetailRequest;
use App\Repositories\Admin\EstimateDetailRepository;
use App\Http\Controllers\AppBaseController;
use Laracasts\Flash\Flash;
use Illuminate\Http\Response;

class EstimateDetailController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  EstimateDetailRepository */
    private $estimateDetailRepository;

    public function __construct(EstimateDetailRepository $estimateDetailRepo)
    {
        $this->estimateDetailRepository = $estimateDetailRepo;
        $this->ModelName = 'estimate-details';
        $this->BreadCrumbName = 'Estimate Details';
    }

    /**
     * Display a listing of the EstimateDetail.
     *
     * @param EstimateDetailDataTable $estimateDetailDataTable
     * @return Response
     */
    public function index(EstimateDetailDataTable $estimateDetailDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return $estimateDetailDataTable->render('admin.estimate_details.index', ['title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for creating a new EstimateDetail.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return view('admin.estimate_details.create')->with(['title' => $this->BreadCrumbName]);
    }

    /**
     * Store a newly created EstimateDetail in storage.
     *
     * @param CreateEstimateDetailRequest $request
     *
     * @return Response
     */
    public function store(CreateEstimateDetailRequest $request)
    {
        $estimateDetail = $this->estimateDetailRepository->saveRecord($request);

        Flash::success($this->BreadCrumbName . ' saved successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.estimate-details.create'));
        } elseif (isset($request->translation)) {
            $redirect_to = redirect(route('admin.estimate-details.edit', $estimateDetail->id));
        } else {
            $redirect_to = redirect(route('admin.estimate-details.index'));
        }
        return $redirect_to->with([
            'title' => $this->BreadCrumbName
        ]);
    }

    /**
     * Display the specified EstimateDetail.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $estimateDetail = $this->estimateDetailRepository->findWithoutFail($id);

        if (empty($estimateDetail)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.estimate-details.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $estimateDetail);
        return view('admin.estimate_details.show')->with(['estimateDetail' => $estimateDetail, 'title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for editing the specified EstimateDetail.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $estimateDetail = $this->estimateDetailRepository->findWithoutFail($id);

        if (empty($estimateDetail)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.estimate-details.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $estimateDetail);
        return view('admin.estimate_details.edit')->with(['estimateDetail' => $estimateDetail, 'title' => $this->BreadCrumbName]);
    }

    /**
     * Update the specified EstimateDetail in storage.
     *
     * @param  int              $id
     * @param UpdateEstimateDetailRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEstimateDetailRequest $request)
    {
        $estimateDetail = $this->estimateDetailRepository->findWithoutFail($id);

        if (empty($estimateDetail)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.estimate-details.index'));
        }

        $estimateDetail = $this->estimateDetailRepository->updateRecord($request, $estimateDetail);

        Flash::success($this->BreadCrumbName . ' updated successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.estimate-details.create'));
        } else {
            $redirect_to = redirect(route('admin.estimate-details.index'));
        }
        return $redirect_to->with(['title' => $this->BreadCrumbName]);
    }

    /**
     * Remove the specified EstimateDetail from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $estimateDetail = $this->estimateDetailRepository->findWithoutFail($id);

        if (empty($estimateDetail)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.estimate-details.index'));
        }

        $this->estimateDetailRepository->deleteRecord($id);

        Flash::success($this->BreadCrumbName . ' deleted successfully.');
        return redirect(route('admin.estimate-details.index'))->with(['title' => $this->BreadCrumbName]);
    }
}
