<?php

namespace App\Http\Controllers;

use App\Models\Money;
use App\Models\Payment;
use App\Models\User;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Laravel\Cashier\Cashier;



class SubscriptionController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data = [
            'intent' => auth()->user()->createSetupIntent(),
        ];


        return view('subscription.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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


                return redirect()->route('individual.index')->with('success', "Subscription is Complete!");

        } catch (Exception $e) {
            return back()->with('success',$e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function corporate(Request $request){
        $request->validate([
            'plans' => 'required',
        ]);

        $data = [
            'intent' => auth()->user()->createSetupIntent(),
        ];

       global $category;
        $plan = $request->plans;
        //use plan to determine the amount of people that can be added
        if($plan == 'price_1IF10JHUeyKZTcreqi7OTgNR'){
            //plan 6a
            $category = 1;
        }else if($plan == 'price_1IF13ZHUeyKZTcreUL4Wbvhj'){
            //plan 6b
            $category = 2;
        }else if($plan == 'price_1IF1DeHUeyKZTcreLqmQ1KvF'){
            //plan 6c
            $category = 3;
        }
        else if($plan == 'price_1IF2haHUeyKZTcreg20x6jmk'){
            //plan 6d
            $category = 4;
        }elseif($plan == 'price_1IF2jeHUeyKZTcreAW6OzUZw' ){
            //plan 12a
            $category = 5;
        }else if($plan == 'price_1IF2lEHUeyKZTcrevLhIjvu3' ){
            //plan 12b
            $category = 6;
        }else if($plan == 'price_1IF2mcHUeyKZTcrey4SFmoLH' ){
            //plan 12c
            $category = 7;
        }
        else if($plan == 'price_1IF2oRHUeyKZTcreRymDr2YG' ){
            //plan 12d
            $category = 8;
        }
        return view('subscription.corporate', ['category' => $category, 'plan' => $plan, 'data' => $data]);
       // return redirect()->route('subscription.corporateQuantity',['category' => $category]);
    }

    public function payment(Request $request){

        $request->validate([
            'quantities' => 'required',
            'plan' => 'required',
            'category' => 'required',
        ]);

        $quantities = $request->quantities;

        $plan =    $request->plan;
        $category = $request->category;
        global $percentValue;
        global $amount;
        if($category == 1){
            $percentValue = 475 ;
        }else if($category == 2){
            $percentValue = 450 ;
        }else if($category == 3){
            $percentValue =  425 ;
        }else if($category == 4){
            $percentValue = 400 ;
        }
        elseif($category == 5){
            $percentValue = 874 ;
        }else if($category == 6){
            $percentValue = 826.5 ;
        }else if($category == 7){
            $percentValue =  760 ;
        }else if($category == 8){
            $percentValue = 712.5 ;
        }
        $amount =  $quantities * $percentValue * 100;
        //dd("Quantities: " . $quantities . " Percent Value: " . $percentValue. " amount: " . $amount. " Category: ". $category);

        return view('subscription.corporateform', ['plan' => $plan, 'amount' => $amount,
            'percentValue' => $percentValue, 'quantities' => $quantities, 'category' => $category
        ]);
    }

    public function corporateform(Request $request){
        $request->validate([
            'plan' => 'required',
            'quantities' => 'required',
            'stripeToken' => 'required',
            'amount' => 'required',
            'category'=>'required'
        ]);

        $user = auth()->user();
        $input = $request->all();
        $token1 = $request->_token;
        $token =  $request->stripeToken;
        $category = $request->category;
        $plan = $request->plan;
        $amount = $request->amount;
        $quantities = $request->quantities;
        global $categoryDesc;
        global $duration;


        if($category == 1){
            $categoryDesc = "Corporate plan for 10 to 50 people for 6months with 5% discount";
            $duration = 6;
        }else if($category == 2){
            $categoryDesc = "Corporate plan for 51 to 100 people for 6months with 10% discount";
            $duration = 6;
        }
        else if($category == 3){
            $categoryDesc = "Corporate plan for 101 to 1000 people for 6months with 15% discount";
            $duration = 6;
        }else if($category == 4){
            $categoryDesc = "Corporate plan for 1001 and above people for 6months with 20% discount";
            $duration = 6;
        }
        else if($category == 5){
            $categoryDesc = "Corporate plan for 10 to 50 people for 12months with 8% discount";
            $duration = 12;
        }
        else if($category == 6){
            $categoryDesc = "Corporate plan for 51 to 100 people for 12months with 13% discount";
            $duration = 12;
        }
        else if($category == 7){
            $categoryDesc = "Corporate plan for 101 to 1000 people for 12months with 20% discount";
            $duration = 12;
        }
        else if($category == 8){
            $categoryDesc = "Corporate plan for 1001 and above people for 12months with 25% discount";
            $duration = 12;
        }
        try {
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $charge= \Stripe\Charge::create([
                'amount' => $request->amount,
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => $categoryDesc,
                'receipt_email' => Auth::user()->email,
                'metadata' => [
                    'quantity' => $quantities,
                ],
            ]);

//            ///create subscription
//            if (is_null($user->stripe_id)) {
//                $stripeCustomer = $user->createAsStripeCustomer();
//            }
//            \Stripe\Customer::createSource(
//                $user->stripe_id,
//                ['source' => $token1]
//            );
//            $user->newSubscription('test',$plan)
//                ->create( );

            ///subscription has been completed
            /// update user status to subscribed
            ///
             DB::table('users')
                ->where('email', $user->email)
                ->update(['status' => 'subscribed']);
             //add details to Payments table
             $payment = new Money();
             $payment->user_id = Auth::user()->id;
             $payment->category = $category;
             $payment->quantity = $quantities;
             $payment->amount = $amount;
             $payment->duration = $duration;
             $payment->save();
            //after completion, redirect to .....
            //  return redirect()->route('pages.dashboard')->with('success', "Subscription is Complete!");

                return redirect()->route('corporate.index')->with('success', "Subscription is Complete!");

        } catch (Exception $e) {
            return back()->with('success',$e->getMessage());
        }
    }

}
