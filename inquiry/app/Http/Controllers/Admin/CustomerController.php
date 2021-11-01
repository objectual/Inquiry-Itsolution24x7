<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\CustomerDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateCustomerRequest;
use App\Http\Requests\Admin\UpdateCustomerRequest;
use App\Models\User;
use App\Models\UserDetail;
use App\Repositories\Admin\CustomerRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Admin\UserRepository;
use Laracasts\Flash\Flash;
use Illuminate\Http\Response;

class CustomerController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  CustomerRepository */
    private $customerRepository;
    private $userRepository;

    public function __construct(CustomerRepository $customerRepo, UserRepository $userRepo)
    {
        $this->customerRepository = $customerRepo;
        $this->userRepository = $userRepo;
        $this->ModelName = 'customers';
        $this->BreadCrumbName = 'Customers';
    }

    /**
     * Display a listing of the Customer.
     *
     * @param CustomerDataTable $customerDataTable
     * @return Response
     */
    public function index(CustomerDataTable $customerDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $customerDataTable->render('admin.customers.index', ['title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for creating a new Customer.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return view('admin.customers.create')->with(['title' => $this->BreadCrumbName]);
    }

    /**
     * Store a newly created Customer in storage.
     *
     * @param CreateCustomerRequest $request
     *
     * @return Response
     */
    public function store(CreateCustomerRequest $request)
    {
        $customer = $this->customerRepository->saveRecord($request);
        $this->userRepository->attachRole($customer->id, User::CUSTOMER);
        $input = [];
        $input['user_id'] = $customer->id;
        $input['phone'] = $request->phone;
        $input['address'] = $request->address;
        UserDetail::create($input);

        Flash::success($this->BreadCrumbName . ' saved successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.customers.create'));
        } elseif (isset($request->translation)) {
            $redirect_to = redirect(route('admin.customers.edit', $customer->id));
        } else {
            $redirect_to = redirect(route('admin.customers.index'));
        }
        return $redirect_to->with([
            'title' => $this->BreadCrumbName
        ]);
    }

    /**
     * Display the specified Customer.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $customer = $this->customerRepository->findWithoutFail($id);

        if (empty($customer)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.customers.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $customer);
        return view('admin.customers.show')->with(['customer' => $customer, 'title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for editing the specified Customer.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $customer = $this->customerRepository->findWithoutFail($id);

        if (empty($customer)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.customers.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $customer);
        return view('admin.customers.edit')->with(['customer' => $customer, 'title' => $this->BreadCrumbName]);
    }

    /**
     * Update the specified Customer in storage.
     *
     * @param  int $id
     * @param UpdateCustomerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCustomerRequest $request)
    {
        $customer = $this->customerRepository->findWithoutFail($id);

        if (empty($customer)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.customers.index'));
        }

        $customer = $this->customerRepository->updateRecord($request, $customer);

        Flash::success($this->BreadCrumbName . ' updated successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.customers.create'));
        } else {
            $redirect_to = redirect(route('admin.customers.index'));
        }
        return $redirect_to->with(['title' => $this->BreadCrumbName]);
    }

    /**
     * Remove the specified Customer from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $customer = $this->customerRepository->findWithoutFail($id);

        if (empty($customer)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.customers.index'));
        }

        $this->customerRepository->deleteRecord($id);

        Flash::success($this->BreadCrumbName . ' deleted successfully.');
        return redirect(route('admin.customers.index'))->with(['title' => $this->BreadCrumbName]);
    }
}
