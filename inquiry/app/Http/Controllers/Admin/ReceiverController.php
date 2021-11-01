<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\ReceiverDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateReceiverRequest;
use App\Http\Requests\Admin\UpdateReceiverRequest;
use App\Repositories\Admin\ReceiverRepository;
use App\Http\Controllers\AppBaseController;
use Laracasts\Flash\Flash;
use Illuminate\Http\Response;

class ReceiverController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  ReceiverRepository */
    private $receiverRepository;

    public function __construct(ReceiverRepository $receiverRepo)
    {
        $this->receiverRepository = $receiverRepo;
        $this->ModelName = 'receivers';
        $this->BreadCrumbName = 'Receivers';
    }

    /**
     * Display a listing of the Receiver.
     *
     * @param ReceiverDataTable $receiverDataTable
     * @return Response
     */
    public function index(ReceiverDataTable $receiverDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return $receiverDataTable->render('admin.receivers.index', ['title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for creating a new Receiver.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return view('admin.receivers.create')->with(['title' => $this->BreadCrumbName]);
    }

    /**
     * Store a newly created Receiver in storage.
     *
     * @param CreateReceiverRequest $request
     *
     * @return Response
     */
    public function store(CreateReceiverRequest $request)
    {
        $receiver = $this->receiverRepository->saveRecord($request);

        Flash::success($this->BreadCrumbName . ' saved successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.receivers.create'));
        } elseif (isset($request->translation)) {
            $redirect_to = redirect(route('admin.receivers.edit', $receiver->id));
        } else {
            $redirect_to = redirect(route('admin.receivers.index'));
        }
        return $redirect_to->with([
            'title' => $this->BreadCrumbName
        ]);
    }

    /**
     * Display the specified Receiver.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $receiver = $this->receiverRepository->findWithoutFail($id);

        if (empty($receiver)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.receivers.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $receiver);
        return view('admin.receivers.show')->with(['receiver' => $receiver, 'title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for editing the specified Receiver.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $receiver = $this->receiverRepository->findWithoutFail($id);

        if (empty($receiver)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.receivers.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $receiver);
        return view('admin.receivers.edit')->with(['receiver' => $receiver, 'title' => $this->BreadCrumbName]);
    }

    /**
     * Update the specified Receiver in storage.
     *
     * @param  int              $id
     * @param UpdateReceiverRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateReceiverRequest $request)
    {
        $receiver = $this->receiverRepository->findWithoutFail($id);

        if (empty($receiver)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.receivers.index'));
        }

        $receiver = $this->receiverRepository->updateRecord($request, $receiver);

        Flash::success($this->BreadCrumbName . ' updated successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.receivers.create'));
        } else {
            $redirect_to = redirect(route('admin.receivers.index'));
        }
        return $redirect_to->with(['title' => $this->BreadCrumbName]);
    }

    /**
     * Remove the specified Receiver from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $receiver = $this->receiverRepository->findWithoutFail($id);

        if (empty($receiver)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.receivers.index'));
        }

        $this->receiverRepository->deleteRecord($id);

        Flash::success($this->BreadCrumbName . ' deleted successfully.');
        return redirect(route('admin.receivers.index'))->with(['title' => $this->BreadCrumbName]);
    }
}
