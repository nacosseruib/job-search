<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AssignSubmoduleRole;
use Illuminate\Support\Facades\Route;
use Session;

class RedirectUnauthorizedRoute
{
    public function handle($request, Closure $next)
    {
        if((Route::currentRouteName() <> null))
        {
            if(Auth::check() && (Auth::User()->user_role <> 1))
            {
                $nameRouteName = AssignSubmoduleRole::where('assign_submodule_role.roleID', Auth::User()->user_role)
                ->join('submodule', 'submodule.submoduleID', '=', 'assign_submodule_role.submoduleID')
                ->where('submodule.submodule_url', Route::currentRouteName())
                ->value('submodule_url');

                if($nameRouteName <> Route::currentRouteName())
                {
                    return redirect()->route('dashboard')->with('warning', 'You are not authorized to perform the operation !!! Please contact us for any feedback.');
                }
            }else{
                return $next($request);
            }
        }
        //
        return $next($request);
    }
}
