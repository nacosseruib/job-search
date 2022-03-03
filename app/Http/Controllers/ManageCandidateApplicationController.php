<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserProfileModel;
use App\Models\UserTypeModel;
use App\Models\IndustryModel;
use App\Models\PostJobModel;
use App\Models\JobApplyModel;
use App\Models\User;
use Cache;
use Session;


class ManageCandidateApplicationController extends BaseParentController
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->getAllModel();
    }

    //create manage candidate
    public function createManageCandidateApplication($getJobID = null)
    {
        $data               = [];
        $userImageArray     = [];
        $userPathArray      = [];

        try{
            $userID             = $this->getUserID();
            //$data['userPath']   = $this->getUserPath('document');
            $data['allMyJob']   = PostJobModel::where('userID', $userID)->orderBy('created_at', 'Desc')->get();
            if($getJobID)//from list - when user click on a job
            {
                $this->setSessionForJobAndCandidate($getJobID);
            }
            if(Session::get('jobDetails')) //On change - when user select job from dropdown
            {
                $data['jobDetails'] = Session::get('jobDetails');
                $data['candidateDetails'] = Session::get('candidateDetails');
                if($data['candidateDetails'])
                {
                    foreach($data['candidateDetails'] as $key=>$value)
                    {
                        $getImages = $this->getUserPathImage($value->userID, $value->profile_picture, $folderName = 'profile');
                        $userImageArray[$key]  = $getImages['filePathbest'];
                        $userPathArray[$key]   = $this->getUserPath('document', $value->userID);
                    }
                }
            }else{
                Session::forget('jobDetails');
                Session::forget('candidateDetails');
            }
            $data['userImages'] = $userImageArray;
            $data['userPath']   = $userPathArray;
            ########################//##################################
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'ManageCandidateApplicationController@createManageCandidateApplication', 'Error occured on GET Request when creating managa candidate.' );
        }
        return $this->checkViewBeforeRender('employer.manageCandidate.manageCandidatePage', $data);
    }


    //get job details
    public function setSessionForJobAndCandidate($jobID = null)
    {
        Session::forget('jobDetails');
        Session::forget('candidateDetails');
        if($jobID)
        {
            try{
                $jobDetails             = $this->getSingleJob($jobID);
                $candidateDetails       = $this->getCandidateProfileForJob($jobID);
                if($jobDetails)
                {
                    Session::put('jobDetails', $jobDetails);
                    Session::put('candidateDetails', $candidateDetails);
                }else{
                    Session::forget('jobDetails');
                    Session::forget('candidateDetails');
                }
            }catch(\Throwable $errorThrown){
                $this->storeTryCatchError($errorThrown, 'ManageCandidateApplicationController@setSessionForJobAndCandidate', 'Error occured when getting Job Details and all Candidates that applied for the job.' );
            }
        }
        return $jobID;
    }


    ######## Shortlist/Accept Candidate #################
    public function updateCandidateStatus($jobID = null, $jobApplyID = null, $status = null) //Reject is 2 and accept is 1
    {
        $complete = 0;
        if($jobID && $jobApplyID && $status)
        {
            try{
                $complete = JobApplyModel::where('job_applyID', $jobApplyID)->where('jobID', $jobID)->update([
                    'candidate_status' => $status
                ]);
                if($complete)
                {
                    Session::forget('jobDetails');
                    Session::forget('candidateDetails');
                    //
                    $jobDetails             = $this->getSingleJob($jobID);
                    $candidateDetails       = $this->getCandidateProfileForJob($jobID);
                    if($jobDetails)
                    {
                        Session::put('jobDetails', $jobDetails);
                        Session::put('candidateDetails', $candidateDetails);
                    }else{
                        Session::forget('jobDetails');
                        Session::forget('candidateDetails');
                    }
                }
            }catch(\Throwable $errorThrown){
                $this->storeTryCatchError($errorThrown, 'ManageCandidateApplicationController@updateCandidateStatus', 'Error occured when updating candidate status. (Accept or Reject)' );
            }
        }
        return redirect()->back()->with('message', 'Your update was successful.');
    }


    //Get list of candidate that apply for a job: Employer
    public function candidateAppliedForJobWithStatus($jobID = null, $status = null)
    {
        $datd = [];
        try{
            if($jobID)
            {
                if($status)
                {
                    $data['getAllCandidate'] = JobApplyModel::where('jobID', $jobID)->where('candidate_status', $status)
                        ->join($this->userProfileModel->getTable(), $this->userProfileModel->getTable().'.userID', '=', $this->jobApplyModel->getTable().'.candidateID')
                        ->leftjoin($this->user->getTable(), $this->user->getTable().'.id', '=', $this->userProfileModel->getTable().'.userID')
                        ->get();
                }else{
                    $data['getAllCandidate'] = JobApplyModel::where('jobID', $jobID)
                        ->join($this->userProfileModel->getTable(), $this->userProfileModel->getTable().'.userID', '=', $this->jobApplyModel->getTable().'.candidateID')
                        ->leftjoin($this->user->getTable(), $this->user->getTable().'.id', '=', $this->userProfileModel->getTable().'.userID')
                        ->get();
                }
                $data['getJob'] = $this->getSingleJob($jobID);
            }else{
                return redirect()->back()->with('info', 'Sorry, we cannot get the details of this job! Please try again later.');
            }
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'ManageCandidateApplicationController@candidateAppliedForJobWithStatus', 'Error occured when trying to view all candidate applied for a job.' );
        }
        return $this->checkViewBeforeRender('employer.viewCandidate.viewCandidatePage', $data);
    }

}//end class
