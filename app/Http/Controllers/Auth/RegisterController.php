<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\BaseParentController;
use App\Models\User;
use App\Models\UserTypeModel;
use App\Models\UserProfileModel;
use App\Models\IndustryModel;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Session;
use DB;

class RegisterController extends BaseParentController
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;


    public function __construct()
    {
        $this->middleware('guest');
    }

    //CREATE NEW REGISTRATION - Candidate
    public function createRegistrationCandidate()
    {
        $data   = [];
        try {
            $data['months'] = $this->monthArrayString();

        } catch (\Throwable $errorThrown) {
            $this->storeTryCatchError($errorThrown, 'createRegistration', 'Error occured on Get Request when create user registration page' );
        }
        return $this->checkViewBeforeRender('auth.register.registerPageCandidate', $data);
    }

    //CREATE NEW REGISTRATION - Employer
    public function createRegistrationEmployer()
    {
        $data   = [];
        try {
            $data['months'] = $this->monthArrayString();
            $data['userType'] = UserTypeModel::where('status', 1)->get(); 
            $data['allIndustries'] = IndustryModel::where('status', 1)->get();
        } catch (\Throwable $errorThrown) {
            $this->storeTryCatchError($errorThrown, 'createRegistration', 'Error occured on Get Request when create user registration page' );
        }

        return $this->checkViewBeforeRender('auth.register.registerPageEmployer', $data);
    }


    //Save Candidate registration
     public function saveRegistrationCandidate(Request $request)
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
            'phoneNumber'           => ['required', 'string', 'min:6', 'max:200', 'unique:user_profile,phone_number'],
            
            'username'              => ['required', 'string', 'min:6', 'max:200', 'unique:users'],
            'emailAddress'          => ['required', 'string', 'min:6', 'max:200', 'unique:users,email'],
            //'password'              => ['required', 'string', 'min:6', 'confirmed'],
            'password'              => 'required|between:8, 200|confirmed',
            'password_confirmation' => 'required ',
         ]);

         //Create user login details
         try{
             //Double check username if taken
            if(!User::where('username', $request['username'])->first() || !User::where('email', $request['emailAddress'])->first())
            {
                $userCreated =  User::create([
                    'username'      => $request['username'],
                    'email'         => $request['emailAddress'],
                    'password'      => Hash::make($request['password']),
                    'user_token'    => $this->generateRandomAlphaNumeric(36),
                ]);
            }else{
                $userCreated = 0;
                return redirect()->back()->with('info', 'Sorry we cannot complete your registration. Your username/email is already taken. Please try another one.');
            }
            if($userCreated)
            {
                //create user profile details
                $profileCreated =  UserProfileModel::create([
                    'userID'            => $userCreated->id,
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
                    'created_at'        => date('Y-m-d'),
                    'updated_at'        => date('Y-m-d'),
                    'updated_at_time'   => date('d-m-Y h:i:sa')
                ]);
                if($profileCreated)
                {
                    return redirect()->route('registerCompleted');
                }else{
                    if(User::find($userCreated->id))
                    {
                        User::find($userCreated->id)->delete();
                    }
                }
            }
         }catch(\Throwable $errorThrown)
         {
            $this->storeTryCatchError($errorThrown, 'RegisterController@saveRegistrationCandidate', 'Error occured on POST Request when creating candidate registration.' );
         }
         return redirect()->back()->with('error', 'Sorry, an error occurred while creating your account. Please try again.')->withInput();
     }//



    //Save Employer registration
    public function saveRegistrationEmployer(Request $request)
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
           'address'                => ['required', 'string', 'max:2000'],
           'firstName'              => ['required', 'string', 'max:200'],
           'lastName'               => ['required', 'string', 'max:200'],
           
           'username'               => ['required', 'string', 'min:6', 'max:200', 'unique:users'],
           'emailAddress'           => ['required', 'string', 'min:6', 'max:200', 'unique:users,email'],
           'password'               => ['required', 'string', 'min:6', 'max:200', 'confirmed'],
        ]);

        //Create user login details
        try{
            //Double check username if taken
           if(!User::where('username', $request['username'])->first() || !User::where('email', $request['emailAddress'])->first())
           {
               $userCreated =  User::create([
                   'username'      => $request['username'],
                   'email'         => $request['emailAddress'],
                   'password'      => Hash::make($request['password']),
                   'user_type'     => $request['typeOfEmployer'],
                   'user_token'    => $this->generateRandomAlphaNumeric(36),
               ]);
           }else{
               $userCreated = 0;
               return redirect()->back()->with('info', 'Sorry we cannot complete your registration. Your username/email is already taken. Please try another one.');
           }
           if($userCreated)
           {
               //create user profile details
               $profileCreated =  UserProfileModel::create([
                   'userID'                 => $userCreated->id,
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
                   'first_name'             => $request['firstName'],
                   'last_name'              => $request['lastName'],
                   'created_at'             => date('Y-m-d'),
                   'updated_at'             => date('Y-m-d'),
                   'updated_at_time'        => date('d-m-Y h:i:sa')
               ]);
               if($profileCreated)
               {
                   return redirect()->route('registerCompleted');
               }else{
                   if(User::find($userCreated->id))
                   {
                       User::find($userCreated->id)->delete();
                   }
               }
           }
        }catch(\Throwable $errorThrown)
        {
           $this->storeTryCatchError($errorThrown, 'RegisterController@saveRegistrationCandidate', 'Error occured on POST Request when creating candidate registration.' );
        }
        return redirect()->back()->with('error', 'Sorry, an error occurred while creating your account. Please try again.')->withInput();
    }//


    
     //REGISTRATION COMPLETE
     public function registrationCompleted()
     {
         return $this->checkViewBeforeRender('auth.registrationCompleted');
     }



}
