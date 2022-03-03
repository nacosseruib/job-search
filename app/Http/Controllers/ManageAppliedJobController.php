<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PostJobModel;
use App\Models\JobApplyModel;
use Cache;
use Session;


class ManageAppliedJobController extends BaseParentController
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->getAllModel();
    }


    //View Resume
    public function createManageJob()
    {
        $data = [];
        $userID                 = $this->getUserID();
        try{
            $data['countSubmittedApplication']  = JobApplyModel::where($this->jobApplyModel->getTable().'.candidateID', $userID)->count();
            $data['shortlistedApplication']     = JobApplyModel::where($this->jobApplyModel->getTable().'.candidateID', $userID)->where('candidate_status', 1)->count();
            $data['rejectedApplication']        = JobApplyModel::where($this->jobApplyModel->getTable().'.candidateID', $userID)->where('candidate_status', 2)->count();
            $data['getAllSubmittedApplication'] = JobApplyModel::where($this->jobApplyModel->getTable().'.candidateID', $userID)
                                                ->Join($this->postJobModel->getTable(), $this->postJobModel->getTable().'.jobID', '=', $this->jobApplyModel->getTable().'.jobID')
                                                ->leftJoin($this->userProfileModel->getTable(), $this->userProfileModel->getTable().'.userID', '=', $this->postJobModel->getTable().'.userID')
                                                ->leftJoin($this->industryModel->getTable(), $this->industryModel->getTable().'.industryID', '=', $this->postJobModel->getTable().'.job_category')
                                                ->leftJoin($this->jobTypeModel->getTable(), $this->jobTypeModel->getTable().'.job_typeID', '=', $this->postJobModel->getTable().'.job_type')
                                                ->select($this->postJobModel->getTable().'.*', 'candidate_status', $this->postJobModel->getTable().'.userID as posted_by', 'profile_picture', $this->jobTypeModel->getTable().'.type_name', 'industry_name')
                                                ->orderBy($this->jobApplyModel->getTable().'.created_at', 'Desc')
                                                ->paginate(500);
            if($data['getAllSubmittedApplication'])
            {
                foreach($data['getAllSubmittedApplication'] as $key=>$value)
                {
                    $getLogo          = $this->getUserPathImage($value->posted_by, $value->profile_picture, 'profile');
                    $getJobLogo[$key] = $getLogo['filePathbest'];
                }
            }
            $data['getJobLogo'] = $getJobLogo;
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'ManageAppliedJobController@createManageJob', 'Error occured on GET Request when trying to create manage jo page' );
        }
        return $this->checkViewBeforeRender('candidate.manageJob.manageJobPage', $data);
    }



}//end class
