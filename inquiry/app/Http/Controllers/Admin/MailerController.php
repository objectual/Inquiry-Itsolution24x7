<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\MailerDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateMailerRequest;
use App\Http\Requests\Admin\UpdateMailerRequest;
use App\Repositories\Admin\MailerRepository;
use App\Http\Controllers\AppBaseController;
use Laracasts\Flash\Flash;
use Illuminate\Http\Response;

class MailerController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  MailerRepository */
    private $mailerRepository;

    public function __construct(MailerRepository $mailerRepo)
    {
        $this->mailerRepository = $mailerRepo;
        $this->ModelName = 'mailers';
        $this->BreadCrumbName = 'Mailers';
    }

    /**
     * Display a listing of the Mailer.
     *
     * @param MailerDataTable $mailerDataTable
     * @return Response
     */
    public function index(MailerDataTable $mailerDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return $mailerDataTable->render('admin.mailers.index', ['title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for creating a new Mailer.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return view('admin.mailers.create')->with(['title' => $this->BreadCrumbName]);
    }

    /**
     * Store a newly created Mailer in storage.
     *
     * @param CreateMailerRequest $request
     *
     * @return Response
     */
    public function store(CreateMailerRequest $request)
    {
        $mailer = $this->mailerRepository->saveRecord($request);

        Flash::success($this->BreadCrumbName . ' saved successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.mailers.create'));
        } elseif (isset($request->translation)) {
            $redirect_to = redirect(route('admin.mailers.edit', $mailer->id));
        } else {
            $redirect_to = redirect(route('admin.mailers.index'));
        }
        return $redirect_to->with([
            'title' => $this->BreadCrumbName
        ]);
    }

    /**
     * Display the specified Mailer.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $mailer = $this->mailerRepository->findWithoutFail($id);

        if (empty($mailer)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.mailers.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $mailer);
        return view('admin.mailers.show')->with(['mailer' => $mailer, 'title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for editing the specified Mailer.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $mailer = $this->mailerRepository->findWithoutFail($id);

        if (empty($mailer)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.mailers.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $mailer);
        return view('admin.mailers.edit')->with(['mailer' => $mailer, 'title' => $this->BreadCrumbName]);
    }

    /**
     * Update the specified Mailer in storage.
     *
     * @param  int              $id
     * @param UpdateMailerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMailerRequest $request)
    {
        $mailer = $this->mailerRepository->findWithoutFail($id);

        if (empty($mailer)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.mailers.index'));
        }

        $mailer = $this->mailerRepository->updateRecord($request, $mailer);

        Flash::success($this->BreadCrumbName . ' updated successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.mailers.create'));
        } else {
            $redirect_to = redirect(route('admin.mailers.index'));
        }
        return $redirect_to->with(['title' => $this->BreadCrumbName]);
    }

    /**
     * Remove the specified Mailer from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $mailer = $this->mailerRepository->findWithoutFail($id);

        if (empty($mailer)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.mailers.index'));
        }

        $this->mailerRepository->deleteRecord($id);

        Flash::success($this->BreadCrumbName . ' deleted successfully.');
        return redirect(route('admin.mailers.index'))->with(['title' => $this->BreadCrumbName]);
    }
}
