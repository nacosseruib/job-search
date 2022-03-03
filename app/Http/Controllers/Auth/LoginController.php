<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\BaseParentController;
use App\Http\Controllers\RolePermissionController;
use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use Cache;
use Auth;

class LoginController extends BaseParentController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard'; // item/collection/ RouteServiceProvider::HOME;

    //Logout
    public function __construct()
    {
        Cache::flush(); // remove all the cache data
        Session::flush(); // remove all the session data

        $this->middleware('guest')->except('logout');
    }

    //Login Form
    public function createLogin()
    {
        return view('auth.login.loginPage');
    }

    //Login
    public function attemptLogin(Request $request)
    {
        Cache::flush(); // remove all the cache data
        Session::flush(); // remove all the session data

        $this->validate($request,
        [
            'username'      => 'required|min:4',
            'password'      => 'required|min:8'
        ],['username'       => 'Email/Username']);

        try{
            $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

            if (Auth::attempt([$fieldType => $request->username, 'password' => $request->password, 'status' => 1])) {

                //prepare user role
                try{
                    $rolePermissionController = new RolePermissionController;
                    $rolePermissionController->doAfterLogin();
                }catch(\Throwable $errorThrown){}

                return redirect()->intended($this->redirectPath());
            }else{
                return redirect()->back()->with('error', 'Email/Username or Password does not correct (or you have not confirmed your account)')->withInput();
            }
        }catch(\Throwable $errorThrown)
        {
            $this->storeTryCatchError($errorThrown, 'attemptLogin', 'Error occured on POST Request when trying to login' );
            return redirect()->back()->with('error', 'Sorry, an error occurred while signing in to your account. Try again.')->withInput();
        }

    }

}
