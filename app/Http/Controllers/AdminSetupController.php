<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfileModel;
use App\Models\BuildCVRequestModel;
use App\Models\UploadCVModel;
use App\Models\BuiltCVByAdminModel;
use App\Models\PaymentTransactionModel;
use Cache;
use Session;
use DB;


class AdminSetupController extends BaseParentController
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->getAllModel();
    }

    //View Resume
    public function viewAllRegisteredUser()
    {
        $data           = [];
        $getUserImage   = [];
        try{
            $data['registeredUsers'] = UserProfileModel::where('user_type', '<>', 1)
                            ->join($this->user->getTable(), $this->user->getTable().'.id', '=', $this->userProfileModel->getTable().'.userID')
                            ->leftjoin($this->userTypeModel->getTable(), $this->userTypeModel->getTable().'.user_typeID', '=', $this->user->getTable().'.user_type')
                            ->leftjoin($this->industryModel->getTable(), $this->industryModel->getTable().'.industryID', '=', $this->userProfileModel->getTable().'.company_industry_id')
                            ->select($this->industryModel->getTable().'.*', $this->userTypeModel->getTable().'.*', $this->userProfileModel->getTable().'.*', $this->userProfileModel->getTable().'.created_at as join_date', $this->user->getTable().'.*', DB::raw('CONCAT(first_name, " ", last_name) as name'))
                            ->paginate(100);
            if($data['registeredUsers'])
            {
                foreach($data['registeredUsers'] as $key=>$value)
                {
                    $getLogo          = $this->getUserPathImage($value->id, $value->profile_picture, 'profile');
                    $getUserImage[$key] = $getLogo['filePathbest'];
                }
            }
            $data['getUserImage'] = $getUserImage;
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'AdminSetupController@viewAllRegisteredUser', 'Error occured when getting all registered users.' );
        }
        return $this->checkViewBeforeRender('admin.viewRegisteredUser.viewUserPage', $data);
    }

    //View All Request for CVBuilding
    public function viewAllBuildCVRequest()
    {
        $data                   = [];
        $filePathBig            = [];
        $unpaidFilePathBig      = [];
        $getAllSentCVUnpaid     = [];
        $getAllSentCVPaid       = [];
        $imagetpPath            = [];
        $imagetuPath            = [];
        try{
            //PAID - Get user CV
            $data['paidListAllCVBuildRequest'] = BuildCVRequestModel::where($this->paymentHistoryModel->getTable().'.payment_status_code', 200)->where('is_hidden', 0)
                                            ->leftJoin($this->userProfileModel->getTable(), $this->userProfileModel->getTable().'.userID', '=', $this->buildCVRequestModel->getTable().'.userID')
                                            ->leftJoin($this->user->getTable(), $this->user->getTable().'.id', '=', $this->userProfileModel->getTable().'.userID')
                                            ->join($this->uploadCVModel->getTable(), $this->uploadCVModel->getTable().'.candidate_cvID', '=', $this->buildCVRequestModel->getTable().'.cvID')
                                            ->join($this->paymentHistoryModel->getTable(), $this->paymentHistoryModel->getTable().'.transactionID', '=', $this->buildCVRequestModel->getTable().'.transactionID')
                                            ->select('*', $this->buildCVRequestModel->getTable().'.userID')
                                            ->paginate(30);
            if($data['paidListAllCVBuildRequest'])
            {
                foreach($data['paidListAllCVBuildRequest'] as $key=>$value)
                {
                    $getPath = $this->getUserPathImage($value->userID, $value->file_name, 'document');
                    $filePathBig[$key] = $getPath['filePathBig'];
                    $imagetPath = $this->getUserPathImage($value->userID, $value->file_name, 'document');
                    $imagetpPath[$key] = $imagetPath['filePathbest'];
                    $getAllSentCVPaid[$key] = BuiltCVByAdminModel::where('userID', $value->userID)->get();
                }
            }
            $data['filePath'] = $filePathBig;
            $data['imagetpPath'] = $imagetpPath;

            //UNPAID - GET user cv
            $data['unpaidListAllCVBuildRequest'] = BuildCVRequestModel::where($this->paymentHistoryModel->getTable().'.payment_status_code', 0)->where('is_hidden', 0)
                                            ->leftJoin($this->userProfileModel->getTable(), $this->userProfileModel->getTable().'.userID', '=', $this->buildCVRequestModel->getTable().'.userID')
                                            ->leftJoin($this->user->getTable(), $this->user->getTable().'.id', '=', $this->userProfileModel->getTable().'.userID')
                                            ->join($this->uploadCVModel->getTable(), $this->uploadCVModel->getTable().'.candidate_cvID', '=', $this->buildCVRequestModel->getTable().'.cvID')
                                            ->join($this->paymentHistoryModel->getTable(), $this->paymentHistoryModel->getTable().'.transactionID', '=', $this->buildCVRequestModel->getTable().'.transactionID')
                                            ->select('*', $this->buildCVRequestModel->getTable().'.userID', DB::raw('CONCAT(first_name, " ", last_name) as full_name'))
                                            ->paginate(30);
            if($data['unpaidListAllCVBuildRequest'])
            {
                foreach($data['unpaidListAllCVBuildRequest'] as $key=>$value)
                {
                    $getPath = $this->getUserPathImage($value->userID, $value->file_name, 'document');
                    $unpaidFilePathBig[$key] = $getPath['filePathBig'];
                    $imagetPath = $this->getUserPathImage($value->userID, $value->profile_picture, 'profile');
                    $imagetuPath[$key] = $imagetPath['filePathbest'];
                    $getAllSentCVUnpaid[$key] = BuiltCVByAdminModel::where('userID', $value->userID)->get();
                }
            }
            $data['unpaidFilePath'] = $unpaidFilePathBig;
            $data['getAllSentCVUnpaid'] = $getAllSentCVUnpaid;
            $data['getAllSentCVPaid'] = $getAllSentCVPaid;
            $data['userPath'] = $this->getUserPath('document', $this->getUserID());
            $data['imagetuPath'] = $imagetuPath;
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'AdminSetupController@viewAllBuildCVRequest', 'Error occured when creating list of request for cv build.' );
        }
        return $this->checkViewBeforeRender('admin.buildCV.viewAllCVBuildRequestPageView', $data);
    }


    //Add New CV
    public function uploadNewCv(Request $request)
    {
       $completed  = 0;

        $this->validate($request,
        [
            'userName'             => ['required', 'string'],
            'cvFile'               => ['required', 'mimes:pdf'], /* png,jpg,jpe,jpeg,doc,docx, */
            'fileDescription'      => ['required', 'string', 'max: 100'],
        ]);
        try{
            $uploadCompletePathName = $this->uploadPath() . 'document/';
            $getUserToken           = User::find($request['userName']);
            $userNewCVUploadPath    = env('UPLOADPATHROOT', null) . ($getUserToken ? $getUserToken->user_token : '') .'/document' .'/';

            $userID     = $request['userName'];
            $fileTitle  = $request['fileDescription'];

           if($request->hasFile('cvFile'))
           {
               //Send New CV to user DB
               $getArrayResponse = $this->uploadAnyFile($request['cvFile'], $userNewCVUploadPath, $maxFileSize = 10, $newExtension = null, $newRadFileName = true);
               if($getArrayResponse)
               {
                   //copy file to admin folder
                   ($getArrayResponse ? copy($userNewCVUploadPath . $getArrayResponse['newFileName'], $uploadCompletePathName . $getArrayResponse['newFileName']) : null);

                   if($getArrayResponse['success']){
                       $completed = UploadCVModel::create([
                           'userID'            => $userID,
                           'file_description'  => $fileTitle,
                           'file_name'         => $getArrayResponse['newFileName'],
                           'created_at'        => date('Y-m-d'),
                           'updated_at'        => date('Y-m-d'),
                       ]);
                    }
                }
                //Send New CV to admin DB
                if($getArrayResponse['success'])
                {
                       $completedAdmin = BuiltCVByAdminModel::create([
                        'userID'            => $userID,
                        'file_description'  => $fileTitle,
                        'file_name'         => $getArrayResponse['newFileName'],
                        'created_at'        => date('Y-m-d'),
                    ]);
                }
           }
           if($completed)
           {
               return redirect()->route('viewCVBuildRequest')->with('success', 'You have successfully uploaded a new CV.');
           }
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'AdminSetupController@uploadNewCv', 'Error occurred when uploading CV' );
        }
        return redirect()->route('viewCVBuildRequest')->with('error', 'Sorry, we cannot upload your new CV now! Please try again later.');
    }


    //VIEW WALLET STATEMENT OF ACCOUNT
    public function viewAllWalletPaymentTransaction($from = 0, $to = 0, $userID = 0)
    {
        $data = [];
        try{
            //Get All Users
            $data['getAllUser'] = UserProfileModel::where($this->user->getTable().'.user_type', '<>', 1)
                            ->join($this->user->getTable(), $this->user->getTable().'.id', '=', $this->userProfileModel->getTable().'.userID')
                            ->get();
            //Get All Payment Transactions
            if ($from <> 0 && $to <> 0 && $userID <> 0)
            {
                $data['paymentTransaction'] = PaymentTransactionModel::where($this->paymentTransactionModel->getTable().'.userID', $userID)
                    ->leftjoin($this->userProfileModel->getTable(), $this->userProfileModel->getTable().'.userID', '=', $this->paymentTransactionModel->getTable().'.userID')
                    ->leftjoin($this->user->getTable(), $this->user->getTable().'.id', '=', $this->userProfileModel->getTable().'.userID')
                    ->whereBetween($this->paymentTransactionModel->getTable().'.created_at', [$from, $to])->where($this->paymentTransactionModel->getTable().'.status', 1)
                    ->orderBy($this->paymentTransactionModel->getTable().'.created_at', 'Desc')
                    ->paginate(500);
            }elseif($from == 0 && $to == 0 && $userID <> 0)
            {
                $data['paymentTransaction'] = PaymentTransactionModel::where($this->paymentTransactionModel->getTable().'.userID', $userID)
                    ->leftjoin($this->userProfileModel->getTable(), $this->userProfileModel->getTable().'.userID', '=', $this->paymentTransactionModel->getTable().'.userID')
                    ->leftjoin($this->user->getTable(), $this->user->getTable().'.id', '=', $this->userProfileModel->getTable().'.userID')
                    ->orderBy($this->paymentTransactionModel->getTable().'.created_at', 'Desc')
                    ->paginate(500);
            }elseif($from <> 0 && $to <> 0 && $userID == 0){
                $data['paymentTransaction'] = PaymentTransactionModel::whereBetween($this->paymentTransactionModel->getTable().'.created_at', [$from, $to])->where($this->paymentTransactionModel->getTable().'.status', 1)
                    ->leftjoin($this->userProfileModel->getTable(), $this->userProfileModel->getTable().'.userID', '=', $this->paymentTransactionModel->getTable().'.userID')
                    ->leftjoin($this->user->getTable(), $this->user->getTable().'.id', '=', $this->userProfileModel->getTable().'.userID')
                    ->orderBy($this->paymentTransactionModel->getTable().'.created_at', 'Desc')
                    ->paginate(500);
            }else{
                $data['paymentTransaction'] = PaymentTransactionModel::where($this->paymentTransactionModel->getTable().'.status', 1)
                    ->leftjoin($this->userProfileModel->getTable(), $this->userProfileModel->getTable().'.userID', '=', $this->paymentTransactionModel->getTable().'.userID')
                    ->leftjoin($this->user->getTable(), $this->user->getTable().'.id', '=', $this->userProfileModel->getTable().'.userID')
                    ->orderBy($this->paymentTransactionModel->getTable().'.created_at', 'Desc')
                    ->paginate(500);
            }
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'AdminSetupController@viewAllWalletPaymentTransaction', 'Error occured when viewing statement of account.' );
        }
        $data['from']       = $from;
        $data['to']         = $to;
        $data['userName']   = $userID;
        return $this->checkViewBeforeRender('admin.walletPaymentTransaction.walletStatementAccountPageView')->with($data);
    }

    //POST SEARCH STATEMENT OF ACCOUNT
    public function postWalletPaymentTransaction(Request $request)
    {
        $this->validate($request,
        [
                'dateFrom'   => ['date','nullable','max:50'], //'required', 'date',
                'dateTo'     => ['date','nullable','max:50'], //'required', 'date',
                'userName'   => ['string','nullable','max:1000'],
        ]);
        return redirect()->route('viewAllWalletTransaction', ['from'=>($request['dateFrom'] ? $request['dateFrom'] : 0), 'to'=>($request['dateTo'] ? $request['dateTo'] : 0), 'uid'=>($request['userName'] ? $request['userName'] : 0)]);
    }



}//end class
