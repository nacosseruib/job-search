<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Cache;
use App\Models\IndustryModel;
use App\Models\PostJobModel;
use App\Models\JobTypeModel;
use App\Models\CoverLetterModel;
use App\Models\UploadCVModel;
use App\Models\JobApplyModel;
use Auth;

class JobListingAndSearchController extends BaseParentController
{

    public function __construct()
    {
        $this->getAllModel();
    }


    public function createJobSearch($categoryID = null)
    {
        $data       = [];
        $getMatchedJob = [];
        $getCategoryAndSection = [];
        try{
            $getCategoryAndSection = $this->getCategoryAndSection();
            //get job
            $getMatchedJob = $this->searchForJob($pagination = 100, $category = $categoryID, $location = null, $salary = null, $jobType = null, $datePoster = null);
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'JobListingAndSearchController@createJobSearch', 'Error occured when creating job listing/search.' );
        }
        return $this->checkViewBeforeRender('jobListing.jobListingPage', $data)->with($getMatchedJob)->with($getCategoryAndSection);
    }//end function


    //Post Search Job
    public function postJobSearch(Request $request)
    {
        $data = [];
        $getMatchedJob = [];
        try{
            $getCategoryAndSection = $this->getCategoryAndSection();
            $getMatchedJob = $this->searchForJob($pagination = 100, $category = $request['industry'], $location = $request['location'], $salary = $request['salary'], $jobType = $request['jobType'], $datePoster = $request['postedDate']);
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'JobListingAndSearchController@postJobSearch', 'Error occured when creating job listing/search.' );
        }
        return $this->checkViewBeforeRender('jobListing.jobListingPage', $data)->with($getMatchedJob)->with($getCategoryAndSection);
    }


    //Job details
    public function getJobDetails($jobID = null)
    {
        $data = [];
        try{
            $data['jobDetails'] = $this->getSingleJob($jobID);

            if($data['jobDetails'])
            {
                if($data['jobDetails']->job_cover_img <> null)
                {
                    $jobImage            = $this->getUserPath($folderName = 'job', ($data['jobDetails'] ? $data['jobDetails']->userID : null) );
                    $data['jobLogo']     = $jobImage . $data['jobDetails']->job_cover_img;
                }else{
                    $jobImage            = $this->getUserPath($folderName = 'profile', ($data['jobDetails'] ? $data['jobDetails']->userID : null) );
                    $data['jobLogo']     = $jobImage . $data['jobDetails']->profile_picture;
                }
            }
            //Get Current user - cover letter and cv
            $data['coverLetter'] = CoverLetterModel::where('userID', $this->getUserID())->value('cover_letter');
            $data['allMyCv']     = UploadCVModel::where('userID', $this->getUserID())->get();
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'JobListingAndSearchController@getJobDetails', 'Error occured when creating job listing/search.' );
        }
        return $this->checkViewBeforeRender('jobListing.jobListingDetailsPage', $data);
    }


    //Apply For Job
    public function applyForJob(Request $request)
    {
        if(!Auth::check())
        {
            return redirect()->route('login');
        }
        $data = [];
        $submitted = 0;
        $this->validate($request,
         [
             //'coverLetter'  => ['required', 'max: 20000'],
             'myCv'         => ['required', 'string'],
             'jobName'      => ['required', 'string'],
         ]);
        try{
            if($request['myCv'] && !(JobApplyModel::where('candidateID', $this->getUserID())->where('jobID', $request['jobName'])->first()))
            {
                $submitted = JobApplyModel::create([
                    'candidateID'       => $this->getUserID(),
                    'jobID'             => $request['jobName'],
                    'cvID'              => $request['myCv'],
                    'cover_letter'      => $request['coverLetter'],
                    'created_at_time'   => date('Y-m-d h:i:s a'),
                    'created_at'        => date('Y-m-d'),
                    'updated_at'        => date('Y-m-d'),
                ]);
            }
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'JobListingAndSearchController@applyForJob', 'Error occured when creating job listing/search.' );
        }
        if($submitted)
        {
            return redirect()->route('searchJob')->with('message', 'Your application was submitted successfully.');
        }
        return redirect()->route('searchJob')->with('warning', 'Sorry, you cannot apply for this job now! It may be because you have applied already. Please try again later.');
    }


    //############################ Get Sector/Industry ################################
    public function getCategoryAndSection()
    {
        $data = [];
        try{
            //location
            $getAllJobLocation = Cache::remember('cacheKeyIndexAllJobLocation', $this->appCacheTime(), function ()
            {
                return PostJobModel::where('job_status', '>', 0)->where('status', 1)->where('job_location', '<>', null)->distinct()->select('job_location')->get();
            });
            $data['getAllJobLocation'] = $getAllJobLocation;
            //category
            $getAllSector = Cache::remember('cacheKeyIndexDataCategory', $this->appCacheTime(), function ()
            {
                return IndustryModel::where($this->industryModel->getTable().'.status', 1)
                    ->leftJoin($this->postJobModel->getTable(), $this->postJobModel->getTable().'.job_category', '=', $this->industryModel->getTable().'.industryID')
                    ->orderBy($this->industryModel->getTable().'.industry_name', 'Asc')
                    ->get();
            });
            $data['allCategory'] = $getAllSector;
            //Get all Job Type
            try{
                $getJobType = Cache::remember('cacheKeyIndexDataJobType', $this->appCacheTime(), function ()
                {
                    return JobTypeModel::where('status', 1)->get();
                });
                $data['getJobType'] = $getJobType;
            }catch(\Throwable $errorThrown){
                $this->storeTryCatchError($errorThrown, 'IndexController@index-JobType', 'Error occured when Getting all job type.' );
            }
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'JobListingAndSearchController@getCategoryAndSection', 'Error occured when getting category and location.' );
        }
        return $data;
    }
}//end class
