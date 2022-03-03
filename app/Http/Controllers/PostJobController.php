<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IndustryModel;
use App\Models\JobTypeModel;
use App\Models\PostJobModel;
use App\Models\UserProfileModel;
use App\Models\JobApplyModel;
use Session;
use Cache;
use Auth;
use View;

class PostJobController extends BaseParentController
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->getAllModel();
    }


    //Load Job page
    public function createNewPostJob()
    {
        $data       = [];
        try{
            $data['allCategories']  = IndustryModel::where('status', 1)->get();
            $data['allJobType']     = JobTypeModel::where('status', 1)->get();
            $data['jobDetails']     = Session::get('jobDetails');
            $data['getCompanyDetails'] = UserProfileModel::where('userID', $this->getUserID())->value('about_company');
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'PostJobController@createNewPostJob', 'Error occured on GET Request when creating new job.' );
        }
        Session::forget('jobDetails');
        return $this->checkViewBeforeRender('employer.postJob.postJobPage', $data);
    }


    //Upload Job - Save Job
    public function saveNewPostJob(Request $request)
    {
            $complete               = 0;
            $userID                 = $this->getUserID();
            $uploadCompletePathName = $this->uploadPath() . 'job/';
            $uploadCompletePathNameThumbnail300X300 = $uploadCompletePathName . '300x300/';
            $uploadCompletePathNameThumbnail500X500 = $uploadCompletePathName . '500x500/';

            //validation
            $this->validate($request,
            [
                //'jobID'                     => ['required'],
                'jobTitle'                  => ['required', 'string', 'max:200'],
                'category'                  => ['required', 'numeric'],
                'jobType'                   => ['required', 'numeric'],
                'datePosted'                => ['required', 'date'],
                'expireDate'                => ['required', 'date'],
                //'location'                => ['required', 'string', 'max:190'],
                'country'                   => ['required', 'string', 'max:190'],

                'jobDescription'            => ['required', 'string'],
                //'jobRequirement'            => ['required', 'string'],
                //'jobEducationExperience'    => ['required', 'string'],
                'aboutCompnay'              => ['required', 'string'],
                'jobStatus'                 => ['required', 'numeric', 'max:1'],
                'jobEmail'                  => ['required', 'string', 'max:190'],
                'jobSalary'                 => ['required', 'string', 'max:99999999'],
                //'contactName'            => ['required', 'string', 'max:190'],
                //'contactPhoneNo'         => ['required', 'string', 'max:100'],
                //'jobCompanyName'           => ['required', 'string', 'max:190'],
                //'jobCoverImage'           => ['required', 'string'],
            ]);
            if($request->hasFile('jobCoverImage'))
            {
                $this->validate($request,
                [
                    'jobCoverImage'          => ['image', 'mimes:png,jpg,jpe,jpeg,gif', 'max: 2100'],
                ]);
            }
        try{
            //Upload File
            if($userID)
            {
                    $complete = PostJobModel::updateOrCreate(
                        [
                            'userID'                => $userID,
                            'jobID'                 => $request['jobID']
                        ],
                        [
                            'job_token'                 => $this->generateRandomAlphaNumeric(15),
                            'job_status'                => $request['jobStatus'],
                            'job_category'              => $request['category'],
                            'job_title'                 => $request['jobTitle'],
                            'job_type'                  => $request['jobType'],
                            'job_post_date'             => $request['datePosted'],
                            'job_expire_date'           => $request['expireDate'],
                            'job_description'           => $request['jobDescription'],
                            'job_requirement'           => $request['jobRequirement'],
                            'job_education_experience'  => $request['jobEducationExperience'],
                            'job_about_company'         => $request['aboutCompnay'],
                            'job_contact_phone'         => $request['contactPhoneNo'],
                            'job_contact_name'          => $request['contactName'],
                            'job_country'               => $request['country'],
                            'job_location'              => $request['location'],
                            'job_apply_email'           => $request['jobEmail'],
                            'job_company_name'          => $request['jobCompanyName'],
                            'job_salary'                => $this->removeCommaFromString($request['jobSalary']),
                            'created_at'                => date('Y-m-d'),
                            'updated_at'                => date('Y-m-d'),
                            'updated_at_time'           => date('Y-m-d h:i:s a'),
                        ]
                    );
                if($complete)
                {
                    //Upload Product Images
                    if($request->hasFile('jobCoverImage'))
                    {
                        $getArrayResponse = $this->uploadAnyFile($request['jobCoverImage'], $uploadCompletePathName, $maxFileSize = 10, $newExtension = null, $newRadFileName = true);
                        if($getArrayResponse)
                        {
                                if($getArrayResponse['success'])
                                {
                                    PostJobModel::where('jobID', $complete->jobID)->update([
                                        'job_cover_img'         => $getArrayResponse['newFileName'],
                                        'updated_at'        => date('Y-m-d'),
                                    ]);
                                }
                                //Resize Product Thumbnail - 300X300
                                $this->createThumbnail($uploadCompletePathName . $getArrayResponse['newFileName'], $uploadCompletePathNameThumbnail300X300 . $getArrayResponse['newFileName'], $width = 300, $height = 300);
                                //Resize Product Thumbnail - 500X500
                                $this->createThumbnail($uploadCompletePathName . $getArrayResponse['newFileName'], $uploadCompletePathNameThumbnail500X500 . $getArrayResponse['newFileName'], $width = 500, $height = 500, $is_resize_canvas = 0);
                        }
                    }
                    return redirect()->route('createPostJob')->with('message', 'Your job was saved successfully. (Make payment for this job to go live)');
                }
            }
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'PostJobController@saveNewPostJob', 'Error occured on POST Request when saving a new job' );
        }
        return redirect()->route('goTostoreHome')->with('error', 'Sorry, we cannot post your job now! Please review and try again.');

    }//end fun



    ######################### VIEW JOB DEATILS ########################
    //View job details
    public function createJobDetails($jobID = null)
    {
        $data = null;
        try{
            if(PostJobModel::find($jobID))
            {
                //Get job deatils
                $data['getUserPath']    = $this->getUserPath($folderName = 'job');
                $data['jobDetails'] = $this->getSingleJob($jobID);
                return $this->checkViewBeforeRender('employer.postJob.ViewJobDetailsPage', $data);
            }else{
                return redirect()->back()->with('warning', 'Sorry, we cannot not view this job now. Please try again.');
            }
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'PostJobController@createJobDetails', 'Error occured when creating job details.' );
        }
    }


    #################### MANAGE ALL MY JOBS BY ADMINISTRATOR ##################################
    //UPDATE JOB
    public function createManageJobAdmin()
    {
        try{
            $data['getUserPath']    = $this->getUserPath($folderName = 'job');
            //$userID                 = $this->getUserID();
            $getAllJobs             = $this->getAllJobWithTotalApplication(null, $pagination = 500);
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'PostJobController@createManageJobAdmin', 'Error occured when creating job list by Admin.' );
        }
        return $this->checkViewBeforeRender('admin.manageJobAdmin.manageJobAdminPage', $data)->with($getAllJobs);
    }
    ###########################END AMDIN#############################################


    #################### MANAGE ALL MY JOBS BY EMPLOYER ##################################
    //UPDATE JOB
    public function createManageJob()
    {
        try{
            $data['getUserPath']    = $this->getUserPath($folderName = 'job');
            $userID                 = $this->getUserID();
            $getAllJobs             = $this->getAllJobWithTotalApplication($userID, $pagination = 500);
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'PostJobController@createJobDetails', 'Error occured when creating job list.' );
        }
        return $this->checkViewBeforeRender('employer.manageJob.manageJobPage', $data)->with($getAllJobs);
    }
    ########################################################################


    ########### EDIT JOB ###########
    public function editPostedJob($jobID = null)
    {
        try{
            $getJob = PostJobModel::find($jobID);
            if($getJob)
            {
                Session::put('jobDetails', $this->getSingleJob($jobID));
            }
            return redirect()->route('createPostJob')->with('info', 'You can edit your job now.');
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'PostJobController@editPostedJob', 'Error occured when deleting job.' );
        }
        return redirect()->back()->with('warning', 'Sorry, we cannot edit this record now! Please try again later.');
    }


    ########### EDIT JOB ###########
    public function cancelEditPostedJob()
    {
        Session::forget('jobDetails');

        return redirect()->route('createEmployerManageJob')->with('info', 'Your job editing was cancelled.');
    }


    ########### DELETE JOB ##########
    public function deletePostedJob($jobID = null)
    {
        try{
            $getJob = PostJobModel::find($jobID);
            if($getJob)
            {
                $getJob->delete();
            }
            return redirect()->back()->with('success', 'Your job was permanently deleted successfully.');
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'PostJobController@deletePostedJob', 'Error occured when deleting job.' );
        }
        return redirect()->back()->with('warning', 'Sorry, we cannot delete this job now! Please try again later.');
    }

}//end clas
