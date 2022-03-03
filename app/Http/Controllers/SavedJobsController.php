<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Cache;
use Session;


class SavedJobsController extends BaseParentController
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->getAllModel();
    }


    //View Resume
    public function createSavedJobs()
    {
        $data = [];

        try{

        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'SavedJobsController@createSavedJobs', 'Error occured on GET Request when trying to create saved jobs' );
        }
        return $this->checkViewBeforeRender('candidate.savedJob.savedJobPage', $data);
    }



}//end class
