<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function index(){
        return view('courses.index');
    }

    public function sfc(){
        return view('courses.sfc');
    }

    public function smc(){
        return view('courses.smc');
    }

    public function afc(){
        return view('courses.afc');
    }
    public function poc(){
        return view('courses.poc');
    }

    public function amc(){
return view('courses.amc');
}

    public function othercourses(){
        return view('courses.othercourses');
    }

    public function dashboard(){
        return view('students.dashboard');
    }

    public function create(){
        $data = [
            'intent' => auth()->user()->createSetupIntent(),
        ];


        return view('courses.create')->with($data);
    }

    public function store(Request $request){
        $user = auth()->user();
        $input = $request->all();
        $token =  $request->stripeToken;
        $paymentMethod = $request->paymentMethod;
        try {
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            if (is_null($user->stripe_id)) {
                $stripeCustomer = $user->createAsStripeCustomer();
            }
            \Stripe\Customer::createSource(
                $user->stripe_id,
                ['source' => $token]
            );
            $user->newSubscription('test',$input['plans'])
                ->create($paymentMethod, [
                    'email' => $user->email,
                ]);
            ///subscription has been completed
            /// update user status to subscribed
            ///
            DB::table('users')
                ->where('email', $user->email)
                ->update(['status' => 'subscribed']);


            return redirect()->route('students.index')->with('success', "Subscription is Complete!");

        } catch (Exception $e) {
            return back()->with('success',$e->getMessage());
        }
    }
}
