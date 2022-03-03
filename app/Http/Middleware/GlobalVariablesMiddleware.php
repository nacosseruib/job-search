<?php

namespace App\Http\Middleware;

use Closure;
use response;
use App\Http\Controllers\BaseParentController;
use Cache;
use Auth;
use DB;
use view;



class GlobalVariablesMiddleware
{
    private $cacheTimeInMininutes;
    /*Cache::Put ()
    Cache::Get()
    Cache::Forever()
    Cache::Has()
    Cache::pull('key');
    Cache ::put(key, value , 15);*/


    public function handle($request, Closure $next)
    {
        //Get instance to BaseParentController
        $globalVariable             = [];

        $baseParentFunction = new BaseParentController;
        $this->baseParentFunction = $baseParentFunction;

        //Get cache time
        try{
            $getCacheTime = Cache::remember('cacheKeyAppCacheTime', 60, function () {
                return $this->baseParentFunction->appCacheTime();
            });
            $this->cacheTimeInMininutes = $getCacheTime;
        } catch (\Throwable  $errorThrown) {}

        //Get user Full Name
        try{
            $name = Cache::remember('cacheKeyUserFullName', 60, function () {
                return $this->baseParentFunction->getUserFullName();
            });
            $globalVariable['userFullName'] = $name;
        } catch (\Throwable  $errorThrown) {}

        //Get user Profile Image
        try{
            $profileImage = Cache::remember('cacheKeyUserPhoto', 60, function () {
                return $this->baseParentFunction->getUserPhoto();
            });
            $globalVariable['userPhoto'] = $profileImage;
        } catch (\Throwable  $errorThrown) {}

        //Get user Cover Image
        try{
            $coverImage = Cache::remember('cacheKeyUserCoverPhoto', 60, function () {
                return $this->baseParentFunction->getUserBanner($userID = null, $folderName = "profile");
            });
            $globalVariable['userCoverPhoto'] = $coverImage;
        } catch (\Throwable  $errorThrown) {}

         //My Wallet
         try{
            $walletBal = Cache::remember('cacheKeyUserWalletBalance', 0, function () {
                return $this->baseParentFunction->walletBalance($this->baseParentFunction->getUserID());
            });
            $globalVariable['walletBalance'] = $walletBal;
        } catch (\Throwable  $errorThrown) {}




        //abort(403);
        view()->share($globalVariable);
        return $next($request);
    }
}
