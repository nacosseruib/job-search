<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Cache;
use App\Models\IndustryModel;
use App\Models\PostJobModel;
use App\Models\JobTypeModel;

class IndexController extends BaseParentController
{

    public function __construct()
    {
        $this->getAllModel();
    }


    public function index()
    {
        $data           = [];
        $getJobs        = [];
        $getJobType     = [];
        $getAllCompany  = [];

        //Get Jobs
        try{
            $getJobs = Cache::remember('cacheKeyIndexData', $this->appCacheTime(), function ()
            {
                $getAllJobs = $this->getAllJobWithTotalApplication($userID = null, $pagination = 100);
                return $getAllJobs;
            });
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'IndexController@index', 'Error occured when getting/list all jobs on welcome page.' );
        }
        //Category
        try{
            $getAllSector = Cache::remember('cacheKeyIndexDataCategory', $this->appCacheTime(), function ()
            {
                return IndustryModel::where($this->industryModel->getTable().'.status', 1)
                ->leftJoin($this->postJobModel->getTable(), $this->postJobModel->getTable().'.job_category', '=', $this->industryModel->getTable().'.industryID')
                ->orderBy($this->industryModel->getTable().'.industry_name', 'Asc')
                ->get();
            });
            $data['allCategory'] = $getAllSector;
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'IndexController@index-Category', 'Error occured when Getting all sectors or categories.' );
        }
        //Get all companies
        try{
            $getAllCompany = Cache::remember('cacheKeyIndexDataCompany', $this->appCacheTime(), function ()
            {
                return $this->getAllCompany($status = 'all', $pagination = 20);
            });
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'IndexController@index-Company', 'Error occured when Getting all companies.' );
        }

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

        //Get all Job Locations
        try{
            $getAllJobLocation = Cache::remember('cacheKeyIndexAllJobLocation', $this->appCacheTime(), function ()
            {
                return PostJobModel::where('job_status', '>', 0)->where('status', 1)->where('job_location', '<>', null)->distinct()->select('job_location')->get();
            });
            $data['getAllJobLocation'] = $getAllJobLocation;
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'IndexController@index-Job-Location', 'Error occured when Getting all job locations.' );
        }
        //Render view and pass data
        return $this->checkViewBeforeRender('index.welcomePage')
                    ->with($getJobs)
                    ->with($data)
                    ->with($getAllCompany);
    }
}
