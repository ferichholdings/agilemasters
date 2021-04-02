<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/dashboard_interim';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'min: 11'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'industry_id' => ['required'],
            'country' => ['required'],
            'city' => ['required'],
            'zipcode' => ['required'],
            'role' => ['required'],

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'industry_id' => $data['industry_id'],
            'phone' => $data['phone'],
            'country' => $data['country'],
            'city' => $data['city'],
            'zipcode' => $data['zipcode'],
            'role' => $data['role'],
        ]);
    }
    
    public function courseRegister(){
        return view('courses.course_register');
    }

    public function courseRegisterStore(Request $request){
        //dd($request->all());
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'min: 11'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'industry_id' => ['required'],
            'country' => ['required'],
            'city' => ['required'],
            'zipcode' => ['required'],
            'role' => ['required'],
            'dateschedule' => ['required'],
        ]);


        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->industry_id = $request->industry_id;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->zipcode = $request->zipcode;
        $user->role = $request->role;
        $user->dateschedule = $request->dateschedule;

        $user->save();
        //redirect to //student dashboard
        return redirect()->route('courses.dashboard')->with('success', "Your Registration was Successful!");
    }

}
