<?php

namespace App\Http\Controllers\Admin;

use App\Criteria\UserCriteria;
use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\EstimateDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateEstimateRequest;
use App\Http\Requests\Admin\UpdateEstimateRequest;
use App\Models\EstimateDetail;
use App\Models\User;
use App\Repositories\Admin\EstimateDetailRepository;
use App\Repositories\Admin\EstimateRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Admin\ProjectRepository;
use App\Repositories\Admin\UserRepository;
use Illuminate\Support\Facades\Mail;
use Laracasts\Flash\Flash;
use Illuminate\Http\Response;

class EstimateController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  EstimateRepository */
    private $estimateRepository;
    private $userRepository;
    private $projectRepository;
    private $estimateDetailRepository;

    public function __construct(EstimateRepository $estimateRepo, UserRepository $userRepo, ProjectRepository $projectRepo, EstimateDetailRepository $esimatedetailRepo)
    {
        $this->estimateRepository = $estimateRepo;
        $this->userRepository = $userRepo;
        $this->projectRepository = $projectRepo;
        $this->estimateDetailRepository = $esimatedetailRepo;
        $this->ModelName = 'estimates';
        $this->BreadCrumbName = 'Estimates';
    }

    /**
     * Display a listing of the Estimate.
     *
     * @param EstimateDataTable $estimateDataTable
     * @return Response
     */
    public function index(EstimateDataTable $estimateDataTable)
    {

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $estimateDataTable->render('admin.estimates.index', ['title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for creating a new Estimate.
     *
     * @return Response
     */
    public function create()
    {
        $customer = $this->userRepository
            ->resetCriteria()
            ->pushCriteria(new UserCriteria(['role' => User::CUSTOMER]))
            ->pluck('name', 'id');
        $projects = $this->projectRepository->pluck('name', 'id');
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return view('admin.estimates.create')->with([
            'title'    => $this->BreadCrumbName,
            'customer' => $customer,
            'projects' => $projects,
        ]);
    }

    /**
     * Store a newly created Estimate in storage.
     *
     * @param CreateEstimateRequest $request
     *
     * @return Response
     */
    public function store(CreateEstimateRequest $request)
    {

        $estimate = $this->estimateRepository->saveRecord($request);
        $details = [];

        foreach ($request->project_id as $key => $value) {
            $details['estimate_id'] = $estimate->id;
            $details['project_id'] = $request->project_id[$key];
            $details['description'] = $request->description[$key];
            $details['quantity'] = $request->quantity[$key];
            $details['price'] = $request->price[$key];
            $details['tax'] = $request->tax[$key];
            $estimatedetails = EstimateDetail::insert($details);
        }

        $email = 'finance@masology.net';
        $subject = 'Estimates of a project';

        $mail = Mail::send('email.finance', [
            'estimate' => $estimate,
        ],
            function ($mail) use ($email, $subject) {
                $mail->from(getenv('MAIL_FROM_ADDRESS'), getenv('APP_NAME'));
                $mail->to($email);
                $mail->subject($subject);
            });

        Flash::success($this->BreadCrumbName . ' saved successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.estimates.create'));
        } elseif (isset($request->translation)) {
            $redirect_to = redirect(route('admin.estimates.edit', $estimate->id));
        } else {
            $redirect_to = redirect(route('admin.estimates.index'));
        }
        return $redirect_to->with([
            'title' => $this->BreadCrumbName
        ]);
    }

    /**
     * Display the specified Estimate.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $estimate = $this->estimateRepository->findWithoutFail($id);

        if (empty($estimate)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.estimates.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $estimate);
        return view('admin.estimates.show')->with(['estimate' => $estimate, 'title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for editing the specified Estimate.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $estimate = $this->estimateRepository->findWithoutFail($id);
        $customer = $this->userRepository
            ->resetCriteria()
            ->pushCriteria(new UserCriteria(['role' => User::CUSTOMER]))
            ->pluck('name', 'id');
        $projects = $this->projectRepository->pluck('name', 'id');
        if (empty($estimate)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.estimates.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $estimate);
        return view('admin.estimates.edit')->with([
            'estimate' => $estimate,
            'customer' => $customer,
            'projects' => $projects,
            'title'    => $this->BreadCrumbName]);
    }

    /**
     * Update the specified Estimate in storage.
     *
     * @param  int $id
     * @param UpdateEstimateRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEstimateRequest $request)
    {
        $estimate = $this->estimateRepository->findWithoutFail($id);

        if (empty($estimate)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.estimates.index'));
        }

        $estimate = $this->estimateRepository->updateRecord($request, $estimate);

        Flash::success($this->BreadCrumbName . ' updated successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.estimates.create'));
        } else {
            $redirect_to = redirect(route('admin.estimates.index'));
        }
        return $redirect_to->with(['title' => $this->BreadCrumbName]);
    }

    /**
     * Remove the specified Estimate from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $estimate = $this->estimateRepository->findWithoutFail($id);

        if (empty($estimate)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.estimates.index'));
        }

        $this->estimateRepository->deleteRecord($id);

        Flash::success($this->BreadCrumbName . ' deleted successfully.');
        return redirect(route('admin.estimates.index'))->with(['title' => $this->BreadCrumbName]);
    }
}
