<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateContactUsAPIRequest;
use App\Http\Requests\Api\UpdateContactUsAPIRequest;
use App\Models\Career;
use App\Models\ContactUs;
use App\Repositories\Admin\ContactUsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Mail\ContactUsMail;
use Illuminate\Support\Facades\Response as FacadesResponse;

/**
 * Class ContactUsController
 * @package App\Http\Controllers\Api
 */
class ContactUsAPIController extends AppBaseController
{
    /** @var  ContactUsRepository */
    private $contactUsRepository;

    public function __construct(ContactUsRepository $contactUsRepo)
    {
        $this->contactUsRepository = $contactUsRepo;
    }

    /**
     * @param Request $request
     * @return Response
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @SWG\Get(
     *      path="/contactus",
     *      summary="Get a listing of the contactus.",
     *      tags={"ContactUs"},
     *      description="Get all contactus",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      @SWG\Parameter(
     *          name="limit",
     *          description="Change the Default Record Count. If not found, Returns All Records in DB.",
     *          type="integer",
     *          required=false,
     *          in="query"
     *      ),
     *     @SWG\Parameter(
     *          name="offset",
     *          description="Change the Default Offset of the Query. If not found, 0 will be used.",
     *          type="integer",
     *          required=false,
     *          in="query"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/ContactUs")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $this->contactUsRepository->pushCriteria(new RequestCriteria($request));
        $this->contactUsRepository->pushCriteria(new LimitOffsetCriteria($request));
        $contactus = $this->contactUsRepository->all();

        return $this->sendResponse($contactus->toArray(), 'Contact Us retrieved successfully');
    }

    /**
     * @param CreateContactUsAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/contactus",
     *      summary="Store a newly created ContactUs in storage",
     *      tags={"ContactUs"},
     *      description="Store ContactUs",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ContactUs that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ContactUs")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/ContactUs"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(Request $request)
    {
        $name = $request->tname;
        $useremail = $request->temail;
        $phone = $request->tphone;
        $skype = $request->tskype;
        $services = $request->services;
        $budget = $request->projectbudget;
        $msg = $request->tmsg;


        $email = 'info@itsolution24x7.com';
        $subject = 'New Inquiry';
        //$project = $request->project_id;
        $mail = Mail::send('email.quote', [
            'name'     => $name,
            'email'    => $useremail,
            'phone'    => $phone,
            'skype'    => $skype,
            'services' => $services,
            'budget'   => $budget,
            'msg'      => $msg,
        ],
            function ($mail) use ($email, $subject) {
                $mail->from(getenv('MAIL_FROM_ADDRESS'), getenv('APP_NAME'));
                $mail->to($email);
                $mail->subject($subject);
            });

        if ($mail) {
            return redirect('https://itsolution24x7.com/thank-you');
        } else {
            return redirect('https://itsolution24x7.com/thank-you');
        }
        // $request->all();

        $contactus = $this->contactUsRepository->saveRecord($request);
        return $this->sendResponse($contactus->toArray(), 'Contact Us saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/contactus/{id}",
     *      summary="Display the specified ContactUs",
     *      tags={"ContactUs"},
     *      description="Get ContactUs",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ContactUs",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/ContactUs"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        $contactUs = $this->contactUsRepository->findWithoutFail($id);
        if (empty($contactUs)) {
            return $this->sendError('Contact Us not found');
        }

        return $this->sendResponse($contactUs->toArray(), 'Contact Us retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateContactUsAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/contactus/{id}",
     *      summary="Update the specified ContactUs in storage",
     *      tags={"ContactUs"},
     *      description="Update ContactUs",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ContactUs",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ContactUs that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ContactUs")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/ContactUs"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateContactUsAPIRequest $request)
    {
        /** @var ContactUs $contactUs */
        $contactUs = $this->contactUsRepository->findWithoutFail($id);
        if (empty($contactUs)) {
            return $this->sendError('Contact Us not found');
        }

        $contactUs = $this->contactUsRepository->updateRecord($request, $id);
        return $this->sendResponse($contactUs->toArray(), 'ContactUs updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/contactus/{id}",
     *      summary="Remove the specified ContactUs from storage",
     *      tags={"ContactUs"},
     *      description="Delete ContactUs",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ContactUs",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        $contactUs = $this->contactUsRepository->findWithoutFail($id);
        if (empty($contactUs)) {
            return $this->sendError('Contact Us not found');
        }

        $this->contactUsRepository->deleteRecord($id);
        return $this->sendResponse($id, 'Contact Us deleted successfully');
    }

