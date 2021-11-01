<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\CreateDescriptionRequest;
use App\Http\Requests\Admin\CreateExpertiseRequest;
use App\Http\Requests\Admin\CreateQuestionRequest;
use App\Models\Attachment;
use App\Models\Budget;
use App\Models\Category;
use App\Models\Description;
use App\Models\Expertise;
use App\Models\Project;
use App\Models\ProjectAttribute;
use App\Models\ProjectExpertise;
use App\Models\ProjectType;
use App\Models\User;
use App\Repositories\Admin\BudgetRepository;
use App\Repositories\Admin\DescriptionRepository;
use App\Repositories\Admin\ExpertiseRepository;
use App\Repositories\Admin\ProjectRepository;
use App\Repositories\Admin\ProjectTypeRepository;
use App\Repositories\Admin\QuestionRepository;
use App\Repositories\Admin\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
////        $this->middleware('auth');
//    }

    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  ProjectRepository */
    private $projectRepository;
    private $userRepository;
    private $descriptionRepository;
    /** @var  ProjectTypeRepository */
    private $projectTypeRepository;
    /** @var  QuestionRepository */
    private $questionRepository;
    /** @var  ExpertiseRepository */
    private $expertiseRepository;

    /** @var  BudgetRepository */
    private $budgetRepository;

    public function __construct(ExpertiseRepository $expertiseRepo, QuestionRepository $questionRepo, ProjectTypeRepository $projectTypeRepo, ProjectRepository $projectRepo, UserRepository $userRepo, DescriptionRepository $descriptionRepo, BudgetRepository $budgetRepo)
    {
        $this->budgetRepository = $budgetRepo;
        $this->questionRepository = $questionRepo;
        $this->expertiseRepository = $expertiseRepo;
        $this->projectTypeRepository = $projectTypeRepo;
        $this->projectRepository = $projectRepo;
        $this->userRepository = $userRepo;
        $this->descriptionRepository = $descriptionRepo;
        $this->ModelName = 'projects';
        $this->BreadCrumbName = 'Projects';
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $name = \Request::route()->getName();
        if (isset($email)) {
            $url = url('title', ['email', $email]);
        } else {
            $url = null;
        }
        return view('web.home')->with([
            'name' => $name,
            'url'  => $url,
        ]);
    }

    public function home()
    {
        $name = \Request::route()->getName();
        return view('web.home')->with(['name' => $name]);
    }

    public function title(Request $request)
    {
        if ($request->email) {
            //Email Verification with DB
            $email = $request->email;
            $user = User::where('email', $email)->first();
            if ($user->count() == 0) {
                return redirect('');
            }
        } else {
            return redirect('');
        }
        $project = Project::where(['user_id' => $user->id, 'status' => 0])->first();
//        dd($project);
        if ($project != null) {
            if ($project->status == 0) {
                $exist = $project;
            } else {
                $exist = null;
            }
        } else {
            $exist = null;
        }
        $name = \Request::route()->getName();
        $category = Category::all();
        if (isset($email)) {
            $url = url('title', ['email', $email]);
        }


        return view('web.home')->with([
            'name'     => $name,
            'category' => $category,
            'exist'    => $exist,
            'url'      => $url,
            'email'    => $email
        ]);
    }

    public function projectStore(Request $request)
    {
        $email = $request->email;
        $user = User::where('email', $email)->first();
        $request['user_id'] = $user->id;
        $project = Project::where(['user_id' => $user->id, 'status' => 0])->first();
        if ($project != null) {
            $project = $this->projectRepository->updateRecord($request->all(), $project->id);
        } else {
            $project = $this->projectRepository->saveRecord($request);
        }
        if ($project) {
            $url = url('detail', ['project_id', $project->id]);
            return redirect($url);
//            return redirect('description' . '?project_id=' . $project->id . '&id=' . $user->id);
        }
    }

    public function detail(Request $request)
    {
        if ($request->project_id) {
            $valid = $this->projectRepository->verifyProject($request->project_id);
            $email = $this->projectRepository->verifyUser($request->project_id);
            if ($valid == 0) {
                return redirect('');
            }
        } else {
            return redirect('');
        }

        $project = $this->projectRepository->findWithoutFail($request->project_id);

        if ($project) {
            $type = ProjectType::where('project_id', $request->project_id)->first();
            $exist = $project;
            if ($type) {
                $attributes = ProjectAttribute::where('instance_id', $type->id)->first();
                $attachment = Attachment::where('instance_id', $attributes->id)->first();
                if ($attachment !== null) {
                    $images = $attachment;
                } else {
                    $images = null;
                }
                if ($attributes) {
                    $content = json_decode($attributes->content);
                } else {
                    $content = null;
                }
            } else {
                $attributes = null;
                $content = null;
                $type = null;
                $images = null;
            }
        }
        if (isset($email)) {
            $url = url('title', ['email', $email]);
        }

        $project_id = $request->project_id;
        $name = \Request::route()->getName();
        return view('web.home')->with([
            'name'       => $name,
            'project_id' => $project_id,
            'type'       => $type,
            'attributes' => $attributes,
            'content'    => $content,
            'url'        => $url,
            'exist'      => $exist,
            'attachment' => $images
        ]);
    }

    public function detailStore(Request $request)
    {
        $validatedData = $request->validate([
            'type'  => 'required',
            'stage' => 'required',
        ], [
            'type.required'  => 'Type is required',
            'stage.required' => 'Stage is required'
        ]);

//        if ($request->stage == 1) {
//            $validatedData = $request->validate([
//                'specification' => 'required',
//            ], [
//                'specification.required' => 'Specification is required',
//            ]);
//        }

        if ($request->stage == 2) {
            $validatedData = $request->validate([
                'design' => 'required',
            ], [
                'design.required' => 'Design is required',
            ]);
        }

        if ($request->stage == 3) {
            $validatedData = $request->validate([
                'concept' => 'required',
            ], [
                'concept.required' => 'Concept is required',
            ]);
        }

        if ($request->project_id) {
            $valid = $this->projectRepository->verifyProject($request->project_id);
            if ($valid == 0) {
                return redirect('');
            }
        } else {
            return redirect('');
        }
        $input = [];
        $feature = [];
        $input['project_id'] = $request->project_id;
        $input['type'] = $request->type;
        $detail = ProjectType::where('project_id', $request->project_id)->first();
        if ($detail == null) {
            $projectType = $this->projectTypeRepository->saveRecord($input);
            $detail = $projectType;
        } else {
            $projectType = $this->projectTypeRepository->updateRecord($input, $detail);
        }

        if ($request->stage == 1) {
            $request->concept = null;
        }

        if ($request->stage == 2) {
            $request->specification = null;
            $request->concept = null;
        }

        if ($request->stage == 3) {
            $request->specification = null;
        }
        if ($request->type == ProjectType::ONETIME) {
            $feature['instance_id'] = $projectType->id;
            $feature['instance_type'] = 'OneTime';
            $feature['content'] = json_encode([
                'describe'      => $request->describe,
                'othertext'     => $request->othertext,
                'specification' => $request->specification,
                'concept'       => $request->concept,
                'paypal'        => $request->paypal,
                'cloud'         => $request->cloud,
                'social'        => $request->social,
                'otherapi'      => $request->otherapi,
                'stage'         => $request->stage,
                'othertext'     => $request->othertext,
            ]);
//            $feature['amount'] = isset($request->amount) ? $request->amount : null;

        }

        if ($request->type == ProjectType::ONGOING) {
            $feature['instance_id'] = $projectType->id;
            $feature['instance_type'] = 'Ongoing';
            $feature['content'] = json_encode([
                'designer'        => $request->designer,
                'developer'       => $request->developer,
                'project_manager' => $request->project_manager,
                'analyst'         => $request->analyst,
                'qa'              => $request->qa,
                'other'           => $request->other,
                'othertext'       => $request->othertext,
                'specification'   => $request->specification,
                'concept'         => $request->concept,
                'paypal'          => $request->paypal,
                'cloud'           => $request->cloud,
                'social'          => $request->social,
                'otherapi'        => $request->otherapi,
                'stage'           => $request->stage,
                'othertext'       => $request->othertext,
            ]);
//            $feature['amount'] = isset($request->amount) ? $request->amount : null;
        }

        if ($request->type == ProjectType::NOTSURE) {
            $feature['instance_id'] = $projectType->id;
            $feature['instance_type'] = 'NotSure';
            $feature['content'] = json_encode([
                'othertext'     => $request->othertext,
                'specification' => $request->specification,
                'concept'       => $request->concept,
                'paypal'        => $request->paypal,
                'cloud'         => $request->cloud,
                'social'        => $request->social,
                'otherapi'      => $request->otherapi,
                'stage'         => $request->stage,
            ]);
        }
        $project = ProjectAttribute::where('instance_id', $detail->id)->first();
        if ($project != null) {
            ProjectAttribute::where('instance_id', $projectType->id)->update($feature);
            $attributes = $project->id;
        } else {
            $attribute = ProjectAttribute::create($feature);
            $attributes = $attribute->id;
        }
        if ($request->stage == 1) {
            if ($request->has('attachment')) {
                $attachment = Attachment::where('instance_id', $project->id)->get();
                if ($attachment) {
                    foreach ($attachment as $atc)
                        Attachment::where('id', $atc->id)->delete();
                }
                $files = $request->file('attachment');
                $files = is_array($files) ? $files : [$files];
                foreach ($files as $file) {
                    $input['instance_id'] = $attributes;
                    $input['instance_type'] = 'specification-stage';
                    $input['attachment'] = Storage::putFile('stage', $file);
                    Attachment::create($input);
                }
            }
        }
        if ($request->stage == 2) {
            if ($request->has('design')) {
                $attachment = Attachment::where('instance_id', $project->id)->get();
                if ($attachment) {
                    foreach ($attachment as $atc)
                        Attachment::where('id', $atc->id)->delete();
                }
                $files = $request->file('design');
                $files = is_array($files) ? $files : [$files];
                foreach ($files as $file) {
                    $input['instance_id'] = $attributes;
                    $input['instance_type'] = 'design-stage';
                    $input['attachment'] = Storage::putFile('stage', $file);
                    Attachment::create($input);
                }
            }
        }

        if ($projectType) {
            return redirect(url('description', ['project_id', $request->project_id]));
        }
    }

    public function description(Request $request)
    {

        if ($request->project_id) {
            $valid = $this->projectRepository->verifyProject($request->project_id);
            $email = $this->projectRepository->verifyUser($request->project_id);
            if ($valid == 0) {
                return redirect('');
            }
        }
        $project = $this->projectRepository->findWithoutFail($request->project_id);
        if ($project->status == 0) {
            $description = Description::where('project_id', $request->project_id)->first();
        }
        $exist = Project::where('id', $request->project_id)->first();
        if (isset($email)) {
            $url = url('title', ['email', $email]);
        }
        $project_id = $request->project_id;
        $name = \Request::route()->getName();

        return view('web.home')->with([
            'name'        => $name,
            'project_id'  => $project_id,
            'exist'       => $exist,
            'description' => $description,
            'url'         => $url,
        ]);
    }

    public function descriptionStore(CreateDescriptionRequest $request)
    {
        $input = [];
        $input['details'] = $request->details;
        $input['project_id'] = $request->project_id;
        $descriptions = Description::where('project_id', $request->project_id)->first();
        if ($descriptions) {
            $description = $this->descriptionRepository->updateRecord($input, $descriptions);
        } else {
            $description = $this->descriptionRepository->saveRecord($input);
        }
        if ($request->has('attachment')) {
            $attachment = Attachment::where('instance_id', $description->id)->get();

            if ($attachment) {
                foreach ($attachment as $atc)
                    Attachment::where('id', $atc->id)->delete();
            }
            $files = $request->file('attachment');
            $files = is_array($files) ? $files : [$files];
            foreach ($files as $file) {
                $input['instance_id'] = $description->id;
                $input['instance_type'] = 'descriptionImage';
                $input['filename'] = $file->getClientOriginalName();
                $input['attachment'] = Storage::putFile('description', $file);
                Attachment::create($input);
            }
        }
        if ($description) {
            return redirect(url('question', ['project_id', $description->project_id]));
        }
    }


    public function question(Request $request)
    {
        if ($request->project_id) {
            $valid = $this->projectRepository->verifyProject($request->project_id);
            $email = $this->projectRepository->verifyUser($request->project_id);
            if ($valid == 0) {
                return redirect('');
            }
        } else {
            return redirect('');
        }
        if (isset($email)) {
            $url = url('title', ['email', $email]);
        }
        $question = $this->questionRepository->findWhere(['project_id' => $request->project_id])->first();
        $exist = Project::where('id', $request->project_id)->first();
        $project_id = $request->project_id;
        $expertise = Expertise::all()->pluck('name', 'id');
        $name = \Request::route()->getName();
        if (isset($email)) {
            $url = url('title', ['email', $email]);
        }
        return view('web.home')->with([
            'name'       => $name,
            'project_id' => $project_id,
            'url'        => $url,
            'exist'      => $exist,
        ]);
    }

    public function questionStore(CreateQuestionRequest $request)
    {
        if ($request->expertise) {
            foreach ($request->expertise as $exp) {
                $input ['expertise_id'] = $exp;
                $input ['project_id'] = $request->project_id;
//                dd($exp, $request->project_id);
                $existingExp = ProjectExpertise::where(['expertise_id' => $exp, 'project_id' => $request->project_id])->first();

                if ($existingExp != null) {
                    $expertise = ProjectExpertise::where('id', $existingExp->id)->update($input);
                } else {
                    $expertise = ProjectExpertise::create($input);
                }
            }
        }

        return redirect(url('budget', ['project_id', $request->project_id]));


        $input = [];
        foreach ($request->question as $question) {
            $input['question'] = $question;
            $input['project_id'] = $request->project_id;
            $question = $this->questionRepository->saveRecord($input);
        }
        if ($question) {
            return redirect(url('expertise', ['project_id', $request->project_id]));
        }

    }

    public function expertise(Request $request)
    {
        if ($request->project_id) {
            $valid = $this->projectRepository->verifyProject($request->project_id);
            $email = $this->projectRepository->verifyUser($request->project_id);
            if ($valid == 0) {
                return redirect('');
            }
        } else {
            return redirect('');
        }
        $exist = Project::where('id', $request->project_id)->first();
        $project_id = $request->project_id;
        $expertise = Expertise::all()->pluck('name', 'id');
        $name = \Request::route()->getName();
        if (isset($email)) {
            $url = url('title', ['email', $email]);
        }
        return view('web.home')->with([
            'name'       => $name,
            'project_id' => $project_id,
            'expertise'  => $expertise,
            'url'        => $url,
            'exist'      => $exist,
        ]);
    }

    public function expertiseStore(Request $request)
    {
        if ($request->expertise) {
            foreach ($request->expertise as $exp) {
                $input ['expertise_id'] = $exp;
                $input ['project_id'] = $request->project_id;
//                dd($exp, $request->project_id);
                $existingExp = ProjectExpertise::where(['expertise_id' => $exp, 'project_id' => $request->project_id])->first();

                if ($existingExp != null) {
                    $expertise = ProjectExpertise::where('id', $existingExp->id)->update($input);
                } else {
                    $expertise = ProjectExpertise::create($input);
                }
            }
        }

        return redirect(url('budget', ['project_id', $request->project_id]));


    }

    public function budget(Request $request)
    {

        if ($request->project_id) {
            $valid = $this->projectRepository->verifyProject($request->project_id);
            $email = $this->projectRepository->verifyUser($request->project_id);
            if ($valid == 0) {
                return redirect('');
            }
        } else {
            return redirect('');
        }
        $budget = $this->budgetRepository->findWhere(['project_id' => $request->project_id])->first();
        if ($budget != null) {
            $attributes = ProjectAttribute::where('instance_id', $budget->id)->first();
            if ($attributes) {
                $content = json_decode($attributes->content);
            } else {
                $content = null;
            }
        } else {
            $budget = null;
            $attributes = null;
            $content = null;
        }
        if (isset($email)) {
            $url = url('title', ['email', $email]);
        }
        $exist = Project::where('id', $request->project_id)->first();
        $project_id = $request->project_id;
        $name = \Request::route()->getName();
        return view('web.home')->with([
            'name'       => $name,
            'project_id' => $project_id,
            'budget'     => $budget,
            'attributes' => $attributes,
            'content'    => $content,
            'url'        => $url,
            'exist'      => $exist,
        ]);
    }

    public function budgetStore(Request $request)
    {
        if ($request->project_id) {
            $valid = $this->projectRepository->verifyProject($request->project_id);
            if ($valid == 0) {
                return redirect('');
            }
        } else {
            return redirect('');
        }
        $validatedData = $request->validate([
            'type'  => 'required',
            'time'  => 'required',
            'stage' => 'required',
        ], [
            'type.required'  => 'Type is required',
            'time.required'  => 'Time Requirement is required',
            'stage.required' => 'Expected is required',
        ]);

        $input = [];
        $feature = [];
        $input['project_id'] = intval($request->project_id);
        $input['type'] = intval($request->type);
        $bud = Budget::where('project_id', $request->project_id)->first();
        if ($bud == null) {
            $budget = $this->budgetRepository->saveRecord($input);
            $bud = $budget;
        } else {
            $budget = $this->budgetRepository->updateRecord($input, $bud);
        }
        if ($request->type == Budget::HOUR) {
            $validatedData = $request->validate([
                'experience' => 'required',
            ], [
                'experience.required' => 'Experience is required',
            ]);
            $feature['instance_id'] = $budget->id;
            $feature['instance_type'] = 'Hour';
            $feature['content'] = json_encode([
                'experience' => $request->experience,
                'stage'      => $request->stage,
                'time'       => $request->time,
            ]);
        }
        if ($request->type == Budget::FIXED) {
            $validatedData = $request->validate([
                'amount' => 'required',
            ], [
                'amount.required' => 'Amount is required',
            ]);
            $feature['instance_id'] = $budget->id;
            $feature['instance_type'] = 'Fixed';
            $feature['content'] = json_encode([
                'stage'  => $request->stage,
                'amount' => $request->amount,
                'time'   => $request->time,
            ]);
        }

        if ($request->type == Budget::NOTSURE) {
            $feature['instance_id'] = $budget->id;
            $feature['instance_type'] = 'NotSure';
            $feature['content'] = json_encode([
                'stage' => $request->stage,
                'time'  => $request->time,
            ]);
        }
        $project = ProjectAttribute::where('instance_id', $bud->id)->first();
        if ($project != null) {
            ProjectAttribute::where('id', $project->id)->update($feature);
            $attributes = $project->id;
        } else {
            $attribute = ProjectAttribute::create($feature);
            $attributes = $attribute->id;
        }
        if ($budget) {
            return redirect(url('review', ['project_id', $request->project_id]));
        }
    }

    public function review(Request $request)
    {
        if ($request->project_id) {
            $valid = $this->projectRepository->verifyProject($request->project_id);
            $email = $this->projectRepository->verifyUser($request->project_id);
            if ($valid == 0) {
                return redirect('');
            }
        } else {
            return redirect('');
        }

        $project_id = $request->project_id;
        $project = Project::where('id', $project_id)->first();
        if (isset($project->project_type->project_attributes->content)) {
            $attributes = json_decode($project->project_type->project_attributes->content);
        } else {
            $attributes = null;
        }
        //dd($project->project_type->project_attributes->content);
        if (isset($project->project_type->type)) {
            if ($project->project_type->type == 1) {
                $describe = $this->projectTypeRepository->projecttype($attributes);
            } elseif ($project->project_type->type == 2) {
                $describe = $this->projectTypeRepository->projectwork($attributes);
            } else {
                $describe = '';
            }
        } else {
            $describe = null;
        }
        if ($attributes != null) {
            $api = $this->projectTypeRepository->api($attributes);

            if ($request->stage !== 2) {
                $stage = $this->projectTypeRepository->stage($attributes);
            } else {
                $stage = '';
            }
        } else {
            $api = null;
            $stage = null;
        }
        $exist = Project::where('id', $request->project_id)->first();
        if (isset($project->budget->budget_attributes->content)) {
            $budget = json_decode($project->budget->budget_attributes->content);
        } else {
            $budget = null;
        }
        $name = \Request::route()->getName();
        if (isset($email)) {
            $url = url('title', ['email', $email]);
        }

        return view('web.home')->with([
            'name'       => $name,
            'project_id' => $project_id,
            'project'    => $project,
            'describe'   => $describe,
            'api'        => $api,
            'stage'      => $stage,
            'budget'     => $budget,
            'url'        => $url,
            'exist'      => $exist,
        ]);
    }

    public function reviewStore(Request $request)
    {
        if ($request->project_id) {
            $valid = $this->projectRepository->verifyProject($request->project_id);
            if ($valid == 0) {
                return redirect('');
            }
        } else {
            return redirect('');
        }
        $input['status'] = 1;
        $project_id = $request->project_id;
        $project = Project::where('id', $project_id)->first();
        $attributes = json_decode($project->project_type->project_attributes->content);
        if ($project->project_type->type == 1) {
            $describe = $this->projectTypeRepository->projecttype($attributes);
        } elseif ($project->project_type->type == 2) {
            $describe = $this->projectTypeRepository->projectwork($attributes);
        } else {
            $describe = '';
        }
        $api = $this->projectTypeRepository->api($attributes);
        if ($request->stage !== 2) {
            $stage = $this->projectTypeRepository->stage($attributes);
        } else {
            $stage = '';
        }
        $exist = Project::where('id', $request->project_id)->first();
        $budget = json_decode($project->budget->budget_attributes->content);

        $email = 'farhad@masology.net';
        $subject = 'Email Verification';
        //$project = $request->project_id;
        Mail::send('email.review', [
            'name'     => $email,
            'project'  => $project,
            'describe' => $describe,
            'api'      => $api,
            'stage'    => $stage,
            'budget'   => $budget,
        ],
            function ($mail) use ($email, $subject) {
                $mail->from(getenv('MAIL_FROM_ADDRESS'), getenv('APP_NAME'));
                $mail->to($email);
                $mail->subject($subject);
            });

        $reviews = $this->projectRepository->updateRecord($input, $request->project_id);
        if ($reviews) {
            return redirect('thanks');
        }
    }

    public function thanks()
    {
        $message = 'Thanks for reaching us our representative will contact you soon, To assist you.';
        $name = \Request::route()->getName();
        return view('web.home')->with([
            'name'    => $name,
            'message' => $message,
        ]);
    }


    public function reviews(Request $request)
    {
        if ($request->project_id) {
            $valid = $this->projectRepository->verifyProject($request->project_id);
            $email = $this->projectRepository->verifyUser($request->project_id);
            if ($valid == 0) {
                return redirect('');
            }
        } else {
            return redirect('');
        }

        $project_id = $request->project_id;
        $project = Project::where('id', $project_id)->first();
        if (isset($project->project_type->project_attributes->content)) {
            $attributes = json_decode($project->project_type->project_attributes->content);
        } else {
            $attributes = null;
        }
        //dd($project->project_type->project_attributes->content);
        if (isset($project->project_type->type)) {
            if ($project->project_type->type == 1) {
                $describe = $this->projectTypeRepository->projecttype($attributes);
            } elseif ($project->project_type->type == 2) {
                $describe = $this->projectTypeRepository->projectwork($attributes);
            } else {
                $describe = '';
            }
        } else {
            $describe = null;
        }
        if ($attributes != null) {
            $api = $this->projectTypeRepository->api($attributes);

            if ($request->stage !== 2) {
                $stage = $this->projectTypeRepository->stage($attributes);
            } else {
                $stage = '';
            }
        } else {
            $api = null;
            $stage = null;
        }
        $exist = Project::where('id', $request->project_id)->first();
        if (isset($project->budget->budget_attributes->content)) {
            $budget = json_decode($project->budget->budget_attributes->content);
        } else {
            $budget = null;
        }
        $name = \Request::route()->getName();
        if (isset($email)) {
            $url = url('title', ['email', $email]);
        }

        return view('web.home')->with([
            'name'       => $name,
            'project_id' => $project_id,
            'project'    => $project,
            'describe'   => $describe,
            'api'        => $api,
            'stage'      => $stage,
            'budget'     => $budget,
            'url'        => $url,
            'exist'      => $exist,
        ]);
    }
}
