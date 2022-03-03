<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\MessageInboxController;

use Illuminate\Support\Facades\Mail;
use App\Mail\sendAnyEmail;
use App\Mail\sendEmailAccountRegistration;

use App\Library\AnyFileUploadClass;
use App\Library\RandomAlphaNumericClass;

use App\Models\ErrorCaughtModel;
use App\Models\User;
use App\Models\UserTypeModel;
use App\Models\UserProfileModel;
use App\Models\IndustryModel;
use App\Models\TermsAndConditionsModel;
use App\Models\CoverLetterModel;
use App\Models\CertificateModel;
use App\Models\EducationModel;
use App\Models\GradeModel;
use App\Models\WorkExperienceModel;
use App\Models\ProfessionalSkillModel;
use App\Models\UploadCVModel;
use App\Models\PostJobModel;
use App\Models\JobTypeModel;
use App\Models\JobApplyModel;
use App\Models\BuildCVRequestModel;
use App\Models\PaymentHistoryModel;
use App\Models\PriceListModel;
use App\Models\BuiltCVByAdminModel;
use App\Models\PaymentTransactionModel;
use App\Models\WalletModel;


use Session;
use Cache;
use Image;
use Auth;
use View;
use DB;



class BaseParentController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
        $this->getAllModel();
    }

    public function redirectToLoginUnAuth()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Your session has expired. You need to login now!.');
        }
        return;
    }


    // all model
    public function getAllModel()
    {
        $this->user                         = new User;
        $this->userTypeModel                = new UserTypeModel;
        $this->userProfileModel             = new UserProfileModel;
        $this->industryModel                = new IndustryModel;
        $this->termsAndConditionsModel      = new TermsAndConditionsModel;
        $this->coverLetterModel             = new CoverLetterModel;
        $this->certificateModel             = new CertificateModel;
        $this->educationModel               = new EducationModel;
        $this->gradeModel                   = new GradeModel;
        $this->workExperienceModel          = new WorkExperienceModel;
        $this->uploadCVModel                = new UploadCVModel;
        $this->postJobModel                 = new PostJobModel;
        $this->jobTypeModel                 = new JobTypeModel;
        $this->professionalSkillModel       = new ProfessionalSkillModel;
        $this->jobApplyModel                = new JobApplyModel;
        $this->buildCVRequestModel          = new BuildCVRequestModel;
        $this->paymentHistoryModel          = new PaymentHistoryModel;
        $this->priceListModel               = new PriceListModel;
        $this->BuiltCVByAdminModel          = new BuiltCVByAdminModel;
        $this->paymentTransactionModel      = new PaymentTransactionModel;
        $this->walletModel                  = new WalletModel;

        return;
    }

    ############### LIVE SEARCH ANY PRODUCT###########
    public function searchProductFromDB($getQuery = null)
    {
        $getAllMatchProducts = array();
        $reservedSymbols = ['<', '>', '@', '(', ')', '~', '|', '/', '{', '}', '[', ']'];
        $searchQuery = preg_split('/\s+/', $getQuery, -1, PREG_SPLIT_NO_EMPTY);
        //$searchQuery = str_replace($reservedSymbols, '', $searchQuery);
        if(!empty($getQuery))
        {
            try{
                //$getQuery = $_GET['term'];
                $getAllMatchProducts = [];/*  ProductModel::query()->where($this->productModel->getTable().'.is_online', 1)->where($this->productModel->getTable().'.admin_status', 1)->where($this->productModel->getTable().'.is_deleted', 0)
                ->leftjoin($this->userProfileModel->getTable(), $this->userProfileModel->getTable().'.userID', '=', $this->productModel->getTable().'.userID')
                ->leftjoin($this->categoryModel->getTable(), $this->categoryModel->getTable().'.categoryID', '=', $this->productModel->getTable().'.categoryID')
                ->select($this->productModel->getTable().'.categoryID', $this->productModel->getTable().'.userID', $this->productModel->getTable().'.productID', $this->categoryModel->getTable().'.category', $this->productModel->getTable().'.product_name', $this->userProfileModel->getTable().'.store_description', $this->userProfileModel->getTable().'.store_name')
                ->orderBy($this->productModel->getTable().'.product_name', 'Asc')
                ->where(function ($query) use ($searchQuery)
                {
                    foreach ($searchQuery as $value)
                    {
                        $query->orWhere($this->categoryModel->getTable().'.category', 'like', "%{$value}%");
                        $query->orWhere($this->userProfileModel->getTable().'.store_name', 'like', "%{$value}%");
                        $query->orWhere($this->userProfileModel->getTable().'.store_description', 'like', "%{$value}%");
                        $query->orWhere($this->productModel->getTable().'.product_name', 'like', "%{$value}%");
                    }
                }) */
                //->take(10)
                //->get();
                return $getAllMatchProducts;
            }catch(\Throwable $errorThrown){
                $this->storeTryCatchError($errorThrown, 'BaseParentController@searchProductFromDB', 'Error occured when trying to search for product/store.');
            }
            return $getAllMatchProducts;
        }else{
             return $getAllMatchProducts;
        }
    }
    ######## END LIVE SEARCH #############

     //Get Product Details or price list
     public function getPriceList($priceID = null)
     {
         $getPrice = null;
        try{
            if($priceID)
            {
                $getPrice = PriceListModel::find($priceID);
            }
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'BaseParentController@getPriceList', 'Error occured when getting price list.' );
        }
         return $getPrice;
     }

     ############################### CREATE PAYMENT HISTORY ##################
     //Create New
     public function createPayment($userID = null, $transactionID = null, $paymentForID = null, $amount = null, $description = null)
     {
        $success = 0;
        try{
            if($userID <> null && $amount <> null)
            {
                $success = PaymentHistoryModel::create([
                    'userID'                    => $userID,
                    'transactionID'             => ($transactionID ? $transactionID : $this->generateRandomAlphaNumeric(20)),
                    'paymentForID'              => $paymentForID,
                    'amount'                    => $amount,
                    'payment_description'       => $description,
                    'created_at'                => date('Y-m-d'),
                    'updated_at'                => date('Y-m-d'),
                    'updated_at_time'           => date('Y-m-d h:i:s a'),
                ]);
            }
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'BaseParentController@createPayment', 'Error occured when creating payment history.' );
        }
        return $success;
     }

    //Update OR Create
    public function createUpdatePayment($transactionID = null, $amountPaid = null, $paymentStatusCode = null, $paymentSuccess = null, $paymentJsonData = null)
    {
         $success = 0;
        try{
            if($transactionID <> null && $amountPaid <> null && $paymentStatusCode <> null)
            {
                $success = PaymentHistoryModel::updateOrCreate(
                    [
                        'transactionID' => $transactionID
                    ],
                    [
                    'amount_paid'               => $amountPaid,
                    'payment_status_code'       => $paymentStatusCode,
                    'payment_success'           => $paymentSuccess,
                    'payment_json_data'         => $paymentJsonData,
                    'updated_at'                => date('Y-m-d'),
                    'updated_at_time'           => date('Y-m-d h:i:s a'),
                    ]
                );
            }
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'BaseParentController@createUpdatePayment', 'Error occured when update payment history.' );
        }
         return $success;
    }
    ############################### END CREATE PAYMENT HISTORY ##################

    //Return Integer - Cache Time - 30Mininutes
    public function appCacheTime($getTime = 1)
    {
        return $getTime;
    }

    //Return String - Get User ID that logs in
    public function getUserID()
    {
        return (Auth::check() ? Auth::user()->id : null);
    }

    //Return String - Get User Token that logs in
    public function getUserToken()
    {
        return (Auth::check() ? Auth::user()->user_token : null);
    }


    //Return String - Get User Token that logs in
    public function getUserPath($folderName = null, $userID = null)
    {
        $userPath = null;
        if($userID)
        {
            $userToken = User::where('id', $userID)->value('user_token');
            $userPath = $this->downloadPath() . $userToken .'/'. $folderName .'/';
        }else{
            $userPath = $this->downloadPath() . $this->getUserToken() .'/'. $folderName .'/';
        }
        return $userPath;
    }


    //GET USER BANNER
    public function getUserBanner($userID = null, $folderName = "profile")
    {
        $bannerPath = null;
        $userID = ($userID ? $userID : $this->getUserID());
        try{
            if($userID <> null)
            {
                $getUserDetails   = UserProfileModel::where('userID', $userID)->first();
                $getAllPaths = $this->getUserPathImage($userID, ($getUserDetails ? $getUserDetails->profile_banner : null), $folderName = $folderName);
                $bannerPath = $getAllPaths['filePathBig'];
            }
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'BaseParentController@getUserBanner', 'Error occured when trying to get user banner.' );
        }
        return $bannerPath;
    }

     //GET USER PROFILE PHOTO
     public function getUserPhoto($userID = null, $folderName = "profile")
     {
         $bannerPath = null;
         $userID = ($userID ? $userID : $this->getUserID());
         try{
             if($userID <> null)
             {
                 $getUserDetails   = UserProfileModel::where('userID', $userID)->first();
                 $getAllPaths = $this->getUserPathImage($userID, ($getUserDetails ? $getUserDetails->profile_picture : null), $folderName = $folderName);
                 $bannerPath = $getAllPaths['filePathbest'];
             }
         }catch(\Throwable $errorThrown){
             $this->storeTryCatchError($errorThrown, 'BaseParentController@getUserPhoto', 'Error occured when trying to get user photo.' );
         }

         return $bannerPath;
     }


    //Get user name
    public function getUserFullName($userID = null)
    {
        $userFullName = null;
        $userID = ($userID ? $userID : $this->getUserID());
        try{
            $getUser = UserProfileModel::where('userID', $userID)
                            ->select(DB::raw('CONCAT(first_name, " ", last_name) as name'))
                            ->value('name');
            $userFullName = ($getUser ? $getUser : 'Administrator');
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'BaseParentController@getUserFullName', 'Error occured when trying to get user full name' );
        }
        return $userFullName;
    }


    //Get All User name
    public function getAllUsers($active = 1)
    {
        $getUser = [];
        try{
            if(Auth::user()->user_type == 1)
            {
                $getUser = UserProfileModel::where($this->user->getTable().'.status', $active)
                        ->join($this->user->getTable(), $this->user->getTable().'.id', '=', $this->userProfileModel->getTable().'.userID')
                        ->select($this->user->getTable().'.id', 'user_role', DB::raw('CONCAT(first_name, " ", last_name) as name'))
                        ->get();
            }else{
                $getUser = UserProfileModel::where($this->user->getTable().'.status', $active)->where('user_role', '>', 1)
                        ->join($this->user->getTable(), $this->user->getTable().'.id', '=', $this->userProfileModel->getTable().'.userID')
                        ->select($this->user->getTable().'.id', 'user_role', DB::raw('CONCAT(first_name, " ", last_name) as name'))
                        ->get();
            }

        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'BaseParentController@getUserFullName', 'Error occured when trying to get user full name' );
        }
        return $getUser;
    }


    //Get user profile
    public function getUserProfile($userID = null)
    {
        $userProfile = null;
        $userID = ($userID ? $userID : $this->getUserID());
        if($userID)
        {
            try{
                $userProfile = UserProfileModel::where($this->userProfileModel->getTable().'.userID', $userID)
                            ->join($this->user->getTable(), $this->user->getTable().'.id', '=', $this->userProfileModel->getTable().'.userID')
                            ->leftjoin($this->userTypeModel->getTable(), $this->userTypeModel->getTable().'.user_typeID', '=', $this->user->getTable().'.user_type')
                            ->leftjoin($this->industryModel->getTable(), $this->industryModel->getTable().'.industryID', '=', $this->userProfileModel->getTable().'.company_industry_id')
                            ->select($this->industryModel->getTable().'.*', $this->userTypeModel->getTable().'.*', $this->userProfileModel->getTable().'.*', $this->user->getTable().'.*', DB::raw('CONCAT(first_name, " ", last_name) as name'))
                            ->first();
            }catch(\Throwable $errorThrown){
                $this->storeTryCatchError($errorThrown, 'BaseParentController@getUserProfile', 'Error occured when trying to get user profile' );
            }
        }
        return $userProfile;
    }


    //Return View - Check view if exist before rendering the view blade
    public function checkViewBeforeRender($getView = null, $data1 = [], $data2 = [], $data3 = [], $data4 = [], $data5 = [])
    {
        if($getView <> null)
        {
            try{
                return (View::exists($getView) ? view($getView, $data1, $data2, $data3, $data4, $data5) : redirect()->route('index'));
            }catch(\Throwable $errorThrown)
            {
                $this->storeTryCatchError($errorThrown, 'BaseParentController@checkViewBeforeRender', 'Error occured when trying to check if view/blade exist before rendering the view/blade.' );
                return redirect()->route('index');
            }
        }else{
            return redirect()->route('index');
        }
    }

    //Return No Value : Void - Store any error that occurred in try-catch block
    public function storeTryCatchError($getError = null, $getFunctionModuleName = null, $errorDescription = null )
    {
        try{
            return ErrorCaughtModel::create([
                'throwable_error'       => ($getError <> null ? $getError : 'No error occured'),
                'function_module_name'  => $getFunctionModuleName,
                'error_description'     => $errorDescription,
                'created_at'            => date('Y-m-d h:i:sa'),
                'updated_at'            => date('Y-m-d h:i:sa')
            ]);
        }catch(\Throwable $errorThrown){}
    }

    //Return Array of String/Numeric - Reuseable Image File Upload Module
    public function uploadAnyFile($file = null, $uploadCompletePathName = null, $maxFileSize = 10, $newExtension = null, $newRadFileName = true)
    {
         $data = new AnyFileUploadClass($file, $uploadCompletePathName, $maxFileSize, $newExtension, $newRadFileName);
         return $data->return();
     }//end function


     //Return String - Reuseable Random AlphaNumeric  Module
    public function generateRandomAlphaNumeric($getLength = 10)
    {
         $data = new RandomAlphaNumericClass($getLength);
         return $data->return();
     }//end function


     //Return String - Upload Path
     public function uploadPath()
     {
        return $this->getUploadPath = env('UPLOADPATHROOT', null) . $this->getUserToken() .'/';
     }

    //Return String - Download Path
    public function downloadPath()
    {
        return $this->getDownloadPath = env('DOWNLOADPATHROOT', null);
    }

    //Return Month of array
    public function monthArrayString()
    {
        $months = array(
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July ',
            'August',
            'September',
            'October',
            'November',
            'December',
        );

        return $months;
    }


    //Get User path image
    public function getUserPathImage($userID = null, $file = null, $folderName = null)
    {
        $data['filePathbest']       = null;
        $data['filePath300x300']    = null;
        $data['filePath500x500']    = null;
        $data['filePathBig']        = null;
        if($userID <> null)
        {
            try{
                $userToken = User::where('id', $userID)->value('user_token');
                $getImageAndPath300x300     = ($userToken ? $userToken : null) .'/'. $folderName .'/300x300'. '/'. $file;
                $getImageAndPath500x500     = ($userToken ? $userToken : null) .'/'. $folderName .'/500x350'. '/'. $file;
                $getImageAndPath            = ($userToken ? $userToken : null) .'/'. $folderName .'/'. $file;
                if(@getimagesize($getImageAndPath300x300))
                {
                    $data['filePathbest'] = $this->downloadPath() . $getImageAndPath300x300;
                }elseif(@getimagesize($getImageAndPath500x500)){
                    $data['filePathbest'] = $this->downloadPath() . $getImageAndPath500x500;
                }else{
                    $data['filePathbest'] = $this->downloadPath() . $getImageAndPath;
                }
                $data['filePath300x300']    = $this->downloadPath() . $getImageAndPath300x300;
                $data['filePath500x500']    = $this->downloadPath() . $getImageAndPath500x500;
                $data['filePathBig']        = $this->downloadPath() . $getImageAndPath;
            }catch(\Throwable $errorThrown)
            {
               $this->storeTryCatchError($errorThrown, 'BaseParentController@getUserPathImage', 'Error occured when trying to get file path.');
            }
        }
        return $data;
    }

    //Return Numeric Value - Remove comma from string
    public function removeCommaFromString($getString = null)
    {
        $numericString = 0;
        try{
            if($getString != null || $getString != 0)
            {
                $stringWithNoComma = str_replace( ',', '', $getString );

                if( is_numeric( $stringWithNoComma) ) {
                    $numericString = $stringWithNoComma;
                }else{
                    $numericString = (int)$stringWithNoComma;
                }
            }else{
                $numericString = $getString;
            }
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'BaseParentController@removeCommaFromString', 'Error occured when trying to remove comma from string' );
        }
        return $numericString;
    }

    //Return Nothing : Void - Create Image Thumbnail after upload the image to a path
    public function createThumbnail($pathSource = null, $pathDestination = null, $width = 300, $height = 300, $is_resize_canvas = 1)
    {
        if($pathDestination != null)
        {
            try{
                //copy file
                ($pathSource ? copy($pathSource, $pathDestination) : null);

                //Resize Image with canvas
                $img = Image::make($pathDestination)->resize(($width - (($is_resize_canvas ? $width/4 : 0))), ($height - (($is_resize_canvas ? $width/4 : 0))), function ($constraint) {
                    $constraint->aspectRatio();
                })->resizeCanvas($width, $height, 'center', false, '#ffffff');

                $img->save($pathDestination);

            }catch(\Throwable $errorThrown){
                $this->storeTryCatchError($errorThrown, 'BaseParentController@createThumbnail', 'Error occured when trying to create image thumbnail' );
            }
        }
        return;
    }

    public function getSingleJob($jobID = null)
    {
        $jobDetails = null;
        try{
            $jobDetails = PostJobModel::where($this->postJobModel->getTable().'.jobID', $jobID)
                    ->leftJoin($this->userProfileModel->getTable(), $this->userProfileModel->getTable().'.userID', '=', $this->postJobModel->getTable().'.userID')
                    ->leftJoin($this->industryModel->getTable(), $this->industryModel->getTable().'.industryID', '=', $this->postJobModel->getTable().'.job_category')
                    ->leftJoin($this->jobTypeModel->getTable(), $this->jobTypeModel->getTable().'.job_typeID', '=', $this->postJobModel->getTable().'.job_type')
                    ->first();
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'BaseParentController@getSingleJob', 'Error occured when trying to get single job.' );
        }
        return $jobDetails;
    }


    //Get user that applied for job
    public function getCandidateProfileForJob($jobID = null)
    {
        $candidateProfile = [];
        if($jobID)
        {
            try{
                $candidateProfile = JobApplyModel::where($this->jobApplyModel->getTable().'.jobID', $jobID)
                            ->join($this->uploadCVModel->getTable(), $this->uploadCVModel->getTable().'.candidate_cvID', '=', $this->jobApplyModel->getTable().'.cvID')
                            ->join($this->userProfileModel->getTable(), $this->userProfileModel->getTable().'.userID', '=', $this->jobApplyModel->getTable().'.candidateID')
                            ->join($this->user->getTable(), $this->user->getTable().'.id', '=', $this->userProfileModel->getTable().'.userID')
                            ->leftjoin($this->userTypeModel->getTable(), $this->userTypeModel->getTable().'.user_typeID', '=', $this->user->getTable().'.user_type')
                            ->leftjoin($this->industryModel->getTable(), $this->industryModel->getTable().'.industryID', '=', $this->userProfileModel->getTable().'.company_industry_id')
                            ->select($this->jobApplyModel->getTable().'.*', $this->uploadCVModel->getTable().'.*', $this->industryModel->getTable().'.*', $this->userTypeModel->getTable().'.*', $this->userProfileModel->getTable().'.*', $this->user->getTable().'.*', DB::raw('CONCAT(first_name, " ", last_name) as name'))
                            ->get();

            }catch(\Throwable $errorThrown){
                $this->storeTryCatchError($errorThrown, 'BaseParentController@getCandidateProfileForJob', 'Error occured when getting all candate that apply for job.' );
            }
        }
        return $candidateProfile;
    }


    ######## GET ALL COMPANY ##########
    public function getAllCompany($status = 'all', $pagination = 100)
    {
        $data                   = [];
        $data['getAllCompany']  = [];
        $getCompanyLogo             = [];
        try{
            if($status == 'all')
            {
                if(is_numeric($pagination) && $pagination > 0)
                {
                    $data['getAllCompany']  = UserProfileModel::orderBy('.user_profileID', 'Asc')->paginate($pagination);
                }else{
                    $data['getAllCompany']  = UserProfileModel::orderBy('.user_profileID', 'Asc')->get();
                }
            }else{
                if(is_numeric($pagination) && $pagination > 0)
                {
                    $data['getAllCompany']  = UserProfileModel::where('status', $status)->orderBy('.user_profileID', 'Asc')->paginate($pagination);
                }else{
                    $data['getAllCompany']  = UserProfileModel::where('status', $status)->orderBy('.user_profileID', 'Asc')->get();
                }
            }
            if($data['getAllCompany'])
            {
                foreach($data['getAllCompany'] as $key=>$value)
                {
                    $getLogo                  = $this->getUserPathImage($value->userID, $value->profile_picture, 'profile');
                    $getCompanyLogo[$key]         = $getLogo['filePathbest'];
                }
            }
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'BaseParentController@getAllCompany', 'Error occured when getting all companies.' );
        }
        $data['getCompanyLogo']         = $getCompanyLogo;
        return $data;
    }




    ######## GET ALL JOB POSTED WITH TOTAL APPLICATION, SHORTLISTED AND REJECTED ##########
    public function searchForJob($pagination = 100, $category = null, $location = null, $salary = null, $jobType = null, $datePoster = null)
    {
        $data                   = [];
        $data['getPostedJob']   = [];
        $totalApplication       = [];
        $totalShortlisted       = [];
        $totalRejected          = [];
        $getJobLogo             = [];

        //salary range for search
        if($salary <> null)
        {
            $salaryRange            = explode(',', $salary);
            $salaryPrice            = [$salaryRange[0], $salaryRange[1]];
        }

        try{

            if($category == null && $location == null && $salary == null && $jobType == null && $datePoster == null)
            {
                $data['getPostedJob']   = PostJobModel::where($this->postJobModel->getTable().'.status', 1)
                        ->leftJoin($this->userProfileModel->getTable(), $this->userProfileModel->getTable().'.userID', '=', $this->postJobModel->getTable().'.userID')
                        ->leftJoin($this->industryModel->getTable(), $this->industryModel->getTable().'.industryID', '=', $this->postJobModel->getTable().'.job_category')
                        ->leftJoin($this->jobTypeModel->getTable(), $this->jobTypeModel->getTable().'.job_typeID', '=', $this->postJobModel->getTable().'.job_type')
                        ->orderBy($this->postJobModel->getTable().'.updated_at_time', 'desc')
                        ->paginate($pagination);
            }else
            {
                if($category <> null && $location == null && $salary == null && $jobType == null && $datePoster == null)
                {
                    $data['getPostedJob']   = PostJobModel::where($this->postJobModel->getTable().'.status', 1)
                        ->leftJoin($this->userProfileModel->getTable(), $this->userProfileModel->getTable().'.userID', '=', $this->postJobModel->getTable().'.userID')
                        ->leftJoin($this->industryModel->getTable(), $this->industryModel->getTable().'.industryID', '=', $this->postJobModel->getTable().'.job_category')
                        ->leftJoin($this->jobTypeModel->getTable(), $this->jobTypeModel->getTable().'.job_typeID', '=', $this->postJobModel->getTable().'.job_type')
                        ->orderBy($this->postJobModel->getTable().'.updated_at_time', 'desc')
                        ->where($this->postJobModel->getTable().'.job_category', $category)
                        ->paginate($pagination);
                }elseif($category == null && $location <> null && $salary == null && $jobType == null && $datePoster == null)
                {
                    $data['getPostedJob']   = PostJobModel::where($this->postJobModel->getTable().'.status', 1)
                        ->leftJoin($this->userProfileModel->getTable(), $this->userProfileModel->getTable().'.userID', '=', $this->postJobModel->getTable().'.userID')
                        ->leftJoin($this->industryModel->getTable(), $this->industryModel->getTable().'.industryID', '=', $this->postJobModel->getTable().'.job_category')
                        ->leftJoin($this->jobTypeModel->getTable(), $this->jobTypeModel->getTable().'.job_typeID', '=', $this->postJobModel->getTable().'.job_type')
                        ->orderBy($this->postJobModel->getTable().'.updated_at_time', 'desc')
                        ->Where($this->postJobModel->getTable().'.job_location', $location)
                        ->paginate($pagination);
                }elseif($category == null && $location == null && $salary <> null && $jobType == null && $datePoster == null)
                {
                    $data['getPostedJob']   = PostJobModel::where($this->postJobModel->getTable().'.status', 1)
                        ->leftJoin($this->userProfileModel->getTable(), $this->userProfileModel->getTable().'.userID', '=', $this->postJobModel->getTable().'.userID')
                        ->leftJoin($this->industryModel->getTable(), $this->industryModel->getTable().'.industryID', '=', $this->postJobModel->getTable().'.job_category')
                        ->leftJoin($this->jobTypeModel->getTable(), $this->jobTypeModel->getTable().'.job_typeID', '=', $this->postJobModel->getTable().'.job_type')
                        ->orderBy($this->postJobModel->getTable().'.updated_at_time', 'desc')
                        ->whereBetween($this->postJobModel->getTable().'.job_salary', $salaryPrice)
                        ->paginate($pagination);
                }elseif($category == null && $location <> null && $salary <> null && $jobType == null && $datePoster == null)
                {
                    $data['getPostedJob']   = PostJobModel::where($this->postJobModel->getTable().'.status', 1)
                        ->leftJoin($this->userProfileModel->getTable(), $this->userProfileModel->getTable().'.userID', '=', $this->postJobModel->getTable().'.userID')
                        ->leftJoin($this->industryModel->getTable(), $this->industryModel->getTable().'.industryID', '=', $this->postJobModel->getTable().'.job_category')
                        ->leftJoin($this->jobTypeModel->getTable(), $this->jobTypeModel->getTable().'.job_typeID', '=', $this->postJobModel->getTable().'.job_type')
                        ->orderBy($this->postJobModel->getTable().'.updated_at_time', 'desc')
                        ->whereBetween($this->postJobModel->getTable().'.job_salary', $salaryPrice)
                        ->Where($this->postJobModel->getTable().'.job_location',  $location)
                        ->paginate($pagination);
                }elseif($category <> null && $location <> null && $salary == null && $jobType == null && $datePoster == null)
                {
                    $data['getPostedJob']   = PostJobModel::where($this->postJobModel->getTable().'.status', 1)
                        ->leftJoin($this->userProfileModel->getTable(), $this->userProfileModel->getTable().'.userID', '=', $this->postJobModel->getTable().'.userID')
                        ->leftJoin($this->industryModel->getTable(), $this->industryModel->getTable().'.industryID', '=', $this->postJobModel->getTable().'.job_category')
                        ->leftJoin($this->jobTypeModel->getTable(), $this->jobTypeModel->getTable().'.job_typeID', '=', $this->postJobModel->getTable().'.job_type')
                        ->orderBy($this->postJobModel->getTable().'.updated_at_time', 'desc')
                        ->where($this->postJobModel->getTable().'.job_category', $category)
                        ->Where($this->postJobModel->getTable().'.job_location',  $location)
                        ->paginate($pagination);
                }elseif($category <> null && $location <> null && $salary == null && $jobType <> null && $datePoster == null)
                {
                    $data['getPostedJob']   = PostJobModel::where($this->postJobModel->getTable().'.status', 1)
                        ->leftJoin($this->userProfileModel->getTable(), $this->userProfileModel->getTable().'.userID', '=', $this->postJobModel->getTable().'.userID')
                        ->leftJoin($this->industryModel->getTable(), $this->industryModel->getTable().'.industryID', '=', $this->postJobModel->getTable().'.job_category')
                        ->leftJoin($this->jobTypeModel->getTable(), $this->jobTypeModel->getTable().'.job_typeID', '=', $this->postJobModel->getTable().'.job_type')
                        ->orderBy($this->postJobModel->getTable().'.updated_at_time', 'desc')
                        ->where($this->postJobModel->getTable().'.job_category', $category)
                        ->Where($this->postJobModel->getTable().'.job_location',  $location)
                        ->Where($this->postJobModel->getTable().'.job_type', $jobType)
                        ->paginate($pagination);
                }elseif($category <> null && $location <> null && $salary <> null && $jobType == null && $datePoster == null)
                {
                    $data['getPostedJob']   = PostJobModel::where($this->postJobModel->getTable().'.status', 1)
                        ->leftJoin($this->userProfileModel->getTable(), $this->userProfileModel->getTable().'.userID', '=', $this->postJobModel->getTable().'.userID')
                        ->leftJoin($this->industryModel->getTable(), $this->industryModel->getTable().'.industryID', '=', $this->postJobModel->getTable().'.job_category')
                        ->leftJoin($this->jobTypeModel->getTable(), $this->jobTypeModel->getTable().'.job_typeID', '=', $this->postJobModel->getTable().'.job_type')
                        ->orderBy($this->postJobModel->getTable().'.updated_at_time', 'desc')
                        ->where($this->postJobModel->getTable().'.job_category', $category)
                        ->Where($this->postJobModel->getTable().'.job_location',  $location)
                        ->whereBetween($this->postJobModel->getTable().'.job_salary', $salaryPrice)
                        ->paginate($pagination);
                }elseif($category <> null && $location <> null && $salary <> null && $jobType <> null && $datePoster == null)
                {
                    $data['getPostedJob']   = PostJobModel::where($this->postJobModel->getTable().'.status', 1)
                        ->leftJoin($this->userProfileModel->getTable(), $this->userProfileModel->getTable().'.userID', '=', $this->postJobModel->getTable().'.userID')
                        ->leftJoin($this->industryModel->getTable(), $this->industryModel->getTable().'.industryID', '=', $this->postJobModel->getTable().'.job_category')
                        ->leftJoin($this->jobTypeModel->getTable(), $this->jobTypeModel->getTable().'.job_typeID', '=', $this->postJobModel->getTable().'.job_type')
                        ->orderBy($this->postJobModel->getTable().'.updated_at_time', 'desc')
                        ->where($this->postJobModel->getTable().'.job_category', $category)
                        ->Where($this->postJobModel->getTable().'.job_location',  $location)
                        ->whereBetween($this->postJobModel->getTable().'.job_salary', $salaryPrice)
                        ->where($this->postJobModel->getTable().'.job_type', $jobType)
                        ->paginate($pagination);
                }else
                {
                    $data['getPostedJob']   = PostJobModel::where($this->postJobModel->getTable().'.status', 1)
                        ->leftJoin($this->userProfileModel->getTable(), $this->userProfileModel->getTable().'.userID', '=', $this->postJobModel->getTable().'.userID')
                        ->leftJoin($this->industryModel->getTable(), $this->industryModel->getTable().'.industryID', '=', $this->postJobModel->getTable().'.job_category')
                        ->leftJoin($this->jobTypeModel->getTable(), $this->jobTypeModel->getTable().'.job_typeID', '=', $this->postJobModel->getTable().'.job_type')
                        ->orderBy($this->postJobModel->getTable().'.updated_at_time', 'desc')
                        ->where(function ($query) use ($category, $location, $salaryPrice, $jobType, $datePoster) {
                            $query->orwhere($this->postJobModel->getTable().'.job_category', $category)
                                ->orWhere($this->postJobModel->getTable().'.job_location',  $location)
                                ->orWhereBetween($this->postJobModel->getTable().'.job_salary', $salaryPrice)
                                ->orWhere($this->postJobModel->getTable().'.job_type', $jobType)
                                ->orWhereBetween($this->postJobModel->getTable().'.job_post_date', [$datePoster, date('Y-m-d')]);
                            })
                        ->paginate($pagination);
                }
            }
            //get total application, total shortlisted and total rejected
            if($data['getPostedJob'])
            {
                foreach($data['getPostedJob'] as $key=>$value)
                {
                    $totalApplication[$key]   = JobApplyModel::where('jobID', $value->jobID)->where('status', 1)->count();
                    $totalShortlisted[$key]   = JobApplyModel::where('jobID', $value->jobID)->where('status', 1)->where('candidate_status', 1)->count();
                    $totalRejected[$key]      = JobApplyModel::where('jobID', $value->jobID)->where('status', 1)->where('candidate_status', 2)->count();
                    $getLogo                  = $this->getUserPathImage($value->userID, $value->profile_picture, 'profile');
                    $getJobLogo[$key]         = $getLogo['filePathbest'];
                }
            }
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'BaseParentController@getCandidateProfileForJob', 'Error occured when getting all candate that apply for job.');
        }
        $data['totalApplication']   = $totalApplication;
        $data['totalShortlisted']   = $totalShortlisted;
        $data['totalRejected']      = $totalRejected;
        $data['getJobLogo']         = $getJobLogo;
        $data['category']           = $category;
        $data['location']           = $location;
        $data['salary']             = $salary;
        $data['jobType']            = $jobType;
        $data['datePoster']         = $datePoster;

        return $data;
    }



    //Get all jobs
    public function getAllJobWithTotalApplication($userID = null, $pagination = 100)
    {
        $data                   = [];
        $data['getPostedJob']   = [];
        $totalApplication       = [];
        $totalShortlisted       = [];
        $totalRejected          = [];
        $getJobLogo             = [];
        try{
            if($userID <> null)
            {
                if(is_numeric($pagination) && $pagination > 0)
                {
                    $data['getPostedJob']   = PostJobModel::where($this->postJobModel->getTable().'.userID', $userID)->where($this->postJobModel->getTable().'.status', 1)
                        ->leftJoin($this->userProfileModel->getTable(), $this->userProfileModel->getTable().'.userID', '=', $this->postJobModel->getTable().'.userID')
                        ->leftJoin($this->industryModel->getTable(), $this->industryModel->getTable().'.industryID', '=', $this->postJobModel->getTable().'.job_category')
                        ->leftJoin($this->jobTypeModel->getTable(), $this->jobTypeModel->getTable().'.job_typeID', '=', $this->postJobModel->getTable().'.job_type')
                        ->orderBy($this->postJobModel->getTable().'.updated_at_time', 'desc')
                        ->paginate($pagination);
                }else{
                    $data['getPostedJob']   = PostJobModel::where($this->postJobModel->getTable().'.userID', $userID)
                        ->leftJoin($this->userProfileModel->getTable(), $this->userProfileModel->getTable().'.userID', '=', $this->postJobModel->getTable().'.userID')
                        ->leftJoin($this->industryModel->getTable(), $this->industryModel->getTable().'.industryID', '=', $this->postJobModel->getTable().'.job_category')
                        ->leftJoin($this->jobTypeModel->getTable(), $this->jobTypeModel->getTable().'.job_typeID', '=', $this->postJobModel->getTable().'.job_type')
                        ->orderBy($this->postJobModel->getTable().'.updated_at_time', 'desc')
                        ->get();
                }
            }else{
                if(is_numeric($pagination) && $pagination > 0)
                {
                        $data['getPostedJob']   = PostJobModel::where($this->postJobModel->getTable().'.status', 1)
                            ->leftJoin($this->userProfileModel->getTable(), $this->userProfileModel->getTable().'.userID', '=', $this->postJobModel->getTable().'.userID')
                            ->leftJoin($this->industryModel->getTable(), $this->industryModel->getTable().'.industryID', '=', $this->postJobModel->getTable().'.job_category')
                            ->leftJoin($this->jobTypeModel->getTable(), $this->jobTypeModel->getTable().'.job_typeID', '=', $this->postJobModel->getTable().'.job_type')
                            ->orderBy($this->postJobModel->getTable().'.updated_at_time', 'desc')
                            ->paginate($pagination);
                }else{
                        $data['getPostedJob']   = PostJobModel::where($this->postJobModel->getTable().'.status', 1)
                            ->leftJoin($this->userProfileModel->getTable(), $this->userProfileModel->getTable().'.userID', '=', $this->postJobModel->getTable().'.userID')
                            ->leftJoin($this->industryModel->getTable(), $this->industryModel->getTable().'.industryID', '=', $this->postJobModel->getTable().'.job_category')
                            ->leftJoin($this->jobTypeModel->getTable(), $this->jobTypeModel->getTable().'.job_typeID', '=', $this->postJobModel->getTable().'.job_type')
                            ->orderBy($this->postJobModel->getTable().'.updated_at_time', 'desc')
                            ->get();
                }
            }


            //get total application, total shortlisted and total rejected
            if($data['getPostedJob'])
            {
                foreach($data['getPostedJob'] as $key=>$value)
                {
                    $totalApplication[$key]   = JobApplyModel::where('jobID', $value->jobID)->where('status', 1)->count();
                    $totalShortlisted[$key]   = JobApplyModel::where('jobID', $value->jobID)->where('status', 1)->where('candidate_status', 1)->count();
                    $totalRejected[$key]      = JobApplyModel::where('jobID', $value->jobID)->where('status', 1)->where('candidate_status', 2)->count();
                    $getLogo                  = $this->getUserPathImage($value->userID, $value->profile_picture, 'profile');
                    $getJobLogo[$key]         = $getLogo['filePathbest'];
                }
            }
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'BaseParentController@getCandidateProfileForJob', 'Error occured when getting all candate that apply for job.' );
        }
        $data['totalApplication']   = $totalApplication;
        $data['totalShortlisted']   = $totalShortlisted;
        $data['totalRejected']      = $totalRejected;
        $data['getJobLogo']         = $getJobLogo;

        return $data;
    }




    ################################### SENDING REGISTRATION EMAIL TO USER ##################################
    public function sendAccountRegistrationWelcomeEmail($userID = null, $emailAddress = null)
    {
           try{
               $userDetails = UserProfileModel::where('users.id', $userID)
                   ->join('users', 'users.id', '=', 'user_profile.userID')
                   ->select('users.id', 'user_profile.first_name', 'user_profile.last_name', 'users.email', 'user_profile.company_name')
                   ->first();
               if($userDetails)
               {
                   $getComapnyName     = $userDetails->company_name;
                   $getName            = ($userDetails->first_name .' '. $userDetails->last_name);
                   $getEmail           = ($emailAddress ? $emailAddress : $userDetails->email);
                   $emailData = ([
                       'clientName'          => $getName,
                       'clientCompanyName'   => $getComapnyName,
                       'clientEmail'         => $getEmail,
                   ]);
                   ($getEmail ? Mail::to($getEmail)->send(new sendEmailAccountRegistration($emailData)) : '');
               }
           } catch (\Throwable $errorThrown) {
               $this->storeTryCatchError($errorThrown, 'RegisterController@sendAccountRegistrationWelcomeEmail', 'Error occured When try to send Welcome Registration Account.' );
           }
           return;
    }
    ################################### SENDING REGISTRATION EMAIL TO USER ##################################

    ################################### SENDING ANY EMAIL TO USER ##################################
    public function sendAnyEmail($emailAddresses = [], $message = null, $title = null)
    {
            try{
                if($emailAddresses)
                {
                    foreach($emailAddresses as $email)
                    {
                        $email = $email->email;
                        $userDetails = User::where('email', $email)
                            ->join('user_profile', 'user_profile.userID', '=', 'users.id')
                            ->select('users.id', 'user_profile.first_name', 'user_profile.last_name', 'users.email', 'user_profile.company_name')
                            ->first();
                        $fullName = DB::table('admin_emails')->where('email', $email)->value('name');
                        $emailData = ([
                            'title'             => ($title ? $title : substr($message, 0, 50)),
                            'name'              => ($userDetails ? ($userDetails->first_name .' '. $userDetails->last_name) : $fullName),
                            'name_company'      => ($userDetails ? $userDetails->company_name : ''),
                            'email'             => $email,
                            'message'           => $message,
                        ]);
                        ($email ? Mail::to($email)->send(new sendAnyEmail($emailData)) : '');
                    }
                }
            } catch (\Throwable $errorThrown) {
                $this->storeTryCatchError($errorThrown, 'BaseParentController@sendAnyEmail', 'Error occured When try to send.' );
            }
            return;
    }
    ################################### END SENDING ANY EMAIL TO USER ##################################



    ############################### START WALLET #############################
    //Make payment from wallet
    public function makePaymentFromWallet($userID = null, $amount = 0, $transaction = null, $description = null)
    {
        $success = 0;
        try{
            if(User::find($userID))
            {
                $success = $this->debitWallet($userID, $amount, $transaction, $description);
            }
        } catch (\Throwable $errorThrown) {
            $this->storeTryCatchError($errorThrown, 'BaseParentController@makePaymentFromWallet', 'Error occured When making payment from wallet.' );
        }
        return $success;
    }

    //CREATE WALLET FOR USER
    public function createWallet($userID = null, $amount = 0.0, $transactionID = null, $description = "You wallet was created.")
    {
        $success = 0;
        if($userID)
        {
            try{
                if(!WalletModel::where('userID', $userID)->exists())
                {
                    $success = WalletModel::updateOrCreate(
                        [
                            'userID' => $userID
                        ],
                        [
                            'balance_amount'    => $amount,
                            'created_at'        => date('Y-m-d'),
                            'updated_at'        => date('Y-m-d'),
                            'updated_at_time'   => date('d-m-Y h:i a'),
                        ]
                    );
                    if($success)
                    {
                        $currentBal = $this->walletBalance($userID);
                        $this->createPaymentTransaction($userID, $transactionID, 'wallet', $amount, $description, $currentBal, $ip_address = null);
                    }
                }
            } catch (\Throwable $errorThrown) {
                $this->storeTryCatchError($errorThrown, 'BaseParentController@createWallet', 'Error occured When creating wallet.' );
            }
        }
        return $success;
    }

    //GET BALANCE WALLET
    public function walletBalance($userID = null, $transactionID = null)
    {
        if($userID)
        {
            if(!WalletModel::where('userID', $userID)->exists())
            {
                $this->createWallet($userID, 0.0, $transactionID);
            }
            $bal = 0;
            try{
                $myWallet = WalletModel::where('userID', $userID)->select('balance_amount', 'booked_amount')->first();
                if($myWallet)
                {
                    $bal =  ($myWallet->balance_amount - $myWallet->booked_amount);
                }else{
                    $bal = 0;
                }
            } catch (\Throwable $errorThrown) {
                $this->storeTryCatchError($errorThrown, 'BaseParentController@walletBalance', 'Error occured When getting wallet bal.' );
            }
        }
        return $bal;
    }

    //DEBIT WALLET
    public function debitWallet($userID = null, $amount = 0, $transactionID = null, $description = null)
    {
        if($userID)
        {
            $success    = 0;
            $newBal     = 0;
            try{
                $myWallet = WalletModel::where('userID', $userID)->select('balance_amount', 'booked_amount')->first();
                if($myWallet)
                {
                    $bal =  ($myWallet->balance_amount - $myWallet->booked_amount);
                    if($bal > $amount)
                    {
                        $newBal = $bal - $amount;
                        //update wallet
                        $success = WalletModel::where('userID', $userID)->update(
                            [
                                'balance_amount'    => $newBal,
                                'updated_at'        => date('Y-m-d'),
                                'updated_at_time'   => date('d-m-Y h:i a'),
                            ]);
                        //LOG: paymt. Trans.
                        if($success)
                        {
                            $this->updatePaymentHistory($transactionID, $amount, $statusCode = 200, $success = 1, $reference = $transactionID, $callbackData = null);
                            $currentBal = $this->walletBalance($userID);
                            $this->createPaymentTransaction($userID, $transactionID, 'wallet', $amount, $description, $currentBal, $ip_address = null);
                        }
                    }else{
                       $success = 0;
                    }
                }else{
                    $bal = 0;
                }
            } catch (\Throwable $errorThrown) {
                $this->storeTryCatchError($errorThrown, 'BaseParentController@debitWallet', 'Error occured When getting wallet bal.' );
            }
        }
        return $success;
    }

     //CREDIT WALLET
    public function creditWallet($userID = null, $amount = 0, $transactionID = null, $description = null)
    {
         if($userID)
         {
             $success = 0;
             try{
                 $myWallet = WalletModel::where('userID', $userID)->value('balance_amount')->first();
                 if($myWallet)
                 {
                    $newBal =  ($myWallet->balance_amount + $amount);
                    //update wallet
                    $success = WalletModel::where('userID', $userID)->update(
                        [
                            'balance_amount'    => $newBal,
                            'updated_at'        => date('Y-m-d'),
                            'updated_at_time'   => date('d-m-Y h:i a'),
                        ]);
                    if($success)
                    {
                        $currentBal = $this->walletBalance($userID);
                        $this->createPaymentTransaction($userID, $transactionID, 'wallet', $amount, $description, $currentBal, $ip_address = null);
                    }
                 }else{
                     $success = 0;
                 }
             } catch (\Throwable $errorThrown) {
                 $this->storeTryCatchError($errorThrown, 'BaseParentController@creditWallet', 'Error occured When getting wallet bal.' );
             }
         }
         return $success;
    }

     //Book WALLET
    public function bookWallet($userID = null, $bookAmount = 0)
    {
         if($userID)
         {
             $success = 0;
             try{
                 $myWallet = WalletModel::where('userID', $userID)->value('booked_amount')->first();
                 if($myWallet)
                 {
                    $newBal =  ($myWallet->booked_amount + $bookAmount);
                    //update wallet
                    $success = WalletModel::where('userID', $userID)->update(
                        [
                            'booked_amount'     => $newBal,
                            'updated_at'        => date('Y-m-d'),
                            'updated_at_time'   => date('d-m-Y h:i a'),
                        ]);
                 }else{
                     $success = 0;
                 }
             } catch (\Throwable $errorThrown) {
                 $this->storeTryCatchError($errorThrown, 'BaseParentController@bookWallet', 'Error occured When booking wallet.' );
             }
         }
         return $success;
    }

     //UPDATE PAYMENT HISTORY
    public function updatePaymentHistory($transactionID = null, $amountPaid = 0, $statusCode = null, $success = null, $reference = null, $callbackData = null)
    {
         $success = 0;
         $paymentHistory = PaymentHistoryModel::where('transactionID', $transactionID)->first();
        if($paymentHistory)
        {
            try{
                $success = PaymentHistoryModel::updateOrCreate(
                    [
                        'transactionID'     => $transactionID,
                    ],
                    [
                        'amount_paid'           => $amountPaid,
                        'payment_status_code'   => $statusCode,
                        'payment_success'       => $success,
                        'payment_reference'     => $reference,
                        'updated_at'            => date('Y-m-d'),
                        'updated_at_time'       => date('Y-m-d h:i:s a'),
                        'payment_json_data'     => $callbackData,
                        'status'                => 0,
                    ]
                );
            }catch (\Throwable $errorThrown) {
                $this->storeTryCatchError($errorThrown, 'BaseParentController@updatePaymentHistory', 'Error occured When updating payment history.' );
            }
        }
        return $success;
    }


    //UPDATE PAYMENT HISTORY
    public function createPaymentTransaction($userID = null, $transactionID = null, $paymentType = null, $amount = 0, $description = null, $walletBal = null, $ip_address = null)
    {
        $success = 0;
        if($userID)
        {
            try{
                $success = PaymentTransactionModel::create(
                    [
                        'userID'                => $userID,
                        'transactionID'         => $transactionID,
                        'payment_type'          => $paymentType,
                        'payment_amount'        => $amount,
                        'payment_description'   => $description,
                        'wallet_balance'        => $walletBal,
                        'created_at'            => date('Y-m-d'),
                        'created_at_time'       => date('Y-m-d h:i:s a'),
                        'ip_address'            => $ip_address,
                    ]
                );
            }catch (\Throwable $errorThrown) {
                $this->storeTryCatchError($errorThrown, 'BaseParentController@createPaymentTransaction', 'Error occured When creating payment transaction.' );
            }
        }
        return $success;
     }
    ############################### END WALLET #############################




}//end class