    public function popup(Request $request)
    {
        $name = $request->subscribe_name;
        $useremail = $request->subscribe_email;
        $phone = $request->subscribe_phone;
 	    $subject = 'Customer inquiry ticket - Itsolution24x7';
        $mail = Mail::to($useremail)->send(new ContactUsMail($subject));
        $email = ['info@itsolution24x7.com', 'marketing@itsolution24x7.com'];
        $subject = 'Pop up';
        //$project = $request->project_id;
        $mail = Mail::send('email.popup', [
            'name'  => $name,
            'email' => $useremail,
            'phone' => $phone,
        ],
            function ($mail) use ($email, $subject) {
                $mail->from(getenv('MAIL_FROM_ADDRESS'), getenv('APP_NAME'));
                $mail->to($email);
                $mail->subject($subject);
            });

        //if ($mail) {
        //    return redirect('https://itsolution24x7.com/thank-you');
        //} else {
        //    return redirect('https://itsolution24x7.com/thank-you');
        //}
  	
         return redirect('https://itsolution24x7.com/');
      
        
    }

    public function contacts(Request $request)
    {
        $name = $request->contactname;
        $useremail = $request->contactemail;
        $phone = $request->contactphn;
        // $text = $request->contactmsg;
        try{
        	$referer = $request->header()['referer'][0];
        }catch(\Exception $e){
        	$referer = "Browser does not support 'referer' attribute";
        }
        // dd($request); 
        // exit();
        $email = ['info@itsolution24x7.com'];

        $subject = 'From Contacts Us';
        //$project = $request->project_id;
        $mail = Mail::send('email.contacts', [
            'name'      => $name,
            'useremail' => $useremail,
            // 'text'      => $text,
            'phone'      => $phone,
            'come_from'  => $referer,
        ],
            function ($mail) use ($email, $subject) {
                $mail->from(getenv('MAIL_FROM_ADDRESS'), getenv('APP_NAME'));
                $mail->to($email);
                $mail->subject($subject);
            });

        if ($mail) {
            return redirect('https://itsolution24x7.com/thank-you');
        } else {
            return redirect('https://itsolution24x7.com/thank-you');
        }
        // $request->all();

        return $this->sendResponse($contactus->toArray(), 'Contact Us saved successfully');
        // dd($request->header()['referer']);
    }
    
    public function shoppyContact(Request $request)
    {
        $name = $request->tname;
        $useremail = $request->temail;
        $phone = $request->tphone;
        $msg = $request->tmsg;


        $email = 'info@shopifyninja.ca';
        $subject = 'New Inquiry';
        //$project = $request->project_id;
        $mail = Mail::send('email.shoppy_email', [
            'name'     => $name,
            'email'    => $useremail,
            'phone'    => $phone,
            'msg'      => $msg,
        ],
            function ($mail) use ($email, $subject) {
                $mail->from(getenv('MAIL_FROM_ADDRESS'), getenv('APP_NAME'));
                $mail->to($email);
                $mail->subject($subject);
            });

        if ($mail) {
            return redirect('https://www.shopifyninja.ca/thank-you.php');
        } else {
            return redirect('https://www.shopifyninja.ca/thank-you.php');
        }
        // $request->all();

        $contactus = $this->contactUsRepository->saveRecord($request);
        return $this->sendResponse($contactus->toArray(), 'Contact Us saved successfully');
    }

 
    public function shoppyContact2(Request $request)
    {
        $name = $request->tname;
        $useremail = $request->temail;
        $comment = $request->tcomment;
       

        $email = 'info@shopifyninja.ca';
        // $email = 'info@itsolution24x7.com';
        $subject = 'New Contact';
        //$project = $request->project_id;
        $mail = Mail::send('email.shoppy_contact_email', [
            'name'     => $name,
            'email'    => $useremail,
            'comment'    => $comment,
        ],
            function ($mail) use ($email, $subject) {
                $mail->from(getenv('MAIL_FROM_ADDRESS'), getenv('APP_NAME'));
                $mail->to($email);
                $mail->subject($subject);
            });

        if ($mail) {
            return redirect('https://www.shopifyninja.ca/thank-you.php');
        } else {
            return redirect('https://www.shopifyninja.ca/thank-you.php');
        }
        // $request->all();

        // $contactus = $this->contactUsRepository->saveRecord($request);
        // return $this->sendResponse($contactus->toArray(), 'Contact Us saved successfully');
    }
    public function contactForPkg(Request $request)
    {
        $name = $request->contactname;
        $useremail = $request->contactemail;
        $phone = $request->contactphn;
        $pkg = $request->contactpkg;
        $referer = $request->header()['referer'][0];
        $email = ['info@itsolution24x7.com', 'marketing@itsolution24x7.com'];
  
        $subject = 'From Contacts Us';
        //$project = $request->project_id;
        $mail = Mail::send('email.contact_pkg', [
            'name'      => $name,
            'useremail' => $useremail,
            'pkg'      => $pkg,
            'phone'      => $phone,
            'come_from'  => $referer,
        ],
            function ($mail) use ($email, $subject) {
                $mail->from(getenv('MAIL_FROM_ADDRESS'), getenv('APP_NAME'));
                $mail->to($email);
                $mail->subject($subject);
            });

        if ($mail) {
            return redirect('https://itsolution24x7.com/thank-you');
        } else {
            return redirect('https://itsolution24x7.com/thank-you');
        }
        // $request->all();

        return $this->sendResponse($contactus->toArray(), 'Contact Us saved successfully');
        // dd($request->header()['referer']);
    }
    public function updateTimelogger()
    {
        $status = false;
        return $this->sendResponse($status, 'TimeLogger');
    }

