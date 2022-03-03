<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\AboutusModel;
use App\Models\User;
use Cache;
use Session;


class AboutUsController extends BaseParentController
{

    public function __construct()
    {
        $this->getAllModel();
    }

    //View Profile
    public function createAboutUs()
    {
        $data = null;
        try{
            $data['getAboutus'] = AboutusModel::first();
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'TermsAndConditionsController@createTermAndCondition', 'Error occured on GET Request when creating terms and conditions.' );
        }
        return $this->checkViewBeforeRender('aboutus.aboutusPage', $data);
    }


}//end class
