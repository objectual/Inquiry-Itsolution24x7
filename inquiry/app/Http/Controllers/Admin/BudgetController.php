<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\BudgetDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateBudgetRequest;
use App\Http\Requests\Admin\UpdateBudgetRequest;
use App\Repositories\Admin\BudgetRepository;
use App\Http\Controllers\AppBaseController;
use Laracasts\Flash\Flash;
use Illuminate\Http\Response;

class BudgetController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  BudgetRepository */
    private $budgetRepository;

    public function __construct(BudgetRepository $budgetRepo)
    {
        $this->budgetRepository = $budgetRepo;
        $this->ModelName = 'budgets';
        $this->BreadCrumbName = 'Budgets';
    }

    /**
     * Display a listing of the Budget.
     *
     * @param BudgetDataTable $budgetDataTable
     * @return Response
     */
    public function index(BudgetDataTable $budgetDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return $budgetDataTable->render('admin.budgets.index', ['title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for creating a new Budget.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return view('admin.budgets.create')->with(['title' => $this->BreadCrumbName]);
    }

    /**
     * Store a newly created Budget in storage.
     *
     * @param CreateBudgetRequest $request
     *
     * @return Response
     */
    public function store(CreateBudgetRequest $request)
    {
        $budget = $this->budgetRepository->saveRecord($request);

        Flash::success($this->BreadCrumbName . ' saved successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.budgets.create'));
        } elseif (isset($request->translation)) {
            $redirect_to = redirect(route('admin.budgets.edit', $budget->id));
        } else {
            $redirect_to = redirect(route('admin.budgets.index'));
        }
        return $redirect_to->with([
            'title' => $this->BreadCrumbName
        ]);
    }

    /**
     * Display the specified Budget.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $budget = $this->budgetRepository->findWithoutFail($id);

        if (empty($budget)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.budgets.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $budget);
        return view('admin.budgets.show')->with(['budget' => $budget, 'title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for editing the specified Budget.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $budget = $this->budgetRepository->findWithoutFail($id);

        if (empty($budget)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.budgets.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $budget);
        return view('admin.budgets.edit')->with(['budget' => $budget, 'title' => $this->BreadCrumbName]);
    }

    /**
     * Update the specified Budget in storage.
     *
     * @param  int              $id
     * @param UpdateBudgetRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBudgetRequest $request)
    {
        $budget = $this->budgetRepository->findWithoutFail($id);

        if (empty($budget)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.budgets.index'));
        }

        $budget = $this->budgetRepository->updateRecord($request, $budget);

        Flash::success($this->BreadCrumbName . ' updated successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.budgets.create'));
        } else {
            $redirect_to = redirect(route('admin.budgets.index'));
        }
        return $redirect_to->with(['title' => $this->BreadCrumbName]);
    }

    /**
     * Remove the specified Budget from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $budget = $this->budgetRepository->findWithoutFail($id);

        if (empty($budget)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.budgets.index'));
        }

        $this->budgetRepository->deleteRecord($id);

        Flash::success($this->BreadCrumbName . ' deleted successfully.');
        return redirect(route('admin.budgets.index'))->with(['title' => $this->BreadCrumbName]);
    }
}
