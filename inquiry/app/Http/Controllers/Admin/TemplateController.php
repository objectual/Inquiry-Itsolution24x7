<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\TemplateDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateTemplateRequest;
use App\Http\Requests\Admin\UpdateTemplateRequest;
use App\Models\Mailer;
use App\Repositories\Admin\MailerRepository;
use App\Repositories\Admin\ReceiverRepository;
use App\Repositories\Admin\TemplateRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Laracasts\Flash\Flash;
use Illuminate\Http\Response;

class TemplateController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  TemplateRepository */
    private $templateRepository;
    private $receiverRepository;
    private $mailerRepository;

    public function __construct(TemplateRepository $templateRepo, ReceiverRepository $receiverRepo, MailerRepository $mailerRepo)
    {
        $this->templateRepository = $templateRepo;
        $this->receiverRepository = $receiverRepo;
        $this->mailerRepository = $mailerRepo;
        $this->ModelName = 'templates';
        $this->BreadCrumbName = 'Templates';
    }

    /**
     * Display a listing of the Template.
     *
     * @param TemplateDataTable $templateDataTable
     * @return Response
     */
    public function index(TemplateDataTable $templateDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $templateDataTable->render('admin.templates.index', ['title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for creating a new Template.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return view('admin.templates.create')->with(['title' => $this->BreadCrumbName]);
    }

    /**
     * Store a newly created Template in storage.
     *
     * @param CreateTemplateRequest $request
     *
     * @return Response
     */
    public function store(CreateTemplateRequest $request)
    {
        $template = $this->templateRepository->saveRecord($request);

        Flash::success($this->BreadCrumbName . ' saved successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.templates.create'));
        } elseif (isset($request->translation)) {
            $redirect_to = redirect(route('admin.templates.edit', $template->id));
        } else {
            $redirect_to = redirect(route('admin.templates.index'));
        }
        return $redirect_to->with([
            'title' => $this->BreadCrumbName
        ]);
    }

    /**
     * Display the specified Template.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $template = $this->templateRepository->findWithoutFail($id);

        if (empty($template)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.templates.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $template);
        return view('admin.templates.show')->with(['template' => $template, 'title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for editing the specified Template.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $template = $this->templateRepository->findWithoutFail($id);

        if (empty($template)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.templates.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $template);
        return view('admin.templates.edit')->with(['template' => $template, 'title' => $this->BreadCrumbName]);
    }

    /**
     * Update the specified Template in storage.
     *
     * @param  int $id
     * @param UpdateTemplateRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTemplateRequest $request)
    {
        $template = $this->templateRepository->findWithoutFail($id);

        if (empty($template)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.templates.index'));
        }

        $template = $this->templateRepository->updateRecord($request, $template);

        Flash::success($this->BreadCrumbName . ' updated successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.templates.create'));
        } else {
            $redirect_to = redirect(route('admin.templates.index'));
        }
        return $redirect_to->with(['title' => $this->BreadCrumbName]);
    }

    /**
     * Remove the specified Template from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $template = $this->templateRepository->findWithoutFail($id);

        if (empty($template)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.templates.index'));
        }

        $this->templateRepository->deleteRecord($id);

        Flash::success($this->BreadCrumbName . ' deleted successfully.');
        return redirect(route('admin.templates.index'))->with(['title' => $this->BreadCrumbName]);
    }

    public function send($id)
    {
        $mailer = $this->mailerRepository->findWhere(['type' => Mailer::MAILER]);
        $receiver = $this->receiverRepository->findWhere(['type' => Mailer::RECEIVER]);
        $template = $this->templateRepository->findWithoutFail($id);
//        dd($mailer[0]->email);
        $ten = 10;
        $zero = 0;
        foreach ($receiver as $recieve) {
            for ($i = 0; $i <= $receiver->count(); $i++) {
                $number = 0;
                if ($i == $ten) {
                    $number += 10;
                    if ($i == $number) {
                        $send = $mailer[$i]->email;
                    }
                    $ten = +10;
                    $zero = +1;
                } else {
                    $send = $mailer[$zero]->email;
                }
                $subject = $template->subject;
                $email = $recieve->email;
            }
            env("MAIL_FROM_ADDRESS", "$send");
//            dd(getenv('MAIL_FROM_ADDRESS'), $send);
            $mail = Mail::send('email.templates', [
                'text' => $template->message,
            ],

                function ($mail) use ($send, $email, $subject) {
                    $mail->from($send, getenv('APP_NAME'));
                    $mail->to($email);
                    $mail->subject($subject);
                });
        }
        if ($mail) {
            Flash::success('All email sent successfully.');
            return redirect(route('admin.templates.index'))->with(['title' => $this->BreadCrumbName]);
        } else {
            Flash::success('All email sent successfully.');
            return redirect(route('admin.templates.index'))->with(['title' => $this->BreadCrumbName]);
        }

    }

    public function sending()
    {
        $template = $this->templateRepository->pluck('subject', 'id');
        $sender = $this->mailerRepository->findWhere(['type' => Mailer::MAILER])->pluck('email', 'id');

        return view('admin.templates.send')->with([
            'title'    => 'Send',
            'template' => $template,
            'sender'   => $sender
        ]);
    }

    public function forward(Request $request)
    {
        $receiver = explode("\r\n", $request->receiver);
        $mailer = $this->mailerRepository->findWithoutFail($request->sender_id);
        $template = $this->templateRepository->findWithoutFail($request->subject);
        $existing = config('mail');


        foreach ($receiver as $rec) {
            $send = $mailer->email;
            $new = array_merge(
                $existing, [
                'from' => [
                    'address'  => $send,
                    'name'     => 'Support Services',
                    'username' => $send,
                ],
            ]);

            config(['mail' => $new]);
            $subject = $template->subject;
            $mail = Mail::send('email.templates', [
                'text' => $template->message,
            ],

                function ($mail) use ($send, $rec, $subject) {
                    $mail->from($send, getenv('APP_NAME'));
                    $mail->to($rec);
                    $mail->subject($subject);
                });
        }
        if ($mail) {
            Flash::success('All email sent successfully.');
            return redirect(route('admin.templates.index'))->with(['title' => $this->BreadCrumbName]);
        } else {
            Flash::success('All email sent successfully.');
            return redirect(route('admin.templates.index'))->with(['title' => $this->BreadCrumbName]);
        }
    }
}
