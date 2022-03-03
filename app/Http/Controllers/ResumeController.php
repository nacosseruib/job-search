<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CoverLetterModel;
use App\Models\GradeModel;
use App\Models\EducationModel;
use App\Models\CertificateModel;
use App\Models\WorkExperienceModel;
use App\Models\ProfessionalSkillModel;
use App\Models\UploadCVModel;
use Cache;
use Session;


class ResumeController extends BaseParentController
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->getAllModel();
    }


    ########### QUERY RESUME #########
    public function getResumeData($userID = null)
    {
        $data = [];
        try{
            $userID = ($userID ? $userID : $this->getUserID());
            $data['getPath']            = $this->getUserPath('document');
            $data['userProfile']        = $this->getUserProfile($userID);
            $data['coverLetter']        = CoverLetterModel::where('userID', $userID)->where('status', 1)->value('cover_letter');
            $data['certificateTitle']   = CertificateModel::where('status', 1)->get();
            $data['grade']              = GradeModel::where('status', 1)->get();
            $data['getAllEducation']    = EducationModel::where($this->educationModel->getTable().'.userID', $userID)->where($this->educationModel->getTable().'.status', 1)
                                        ->leftjoin($this->certificateModel->getTable(), $this->certificateModel->getTable().'.certificateID', '=', $this->educationModel->getTable().'.certificate_titleID')
                                        ->leftjoin($this->gradeModel->getTable(), $this->gradeModel->getTable().'.gradeID', '=', $this->educationModel->getTable().'.grade_id')
                                        ->orderBy($this->educationModel->getTable().'.educationID', 'Desc')
                                        ->get();
            $data['getAllworkExperience'] = WorkExperienceModel::where('userID', $userID)->where('status', 1)->orderBy($this->workExperienceModel->getTable().'.work_experienceID', 'Desc')->get();
            $data['getAllProfessionalSkill'] = ProfessionalSkillModel::where('userID', $userID)->where('status', 1)->orderBy('skillID', 'Desc')->get();
            $data['getAllCv'] = UploadCVModel::where('userID', $userID)->where('status', 1)->orderBy('candidate_cvID', 'Desc')->get();
            $data['months'] = $this->monthArrayString();
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'ResumeController@createResume', 'Error occured on GET Request when trying to create my resume' );
        }
        return $data;
    }


    ########### VIEW COMPLETE RESUME #########
    public function viewResumeDetails($userID = null)
    {
        $data = [];
        try{
            $userID = ($userID ? $userID : $this->getUserID());
            $data = $this->getResumeData($userID);
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'ResumeController@createResume', 'Error occured on GET Request when trying to create my resume' );
        }
        return $this->checkViewBeforeRender('candidate.myResume.viewResumeDetailsPageView', $data);
    }


    //View Resume
    public function createResume()
    {
        $data       = [];
        $userID     = $this->getUserID();
        try{
            $data = $this->getResumeData($userID);
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'ResumeController@createResume', 'Error occured on GET Request when trying to create my resume' );
        }
        return $this->checkViewBeforeRender('candidate.myResume.resumePage', $data);
    }

    ################################ COVER LETTER #####################################
    //update Cover letter
    public function updateCoverLetter(Request $request)
    {
        $completed  = 0;
        $this->validate($request,
        [
            'coverLetter'           => ['required', 'string'],
        ]);
        try{
            $completed = CoverLetterModel::updateOrCreate(
                [
                    'userID'        => $this->getUserID(),
                ],
                [
                    'cover_letter'  => $request['coverLetter'],
                    'updated_at'    => date('Y-m-d'),
                ]
            );
            if($completed)
            {
                return redirect()->route('createResume')->with('success', 'Your cover letter was updated successfully.');
            }
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'ResumeController@updateCoverLetter', 'Error occurred when updating user profile photos' );
        }
        return redirect()->route('createResume')->with('error', 'Sorry, we cannot update your cover letter now! Please try again later.');
    }


    ################################ ADD EDUCATION #####################################
     //Add New Education
     public function addNewEducation(Request $request)
     {
         $completed  = 0;
         $this->validate($request,
         [
             'certificateTitle'     => ['required', 'numeric'],
             'courseTitle'          => ['required', 'string', 'max: 150'],
             'dateStarted'          => ['required', 'date'],
             'dateCompleted'        => ['required', 'date'],
             'institute'            => ['required', 'string', 'max:200'],
             //'grade'                => ['required', 'numeric'],
         ]);
         try{
             $completed = EducationModel::Create(
                [
                    'userID'                => $this->getUserID(),
                    'certificate_titleID'   => $request['certificateTitle'],
                    'course_title'          => $request['courseTitle'],
                    'date_started'          => $request['dateStarted'],
                    'date_completed'        => $request['dateCompleted'],
                    'institution'           => $request['institute'],
                    'grade_id'               => $request['grade'],
                    'created_at'            => date('Y-m-d'),
                    'updated_at'            => date('Y-m-d'),
                ]
             );
             if($completed)
             {
                 return redirect()->route('createResume')->with('success', 'You have successfully added new education.');
             }
         }catch(\Throwable $errorThrown){
             $this->storeTryCatchError($errorThrown, 'ResumeController@addNewEducation', 'Error occurred when creating user education' );
         }
         return redirect()->route('createResume')->with('error', 'Sorry, we cannot add new education now! Please try again later.');
     }


     //Save changes to Education
     public function educationSaveChanges(Request $request)
     {
         $completed  = 0;
         $this->validate($request,
         [
             'certificateTitle'     => ['required', 'numeric'],
             'courseTitle'          => ['required', 'string', 'max: 150'],
             'dateStarted'          => ['required', 'date'],
             'dateCompleted'        => ['required', 'date'],
             'institute'            => ['required', 'string', 'max:200'],
             'grade'                => ['required', 'numeric'],
             'educationID'          => ['required', 'numeric'],
         ]);
         try{
             $completed = EducationModel::updateOrCreate(
                [
                    'userID'                => $this->getUserID(),
                    'educationID'           => $request['educationID'],
                ],
                [
                    'certificate_titleID'   => $request['certificateTitle'],
                    'course_title'          => $request['courseTitle'],
                    'date_started'          => $request['dateStarted'],
                    'date_completed'        => $request['dateCompleted'],
                    'institution'           => $request['institute'],
                    'grade_id'              => $request['grade'],
                    'updated_at'            => date('Y-m-d'),
                ]
             );
             if($completed)
             {
                 return redirect()->route('createResume')->with('success', 'You have successfully updated your record. ');
             }
         }catch(\Throwable $errorThrown){
             $this->storeTryCatchError($errorThrown, 'ResumeController@educationSaveChanges', 'Error occurred when updating education details' );
         }
         return redirect()->route('createResume')->with('error', 'Sorry, we cannot update your details now! Please try again later.');
     }
     //

     //Save changes to Education
     public function deleteEducation($educationID = null)
     {
        $userID = $this->getUserID();
        $completed  = 0;
        try{
            $getEducation = EducationModel::where('educationID', $educationID)->where('userID', $userID)->first();
            if($getEducation)
            {
                $completed = $getEducation->delete();
            }
            if($completed)
            {
                return redirect()->route('createResume')->with('success', 'Your record was successfully deleted.');
            }
         }catch(\Throwable $errorThrown){
             $this->storeTryCatchError($errorThrown, 'ResumeController@deleteEducation', 'Error occurred when deleting education details' );
         }
         return redirect()->route('createResume')->with('error', 'Sorry, we cannot delete your record now! Please try again later.');
     }
     //


     ################################ ADD WORK EXPERIECE ##############################
     //Add New Work
     public function addNewWorkExperience(Request $request)
     {
         $completed  = 0;
         $this->validate($request,
         [
             'jobTitle'             => ['required', 'string', 'max: 2000'],
             'companyName'          => ['required', 'string', 'max: 2000'],
             'dateStarted'          => ['required', 'date'],
             'dateStop'             => ['required', 'date'],
             'jobDescription'       => ['required', 'string'],
         ]);
         try{
             $completed = WorkExperienceModel::Create(
                [
                    'userID'                => $this->getUserID(),
                    'job_title'             => $request['jobTitle'],
                    'company_name'          => $request['companyName'],
                    'date_started'          => $request['dateStarted'],
                    'date_stop'             => $request['dateStop'],
                    'job_description'       => $request['jobDescription'],
                    'created_at'            => date('Y-m-d'),
                    'updated_at'            => date('Y-m-d'),
                ]
             );
             if($completed)
             {
                 return redirect()->route('createResume')->with('success', 'You have successfully added new work and experience.');
             }
         }catch(\Throwable $errorThrown){
             $this->storeTryCatchError($errorThrown, 'ResumeController@addNewWorkExperience', 'Error occurred when creating work and experience' );
         }
         return redirect()->route('createResume')->with('error', 'Sorry, we cannot add new work and experience now! Please try again later.');
     }

     //Save changes
     public function workExperienceSaveChanges(Request $request)
     {
         $completed  = 0;
         $this->validate($request,
         [
            'jobTitle'             => ['required', 'string', 'max: 2000'],
            'companyName'          => ['required', 'string', 'max: 2000'],
            'dateStarted'          => ['required', 'date'],
            'dateStop'             => ['required', 'date'],
            'jobDescription'       => ['required', 'string'],
            'workExperienceID'     => ['required'],
         ]);
         try{
             $completed = WorkExperienceModel::updateOrCreate(
                [
                    'userID'                => $this->getUserID(),
                    'work_experienceID'     => $request['workExperienceID'],
                ],
                [
                    'job_title'             => $request['jobTitle'],
                    'company_name'          => $request['companyName'],
                    'date_started'          => $request['dateStarted'],
                    'date_stop'             => $request['dateStop'],
                    'job_description'       => $request['jobDescription'],
                    'updated_at'            => date('Y-m-d'),
                ]
             );
             if($completed)
             {
                 return redirect()->route('createResume')->with('success', 'You have successfully updated your record. ');
             }
         }catch(\Throwable $errorThrown){
             $this->storeTryCatchError($errorThrown, 'ResumeController@workExperienceSaveChanges', 'Error occurred when updating work experience details' );
         }
         return redirect()->route('createResume')->with('error', 'Sorry, we cannot update your details now! Please try again later.');
     }
     //

     //Save changes
     public function deleteWorkExperience($getWorkExperienceID = null)
     {
        $userID = $this->getUserID();
        $completed  = 0;
        try{
            $modelDetails = WorkExperienceModel::where('work_experienceID', $getWorkExperienceID)->where('userID', $userID)->first();
            if($modelDetails)
            {
                $completed = $modelDetails->delete();
            }
            if($completed)
            {
                return redirect()->route('createResume')->with('success', 'Your record was successfully deleted.');
            }
         }catch(\Throwable $errorThrown){
             $this->storeTryCatchError($errorThrown, 'ResumeController@deleteWorkExperience', 'Error occurred when deleting work experience details' );
         }
         return redirect()->route('createResume')->with('error', 'Sorry, we cannot delete your record now! Please try again later.');
     }
     //


      ################################ ADD PROFESSION SKILL ##############################
     //Add New Skill
     public function addNewSkill(Request $request)
     {
         $completed  = 0;
         $this->validate($request,
         [
             'skillTitle'          => ['required', 'string', 'max: 2000'],
             'efficiency'          => ['required', 'numeric'],
             'yearOfExperience'    => ['required', 'numeric'],
         ]);
         try{
             $completed = ProfessionalSkillModel::Create(
                [
                    'userID'                => $this->getUserID(),
                    'skill_title'           => $request['skillTitle'],
                    'efficiency'            => $request['efficiency'],
                    'year_of_experience'    => $request['yearOfExperience'],
                    'created_at'            => date('Y-m-d'),
                    'updated_at'            => date('Y-m-d'),
                ]
             );
             if($completed)
             {
                 return redirect()->route('createResume')->with('success', 'You have successfully added new professional skill.');
             }
         }catch(\Throwable $errorThrown){
             $this->storeTryCatchError($errorThrown, 'ResumeController@addNewSkill', 'Error occurred when creating profession skill' );
         }
         return redirect()->route('createResume')->with('error', 'Sorry, we cannot add new skill now! Please try again later.');
     }

     //Save changes to Education
     public function skillSaveChanges(Request $request)
     {
         $completed  = 0;
         $this->validate($request,
         [
            'skillTitle'          => ['required', 'string', 'max: 2000'],
            'efficiency'          => ['required', 'numeric'],
            'yearOfExperience'    => ['required', 'numeric'],
         ]);
         try{
             $completed = ProfessionalSkillModel::updateOrCreate(
                [
                    'userID'                => $this->getUserID(),
                    'skillID'               => $request['skillID'],
                ],
                [
                    'skill_title'           => $request['skillTitle'],
                    'efficiency'            => $request['efficiency'],
                    'year_of_experience'    => $request['yearOfExperience'],
                    'updated_at'            => date('Y-m-d'),
                ]
             );
             if($completed)
             {
                 return redirect()->route('createResume')->with('success', 'You have successfully updated your record. ');
             }
         }catch(\Throwable $errorThrown){
             $this->storeTryCatchError($errorThrown, 'ResumeController@skillSaveChanges', 'Error occurred when updating profession skill' );
         }
         return redirect()->route('createResume')->with('error', 'Sorry, we cannot update your details now! Please try again later.');
     }
     //

     //Save changes to Education
     public function deleteSkill($skillID = null)
     {
        $completed  = 0;
        try{
            $modelDetails = ProfessionalSkillModel::where('skillID', $skillID)->where('userID', $this->getUserID())->first();
            if($modelDetails)
            {
                $completed = $modelDetails->delete();
            }
            if($completed)
            {
                return redirect()->route('createResume')->with('success', 'Your record was successfully deleted.');
            }
         }catch(\Throwable $errorThrown){
             $this->storeTryCatchError($errorThrown, 'ResumeController@deleteSkill', 'Error occurred when deleting skill details' );
         }
         return redirect()->route('createResume')->with('error', 'Sorry, we cannot delete your record now! Please try again later.');
     }
     //



      ################################ ADD/UPLOAD CV ##############################
     //Add New CV
     public function uploadCv(Request $request)
     {
        $uploadCompletePathName = $this->uploadPath() . 'document/';
        $completed  = 0;

         $this->validate($request,
         [
             'cvFile'               => ['required', 'mimes:pdf'], /* png,jpg,jpe,jpeg,doc,docx, */
             'fileDescription'      => ['required', 'string', 'max: 100'],
         ]);
         try{
            if($request->hasFile('cvFile'))
            {
                $getArrayResponse = $this->uploadAnyFile($request['cvFile'], $uploadCompletePathName, $maxFileSize = 10, $newExtension = null, $newRadFileName = true);
                if($getArrayResponse)
                {
                    if($getArrayResponse['success']){
                        $completed = UploadCVModel::create([
                            'userID'            => $this->getUserID(),
                            'file_description'  => $request['fileDescription'],
                            'file_name'         => $getArrayResponse['newFileName'],
                            'created_at'        => date('Y-m-d'),
                            'updated_at'        => date('Y-m-d'),
                        ]);
                    }
                }
            }

            if($completed)
            {
                return redirect()->route('createResume')->with('success', 'You have successfully uploaded a new CV.');
            }
         }catch(\Throwable $errorThrown){
             $this->storeTryCatchError($errorThrown, 'ResumeController@uploadCv', 'Error occurred when uploading CV' );
         }
         return redirect()->route('createResume')->with('error', 'Sorry, we cannot upload your new CV now! Please try again later.');
     }

     //Delete CV
     public function deleteCv($cvID = null)
     {
        $userID = $this->getUserID();
        $completed  = 0;
        try{
            $modelDetails = UploadCVModel::where('candidate_cvID ', $cvID)->where('userID', $userID)->first();
            if($modelDetails)
            {
                $completed = $modelDetails->delete();
            }
            if($completed)
            {
                return redirect()->route('createResume')->with('success', 'Your record was successfully deleted.');
            }
         }catch(\Throwable $errorThrown){
             $this->storeTryCatchError($errorThrown, 'ResumeController@deleteCv', 'Error occurred when deleting skill details' );
         }
         return redirect()->route('createResume')->with('error', 'Sorry, we cannot delete your record now! Please try again later.');
     }
     //




}//end class
