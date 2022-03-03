<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserProfileModel;
use App\Models\UserTypeModel;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Cache;
use Session;


class ChangePasswordController extends BaseParentController
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->getAllModel();
    }

    //View Profile
    public function createChangePassword()
    {
        $data = [];

        try{

        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'ProfileController@createProfile', 'Error occured on GET Request when trying to create user profile' );
        }
        return $this->checkViewBeforeRender('candidate.changePassword.passwordPage', $data);
    }


    ################### SAVE CHANGE PASSWORD #########
    public function saveUpdatePasswordOnAuth(Request $request)
    {
        $this->validate($request,
         [
            'currentPassword'   => ['required', 'string', 'min:5'],
            'password'          => ['required', 'string', 'min:6', 'confirmed']
         ]);
        $isChanged = 0;
        try{
            $updateAccount = User::find($this->getUserID());
            //avoid user entering the same password
            if($updateAccount && Hash::check($request['password'], $updateAccount->password))
            {
                return redirect()->route('changePassword')->with('error', 'Sorry, you cannot enter the same password as your current password!');
            }

            if($updateAccount && Hash::check($request['currentPassword'], $updateAccount->password))
            {
                $updateAccount->password = Hash::make($request['password']);
                $isChanged               =  $updateAccount->update();
                if($isChanged)
                {
                    return redirect()->route('changePassword')->with('message', 'Your password was changed successfully.');
                }
            }else{
                return redirect()->route('changePassword')->with('error', 'Sorry, your have entered wrong current password!');
            }

        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'ProfileController@saveUpdatePasswordOnAuth', 'Error occured on POST Request when try to update password.' );
        }
        return redirect()->route('changePassword')->with('error', 'Sorry, we could not change your password! Please try again.');
    }





}//end class
