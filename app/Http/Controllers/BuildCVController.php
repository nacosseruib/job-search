<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BuildCVRequestModel;
use App\Models\UploadCVModel;
use App\Models\PaymentHistoryModel;
use Cache;
use Session;


class BuildCVController extends BaseParentController
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->getAllModel();
    }


    //View Resume
    public function createBuildCV()
    {
        $data = [];
        try{
            $data['priceData'] = $this->getPriceList(1); //Get Build CV price
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'BuildCVController@createBuildCV', 'Error occured on GET Request when trying to create build cv' );
        }
        return $this->checkViewBeforeRender('candidate.buildCv.buildCVPage', $data);
    }


    //Create Request for CV Build
    public function createRequestBuildCV()
    {
        $data = [];
        try{
            //Get user CV
            $data['allMyCV'] = UploadCVModel::where('userID', $this->getUserID())->get();
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'BuildCVController@createRequestBuildCV', 'Error occured when requesting for build CV.' );
        }
        return $this->checkViewBeforeRender('candidate.buildCv.requestBuildCVPageView', $data);
    }


    //Save Request
    public function saveRequestBuildCV(Request $request)
    {
        //validation
        $this->validate($request,
        [
            'cv'               => ['required', 'numeric'],
            'description'      => ['max:100'],
            //'resume'           => ['required', 'string'],
        ]);
        $save = 0;
        try{
            $userID = $this->getUserID();
            $save = BuildCVRequestModel::create([
                'userID'                    => $userID,
                'cvID'                      => $request['cv'],
                'description'               => $request['description'],
                'resume_details'            => $request['resume'],
                'transactionID'             => $this->generateRandomAlphaNumeric(20),
                'created_at'                => date('Y-m-d'),
                'updated_at'                => date('Y-m-d'),
                'updated_at_time'           => date('Y-m-d h:i:s a'),
            ]);
            if($save)
            {
                try{
                    $priceData = $this->getPriceList(1); //Get Build CV price
                    $amount = ($priceData ? $priceData->price_amount : 0) ;
                    $created = $this->createPayment($userID, $save->transactionID, $save->buildcvID, $amount, "Payment for building CV.");
                    if(!$created)
                    {
                        BuildCVRequestModel::find($save->buildcvID)->delete(); //delete user cv building request
                    }
                }catch(\Throwable $errorThrown){
                    //revert operation when fails
                    BuildCVRequestModel::find($save->buildcvID)->delete(); //delete user cv building request
                    $this->storeTryCatchError($errorThrown, 'BuildCVController@saveRequestBuildCV-Create-Payment-History', 'Error occured when creating payment history.' );
                    $save = 0;
                }
            }
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'BuildCVController@saveRequestBuildCV', 'Error occured when saving requesting for build CV.' );
        }
        if($save)
        {
            return redirect()->route('listCVBuildRequest')->with('success', 'Your request was saved successfully. Please make payment now to send your request.');
        }
        return redirect()->back()->with('error', 'Sorry, we are cannot save you request now! Please try again.');
    }


    //List All Request for CV Build
    public function listAllRequestForBuildCV()
    {
        $data = [];
        try{
            //Get user CV
            $data['listAllCVBuildRequest'] = BuildCVRequestModel::where($this->buildCVRequestModel->getTable().'.userID', $this->getUserID())->where('is_hidden', 0)
                                            ->join($this->uploadCVModel->getTable(), $this->uploadCVModel->getTable().'.candidate_cvID', '=', $this->buildCVRequestModel->getTable().'.cvID')
                                            ->join($this->paymentHistoryModel->getTable(), $this->paymentHistoryModel->getTable().'.transactionID', '=', $this->buildCVRequestModel->getTable().'.transactionID')
                                            ->get();
            $data['userPath'] = $this->getUserPath('document', $this->getUserID());
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'BuildCVController@createRequestBuildCV', 'Error occured when requesting for build CV.' );
        }
        return $this->checkViewBeforeRender('candidate.buildCv.ListRequestForCVBuildPageView', $data);
    }




}//end class
