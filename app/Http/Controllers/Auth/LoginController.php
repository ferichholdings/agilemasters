<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
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
    //protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected function redirectTo()
    {
        //dd('Status: '. auth()->user()->status. ' Role: ' . auth()->user()->role);

        if(auth()->user()->status == 'subscribed') {
            if (auth()->user()->role == 'admin') {

                return '/admin';
            } else if (auth()->user()->role == 'corporate') {
                //direct to a page where transaction don't need to enter email and name
                return '/corporate';
            } else if (auth()->user()->role == 'individual') {
                //direct to a page where transaction don't need to enter email and name
                return '/individual';
                //  redirect()->route('riders.index');
            } else if (auth()->user()->role == 'student') {///individuals of a corporate
                //direct to a page where transaction don't need to enter email and name
                return '/individual';
                //  redirect()->route('riders.index');
            } else if (auth()->user()->role == 'instructor') {
               // dd('yes i am subscribed and i am an instructor');
                //direct to a page where transaction don't need to enter email and name
                return '/instructor';
                //  redirect()->route('riders.index');
            } else if (auth()->user()->role == 'free') {
                //direct to a page where transaction don't need to enter email and name
                return '/individual';
            } else if (auth()->user()->role == 'student_amc' || auth()->user()->role == 'student_smc' || auth()->user()->role == 'student_poc') {
                return '/students';
            }else {
                return '/';
                //abort(403, "ILLEGAL ACCESS DENIED");
            }

        }else{
            return 'dashboard_interim';
        }
    }


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
