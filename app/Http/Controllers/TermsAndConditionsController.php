<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\TermsAndConditionsModel;
use App\Models\User;
use Cache;
use Session;


class TermsAndConditionsController extends BaseParentController
{

    public function __construct()
    {
        $this->getAllModel();
    }

    //View Profile
    public function createTermAndCondition()
    {
        $data = null;
        try{
            $data['termsConditions'] = TermsAndConditionsModel::first();
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'TermsAndConditionsController@createTermAndCondition', 'Error occured on GET Request when creating terms and conditions.' );
        }
        return $this->checkViewBeforeRender('termsAndConditions.termsAndConditionsPage', $data);
    }


}//end class
