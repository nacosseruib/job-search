<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserProfileModel;
use App\Models\UserTypeModel;
use App\Models\IndustryModel;
use App\Models\User;
use Cache;
use Session;


class ProfileController extends BaseParentController
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->getAllModel();
    }

    //create Profile
    public function createCandidateProfile()
    {
        $data = [];
        try{
            $data['userProfile'] = $this->getUserProfile($userID = null);
            $data['months'] = $this->monthArrayString();
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'ProfileController@createCandidateProfile', 'Error occured on GET Request when trying to create user profile' );
        }
        return $this->checkViewBeforeRender('candidate.profile.profilePage', $data);
    }


    //Save Candidate file changes
    public function saveChangesCandidateBasicInformation(Request $request)
    {
        //Validate
        $this->validate($request,
        [
           'firstName'             => ['required', 'string', 'max:200'],
           'lastName'              => ['required', 'string', 'max:200'],
           'dayOfYourBirth'        => ['required', 'numeric', 'max:200'],
           'monthOfYourBirth'      => ['required', 'string', 'max:200'],
           'yearOfYourBirth'       => ['required', 'numeric', 'max:9999'],
           'gender'                => ['required', 'string', 'max:200'],
           'location'              => ['required', 'string', 'max:200'],
           'country'               => ['required', 'string', 'max:200'],
           'countryCode'           => ['required', 'string', 'max:200'],
           'phoneNumber'           => ['required', 'string', 'min:6', 'max:200'],
           'emailAddress'          => ['required', 'string', 'min:6', 'max:200'],
        ]);
        try{
            //create user profile details
            $profileCreated =  UserProfileModel::updateOrCreate(
                [  'userID'            => $this->getUserID()],
                [
                   'first_name'        => $request['firstName'],
                   'last_name'         => $request['lastName'],
                   'day_of_birth'      => $request['dayOfYourBirth'],
                   'month_of_birth'    => $request['monthOfYourBirth'],
                   'year_of_birth'     => $request['yearOfYourBirth'],
                   'gender'            => $request['gender'],
                   'country'           => $request['country'],
                   'location_city'     => $request['location'],
                   'country_code'      => $request['countryCode'],
                   'phone_number'      => $request['phoneNumber'],
                   'facebook'          => $request['facebook'],
                    'twitter'          => $request['twitter'],
                    'linkedin'         => $request['linkedin'],
                    'instagram'        => $request['instagram'],
                   'updated_at'        => date('Y-m-d'),
                   'updated_at_time'   => date('d-m-Y h:i:sa')
                ]
            );
               if($profileCreated)
                {
                    if(!User::where('id', '<>', $this->getUserID())->where('email', $request['emailAddress'])->first())
                    {
                        $emailStatus = "";
                        $userCreated =  User::where('id', $this->getUserID())->update([
                            'email'         => $request['emailAddress'],
                        ]);
                    }else{
                        $emailStatus = "Sorry, we cannot update you email! Email already exist.";
                    }


                    return redirect()->route('candidateProfile')->with('message', 'Your profile was updated successfully. '. $emailStatus);
               }else{
                    return redirect()->back()->with('warning', 'Sorry we cannot update your registration now! Please try again.');
               }

        }catch(\Throwable $errorThrown)
        {
           $this->storeTryCatchError($errorThrown, 'RegisterController@saveRegistrationCandidate', 'Error occured on POST Request when creating candidate registration.' );
        }
        return redirect()->back()->with('error', 'Sorry, an error occurred while creating your account. Please try again.')->withInput();
    }//



    //Create Employer Profile
    public function createEmployerProfile()
    {
        $data = [];
        try{
            $data['userProfile'] = $this->getUserProfile();
            $data['months'] = $this->monthArrayString();
            $data['userType'] = UserTypeModel::where('status', 1)->get();
            $data['allIndustries'] = IndustryModel::where('status', 1)->get();
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'ProfileController@createEmployerProfile', 'Error occured on GET Request when trying to create user profile' );
        }
        return $this->checkViewBeforeRender('employer.profile.profilePage', $data);
    }

    //Update Employer Profile
    public function saveChangesEmployerBasicInformation(Request $request)
    {
        //Validate
        $this->validate($request,
        [
           'contactFullName'        => ['required', 'string', 'max:200'],
           'contactEmail'           => ['required', 'string', 'max:200'],
           'companyName'            => ['required', 'string', 'max:200'],
           'industry'               => ['required', 'numeric'],
           'countryCode'            => ['required', 'string', 'max:200'],
           'companyPhoneNumber'     => ['required', 'string', 'max:200'],
           'country'                => ['required', 'string', 'max:200'],
           'location'               => ['required', 'string', 'max:200'],
           'noOfEmployees'          => ['required', 'string', 'max:200'],
           'typeOfEmployer'         => ['required', 'string', 'max:200'],
           //'companyWebsite'         => ['required', 'string'],
           //'aboutCompnay'         => ['required', 'string'],
           'address'                => ['required', 'string', 'max:2000'],
           'firstName'              => ['required', 'string', 'max:200'],
           'lastName'               => ['required', 'string', 'max:200'],
           'userProfileId'          => ['required', 'string'],
        ]);
        try{
            //update user profile details
            $profileCreated =  UserProfileModel::where('userID', $this->getUserID())->where('user_profileID', $request['userProfileId'])->update(
                   [
                   'contact_name'           => $request['contactFullName'],
                   'contact_email'          => $request['contactEmail'],
                   'company_name'           => $request['companyName'],
                   'company_industry_id'    => $request['industry'],
                   'country_code'           => $request['countryCode'],
                   'phone_number'           => $request['companyPhoneNumber'],
                   'country'                => $request['country'],
                   'location_city'          => $request['location'],
                   'number_of_employee'     => $request['noOfEmployees'],
                   'company_Website'        => $request['companyWebsite'],
                   'address'                => $request['address'],
                   'about_company'          => $request['aboutCompnay'],
                   'first_name'             => $request['firstName'],
                   'last_name'              => $request['lastName'],
                   'updated_at'             => date('Y-m-d'),
                   'updated_at_time'        => date('d-m-Y h:i:sa')
            ]);
            if($profileCreated)
            {
                User::where('id', $this->getUserID())->update([
                    'email'         => $request['emailAddress'],
                    'user_type'     => $request['typeOfEmployer'],
                ]);

                Cache::forget('cacheKeyUserFullName');
                return redirect()->back()->with('message', 'Your profile was updated successfully.');
            }
        }catch(\Throwable $errorThrown)
        {
           $this->storeTryCatchError($errorThrown, 'ProfileController@saveChangesEmployerBasicInformation', 'Error occured on POST Request when updating employer.' );
        }
        return redirect()->back()->with('error', 'Sorry, an error occurred while updating your profile. Please try again.')->withInput();
    }//



     //View Profile
     public function createProfilePhotoAndCoverImage()
     {
         $data = [];
         try{
             $data['userProfile'] = $this->getUserProfile($userID = null);
             $data['months'] = $this->monthArrayString();
         }catch(\Throwable $errorThrown){
             $this->storeTryCatchError($errorThrown, 'ProfileController@createProfile', 'Error occured on GET Request when trying to create user profile' );
         }
         return $this->checkViewBeforeRender('candidate.uploadProfileAndCoverImages.uploadImagePage', $data);
     }


     //View Profile
     public function saveProfilePhotoAndCoverImage(Request $request)
     {
        $uploadCompletePathName = $this->uploadPath() . 'profile/';
        $uploadCompletePathNameThumbnail300X300 = $uploadCompletePathName . '300x300/';
        $updatedPhoto = 0;
        $updatedCover = 0;

        if($request->hasFile('profilePhoto'))
        {
            $this->validate($request,
            [
                'profilePhoto'           => ['required'],
                'profilePhoto'           => ['image', 'mimes:png,jpg,jpe,jpeg,gif', 'max: 1400'],
            ]);
        }
        if($request->hasFile('profileCover'))
        {
            $this->validate($request,
            [
                'profileCover'           => ['required'],
                'profileCover'           => ['image', 'mimes:png,jpg,jpe,jpeg,gif', 'max: 1400'],
            ]);
        }
        try{
            $userDetails = UserProfileModel::where('userID', $this->getUserID());
            if($userDetails)
            {
                //Profile Photo
                if($request->hasFile('profilePhoto'))
                {
                    $getArrayResponse = $this->uploadAnyFile($request['profilePhoto'], $uploadCompletePathName, $maxFileSize = 10, $newExtension = null, $newRadFileName = true);
                    if($getArrayResponse['success'])
                    {
                        $updatedPhoto = UserProfileModel::updateorCreate(
                            [ 'userID'          => $this->getUserID()],
                            [
                            'profile_picture'   => $getArrayResponse['newFileName'],
                            'updated_at'        => date('Y-m-d'),
                            'updated_at_time'   => date('Y-m-d h:i:s a'),
                            ]
                        );
                        $this->createThumbnail($uploadCompletePathName . $getArrayResponse['newFileName'], $uploadCompletePathNameThumbnail300X300 . $getArrayResponse['newFileName'], $width = 300, $height = 300, $is_resize_canvas = 0);
                        Cache::forget('cacheKeyUserPhoto');
                    }
                }
                //Profile cover image
                if($request->hasFile('profileCover'))
                {
                    $getArrayResponse = $this->uploadAnyFile($request['profileCover'], $uploadCompletePathName, $maxFileSize = 10, $newExtension = null, $newRadFileName = true);
                    if($getArrayResponse['success'])
                    {
                        $updatedCover = UserProfileModel::updateorCreate(
                            [ 'userID'          => $this->getUserID()],
                            [
                            'profile_banner'   => $getArrayResponse['newFileName'],
                            'updated_at'        => date('Y-m-d'),
                            'updated_at_time'   => date('Y-m-d h:i:s a'),
                            ]
                        );
                        Cache::forget('cacheKeyUserCoverPhoto');
                    }
                }
                if($updatedPhoto || $updatedCover)
                {
                    return redirect()->route('createProfileImage')->with('success', 'Your profile photos were updated successfully.');
                }
            }
            return redirect()->route('createProfileImage')->with('warning', 'Sorry, we cannot process your upload. User details not found! Please try again later.');
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'ProfileController@saveProfilePhotoAndCoverImage', 'Error occurred when updating user profile photos' );
        }
        return redirect()->route('createProfileImage')->with('error', 'Sorry, we are having some error while processing your upload! Please try again later.');
     }



}//end class
