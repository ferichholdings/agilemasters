<?php

namespace App\Http\Controllers;

use App\Models\CompanyData;
use App\Models\Corporate;
use App\Models\Money;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CorporateController extends Controller
{

    public function __construct()
    {
        $this->middleware(['subscribed','corporateSubscribed']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        ///start global count..........................
       global $count;//amount of people that can be registered by the company
        $user = auth()->user()->id;
//        $stripe = DB::table('subscription_items')->where('subscription_id', $user)->first();
//        if($stripe == "null"){
//            return back()->with('success',"Subscription was not successful, Please Subscribe again.");
//        }


             ///find payment record
        /// $flight = Flight::where('active', 1)->first();
        $payment = Money::where('user_id', $user)->first();

        $count = $payment->quantity;
      //  dd($stripe->stripe_plan);
        //6 months///////////////////////////////
        //5 - 50
//        if($stripe->stripe_plan == 'price_1IBbycHUeyKZTcreaYYdqOnR'){
//            //count
//             $count = 50;
//
//
//             //51 - 100
//        }else if($stripe->stripe_plan == 'price_1IBbzgHUeyKZTcre8i2EXKrG'){
//            //count = 100 for 6 months
//            $count = 100;
//
//
//            //101 to 1000
//        }else if($stripe->stripe_plan == 'price_1IBc3ZHUeyKZTcrezbCk70Fi'){
//            //count = 1000 for 6 months
//            $count = 1000;
//
//
//            //1001 and above
//        }else if($stripe->stripe_plan == 'price_1IBc9iHUeyKZTcre83b2JINE') {
//            //count = 1001 and above for 6 months
//            $count = 10000000;
//
//
//
//
//
//            //12 months
//            //5 - 50
//        }else if($stripe->stripe_plan == 'price_1IBc9iHUeyKZTcre83b2JINE'){
//            //count = 50 for 12 months
//            $count = 50;
//
//
//            //51 - 100
//        }else if($stripe->stripe_plan == 'price_1IBcAcHUeyKZTcreVnR3TJ5Q'){
//            //count = 100 for 12 months
//            $count = 100;
//
//
//            //101 to 1000
//        }else if($stripe->stripe_plan == 'price_1IBcCprice_1IBcCEHUeyKZTcreG2eSKVAQEHUeyKZTcreG2eSKVAQ'){
//            //count = 1000 for 12 months
//            $count = 1000;
//
//            //1001 and above
//        }else if($stripe->stripe_plan == 'price_1IBcDKHUeyKZTcreefieAcV6'){
//            //count = 1001 and above for 12 months
//            $count = 10000000;
//
//            //free trial
//        }else{
//            //count = 0
//            $count = 5;
//        }
        ///end global count..........................
        return view('corporate.index', ['count' => $count]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Corporate  $corporate
     * @return \Illuminate\Http\Response
     */
    public function show(Corporate $corporate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Corporate  $corporate
     * @return \Illuminate\Http\Response
     */
    public function edit(Corporate $corporate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Corporate  $corporate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Corporate $corporate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Corporate  $corporate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Corporate $corporate)
    {
        dd('delete corporate');
    }
    public function members(Corporate $corporate)
    {
        ///start global count..........................
        global $count;//amount of people that can be registered by the company
        $userId = auth()->user()->id;
        $stripe = DB::table('subscription_items')->where('subscription_id', $userId)->first();
        //  dd($stripe->stripe_plan);
        //6 months///////////////////////////////
        //5 - 50
        if($stripe->stripe_plan == 'price_1IBbycHUeyKZTcreaYYdqOnR'){
            //count
            $count = 50;


            //51 - 100
        }else if($stripe->stripe_plan == 'price_1IBbzgHUeyKZTcre8i2EXKrG'){
            //count = 100 for 6 months
            $count = 100;


            //101 to 1000
        }else if($stripe->stripe_plan == 'price_1IBc3ZHUeyKZTcrezbCk70Fi'){
            //count = 1000 for 6 months
            $count = 1000;


            //1001 and above
        }else if($stripe->stripe_plan == 'price_1IBc9iHUeyKZTcre83b2JINE') {
            //count = 1001 and above for 6 months
            $count = 10000000;





            //12 months
            //5 - 50
        }else if($stripe->stripe_plan == 'price_1IBc9iHUeyKZTcre83b2JINE'){
            //count = 50 for 12 months
            $count = 50;


            //51 - 100
        }else if($stripe->stripe_plan == 'price_1IBcAcHUeyKZTcreVnR3TJ5Q'){
            //count = 100 for 12 months
            $count = 100;


            //101 to 1000
        }else if($stripe->stripe_plan == 'price_1IBcCprice_1IBcCEHUeyKZTcreG2eSKVAQEHUeyKZTcreG2eSKVAQ'){
            //count = 1000 for 12 months
            $count = 1000;

            //1001 and above
        }else if($stripe->stripe_plan == 'price_1IBcDKHUeyKZTcreefieAcV6'){
            //count = 1001 and above for 12 months
            $count = 10000000;

            //free trial
        }else{
            //count = 0
            $count = 5;
        }
        ///end global count..........................
        //
        //select all company team members
        $teamMembers = CompanyData::paginate(20);
        return view('corporate.members',['count' => $count, 'teamMembers' => $teamMembers]);
    }

   public function add_member(){

       ///start global count..........................
       global $count;//amount of people that can be registered by the company
       $userId = auth()->user()->id;
       $stripe = DB::table('subscription_items')->where('subscription_id', $userId)->first();
       //  dd($stripe->stripe_plan);
       //6 months///////////////////////////////
       //5 - 50
       if($stripe->stripe_plan == 'price_1IBbycHUeyKZTcreaYYdqOnR'){
           //count
           $count = 50;


           //51 - 100
       }else if($stripe->stripe_plan == 'price_1IBbzgHUeyKZTcre8i2EXKrG'){
           //count = 100 for 6 months
           $count = 100;


           //101 to 1000
       }else if($stripe->stripe_plan == 'price_1IBc3ZHUeyKZTcrezbCk70Fi'){
           //count = 1000 for 6 months
           $count = 1000;


           //1001 and above
       }else if($stripe->stripe_plan == 'price_1IBc9iHUeyKZTcre83b2JINE') {
           //count = 1001 and above for 6 months
           $count = 10000000;





           //12 months
           //5 - 50
       }else if($stripe->stripe_plan == 'price_1IBc9iHUeyKZTcre83b2JINE'){
           //count = 50 for 12 months
           $count = 50;


           //51 - 100
       }else if($stripe->stripe_plan == 'price_1IBcAcHUeyKZTcreVnR3TJ5Q'){
           //count = 100 for 12 months
           $count = 100;


           //101 to 1000
       }else if($stripe->stripe_plan == 'price_1IBcCprice_1IBcCEHUeyKZTcreG2eSKVAQEHUeyKZTcreG2eSKVAQ'){
           //count = 1000 for 12 months
           $count = 1000;

           //1001 and above
       }else if($stripe->stripe_plan == 'price_1IBcDKHUeyKZTcreefieAcV6'){
           //count = 1001 and above for 12 months
           $count = 10000000;

           //free trial
       }else{
           //count = 0
           $count = 5;
       }
       ///end global count..........................


     //get the amount of records in company_data table
       $getCount = CompanyData::orderBy('name')->get();
       //find the amount of record in CompanyData
       $amountOfRecords =  $getCount->count();


        return view('corporate.addMember',['amountOfRecords' => $amountOfRecords, 'count' => $count]);
   }


}