    public function career(Request $request)
    {
        $input = [];
        $files = $request->file('attachment');
        $input['file'] = Storage::putFile('career', $files);
        $career = Career::create($input);
        $path = url('storage/app/' . $career->file);
        $firstname = $request->FirstName;
        $lastname = $request->LastName;
        $useremail = $request->Email;
        $file = $request->attachment;
        $field = $request->Field;
        $phoneNumber = $request->PhoneNumber;

        // $email = ['info@itsolution24x7.com', 'marketing@itsolution24x7.com', 'osama@masology.net'];
        $email = ['careers@itsolution24x7.com'];
        // $subject = 'From Career';
        $subject = $field;
        
        //$project = $request->project_id;
        $mail = Mail::send('email.career', [
            'firstname' => $firstname,
            'lastname'  => $lastname,
            'email'     => $useremail,
            'phoneNumber' => $phoneNumber,
        ],
            function ($mail) use ($file, $email, $subject, $path) {
                $mail->from(getenv('MAIL_FROM_ADDRESS'), getenv('APP_NAME'));
                $mail->to($email);
                $mail->subject($subject);
                $mail->attach($path);
            });

        if ($mail) {
            return redirect('https://itsolution24x7.com/thank-you');
        } else {
            return redirect('https://itsolution24x7.com/thank-you');
        }
        // $request->all();

        return $this->sendResponse($contactus->toArray(), 'Contact Us saved successfully');
    }

    public function ReviewPopup(Request $request)
    {
        $projectname = $request->projectName;
        $clientname = $request->clientName;
        $review = $request->review;
        $starsrating = $request->starsRating;
        $email = ['info@itsolution24x7.com', 'marketing@itsolution24x7.com', 'osama@masology.net'];
        $subject = 'Review Popup';
        //$project = $request->project_id;
        $mail = Mail::send('email.reviewpopup', [
            'projectname' => $projectname,
            'clientname'  => $clientname,
            'review'      => $review,
            'starsrating' => $starsrating,
        ],
            function ($mail) use ($email, $subject) {
                $mail->from(getenv('MAIL_FROM_ADDRESS'), getenv('APP_NAME'));
                $mail->to($email);
                $mail->subject($subject);
            });

        if ($mail) {
            return redirect('https://itsolution24x7.com/ecommerce/thanks');
        } else {
            return redirect('https://itsolution24x7.com/ecommerce/thanks');
        }
    }

    public function ecommercestore(Request $request)
    {
        $name = $request->name;
        $useremail = $request->email;
        $phone = $request->phone;
        $skype = $request->skype;
        $msg = $request->msg;


        $email = ['info@itsolution24x7.com', 'marketing@itsolution24x7.com', 'osama@masology.net'];
        $subject = 'New Inquiry Ecommerce App';
        //$project = $request->project_id;
        $mail = Mail::send('email.ecommercequote', [
            'name'  => $name,
            'email' => $useremail,
            'phone' => $phone,
            'skype' => $skype,
            'msg'   => $msg,
        ],
            function ($mail) use ($email, $subject) {
                $mail->from(getenv('MAIL_FROM_ADDRESS'), getenv('APP_NAME'));
                $mail->to($email);
                $mail->subject($subject);
            });

        if ($mail) {
            return redirect('https://itsolution24x7.com/ecommerce/thanks');
        } else {
            return redirect('https://itsolution24x7.com/ecommerce/thanks');
        }
        // $request->all();

        $contactus = $this->contactUsRepository->saveRecord($request);
        return $this->sendResponse($contactus->toArray(), 'Contact Us saved successfully');
    }
}