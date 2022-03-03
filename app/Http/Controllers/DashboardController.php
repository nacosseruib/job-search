<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\PostJobModel;
use App\Models\JobApplyModel;
use Cache;
use Session;
use Auth;


class DashboardController extends BaseParentController
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->getAllModel();
    }

    //Dashboard
    public function dashboard()
    {
        $data = [];
        try{
            $userID                 = $this->getUserID();
            $data2['getUserPath']    = $this->getUserPath($folderName = 'job');
            //Get user type
            $userRole = (Auth::check() ? Auth::user()->user_role : 'null'); //Either 3-candidate or 4-employer
            if($userRole == 3)
            {
                //Candidate
                $data = $this->getCandidateDashboardData($userID);
                return $this->checkViewBeforeRender('candidate.dashboard.dashboardPage', $data)->with($data2);
            }elseif($userRole == 4)
            {
                //Employer
                $data = $this->getEmployerDashboardData($userID);
                return $this->checkViewBeforeRender('employer.dashboard.dashboardPage', $data)->with($data2);;
            }else{
                //Employer
                $data = $this->getEmployerDashboardData($userID);
                return $this->checkViewBeforeRender('employer.dashboard.dashboardPage', $data)->with($data2);;
            }
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'DashboardController@dashboard', 'Error occured on GET Request when trying load user profile.');
        }
        return redirect()->route('index');
    }


    //Get candidate dashboard data
    public function getCandidateDashboardData($userID = null)
    {
        $getJobLogo = [];
        //Candidate
        $data['countSubmittedApplication']  = JobApplyModel::where($this->jobApplyModel->getTable().'.candidateID', $userID)->count();
        $data['shortlistedApplication']     = JobApplyModel::where($this->jobApplyModel->getTable().'.candidateID', $userID)->where('candidate_status', 1)->count();
        $data['rejectedApplication']        = JobApplyModel::where($this->jobApplyModel->getTable().'.candidateID', $userID)->where('candidate_status', 2)->count();
        $data['getAllSubmittedApplication'] = JobApplyModel::where($this->jobApplyModel->getTable().'.candidateID', $userID)
                                            ->Join($this->postJobModel->getTable(), $this->postJobModel->getTable().'.jobID', '=', $this->jobApplyModel->getTable().'.jobID')
                                            ->leftJoin($this->userProfileModel->getTable(), $this->userProfileModel->getTable().'.userID', '=', $this->postJobModel->getTable().'.userID')
                                            ->leftJoin($this->industryModel->getTable(), $this->industryModel->getTable().'.industryID', '=', $this->postJobModel->getTable().'.job_category')
                                            ->leftJoin($this->jobTypeModel->getTable(), $this->jobTypeModel->getTable().'.job_typeID', '=', $this->postJobModel->getTable().'.job_type')
                                            ->select($this->postJobModel->getTable().'.*', $this->postJobModel->getTable().'.userID as posted_by', 'profile_picture', $this->jobTypeModel->getTable().'.type_name', 'industry_name')
                                            ->orderBy($this->jobApplyModel->getTable().'.created_at', 'Desc')
                                            ->paginate(300);
        if($data['getAllSubmittedApplication'])
        {
            foreach($data['getAllSubmittedApplication'] as $key=>$value)
            {
                $getLogo          = $this->getUserPathImage($value->posted_by, $value->profile_picture, 'profile');
                $getJobLogo[$key] = $getLogo['filePathbest'];
            }
        }
        $data['getJobLogo'] = $getJobLogo;

        return $data;
    }


    //Get Employer dashboard data
    public function getEmployerDashboardData($userID = null)
    {
        $getJobLogo = [];
        //Candidate
        $allMyJobPost = PostJobModel::where($this->postJobModel->getTable().'.userID', $userID)->select('jobID')->get();
        $data['countAllPostedJob']  = count($allMyJobPost);
        $data['shortlistedApplication']     = JobApplyModel::whereIn('jobID', $allMyJobPost)->where('candidate_status', 1)->count();
        $data['rejectedApplication']        = JobApplyModel::whereIn('jobID', $allMyJobPost)->where('candidate_status', 2)->count();
        $data['getPostedJob'] = PostJobModel::where($this->postJobModel->getTable().'.userID', $userID)
                            ->leftJoin($this->userProfileModel->getTable(), $this->userProfileModel->getTable().'.userID', '=', $this->postJobModel->getTable().'.userID')
                            ->leftJoin($this->industryModel->getTable(), $this->industryModel->getTable().'.industryID', '=', $this->postJobModel->getTable().'.job_category')
                            ->leftJoin($this->jobTypeModel->getTable(), $this->jobTypeModel->getTable().'.job_typeID', '=', $this->postJobModel->getTable().'.job_type')
                            ->orderBy($this->postJobModel->getTable().'.created_at', 'desc')
                            ->paginate(500);
        if($data['getPostedJob'])
        {
            foreach($data['getPostedJob'] as $key=>$value)
            {
                $getLogo          = $this->getUserPathImage($value->posted_by, $value->profile_picture, 'profile');
                $getJobLogo[$key] = $getLogo['filePathbest'];
            }
        }
        $data['getJobLogo'] = $getJobLogo;

        return $data;
    }

}//end class
