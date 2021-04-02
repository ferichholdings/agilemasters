<?php

namespace App\Http\Controllers;

use App\Models\CompanyData;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class CompanyDataController extends Controller
{

    public function __construct()
    {
        $this->middleware('subscribed');
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
        //
    }
    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


      $randomString = $this->generateRandomString(20);

         //validate
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|string|email|max:255|unique:users'
        ]);



           //start to find the amount of count allowed
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
           //end  to find the amount of count allowed
           //the amount of record allowed
         // dd('record allowed: '. $count);

        ///check amount of record from company data db
        ///
        $getCount = CompanyData::orderBy('name')->get();
        //find the amount of record in CompanyData
        $amountOfRecord =  $getCount->count();

        //ensure amount of record is not more than the alloted count
         if($amountOfRecord >= $count){
             //meaning you have exceeded your limit
             //return back()->with('success',"You have exceeded the amount of Team Members that is allowed. To insert more, please upgrade your subscription");
             return redirect()->route('corporate.addMember')->with('success', "You have exceeded the amount of Team Members that is allowed. To insert more, please upgrade your subscription");
         }else{
             //meaning you have not exceeded your limit
             //add to company data db
             $companyData = new CompanyData();
             $companyData->user_id = Auth::user()->id;
             $companyData->name = $request->name;
             $companyData->email = $request->email;
             $companyData->count = $amountOfRecord + 1;
             $companyData->password = Hash::make($randomString);

             //add data to database
             $companyData->save();

             //add email to session...so that it can be used as the to email
             Session::put('toEmail', $request->email);

             //send mail to team member...........................
             $data = [
                 'heading' => 'AGILE MASTERS DETAILS',
                 'msgBody' => 'Full Name: '.   $request->name . '   '.
                     'EMAIL ADDRESS : '.  $request->email .'            '.
                     'PASSWORD: '.  $randomString
             ];
             //find industry id
             //also create a record of the member in the database
             DB::table('users')->insert([
                 'name' => $request->name,
                 'username' => '',
                 'email' => $request->email,
                 'password' =>  Hash::make($randomString),
                 'industry_id' => Auth::user()->industry_id,
                 'phone' => '',
                 'country' => '',
                 'city' => $randomString,
                 'zipcode' => '',
                 'status' => 'subscribed',
                 'role' => 'individual'
             ]);



             Mail::send('emails.alert_team_members', $data, function($mail){
                 $mail->from('agilemasters2020@gmail.com');
                 $mail->to(Session::get('toEmail'));
                 $mail->subject('Agile Masters Registration Details');
             });



             //redirect back to add Members page
             return redirect()->route('corporate.addMember')->with('success', "Member Added Successfully!");
         }
        //insert into db
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CompanyData  $companyData
     * @return \Illuminate\Http\Response
     */
    public function show(CompanyData $companyData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CompanyData  $companyData
     * @return \Illuminate\Http\Response
     */
    public function edit(CompanyData $companyData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CompanyData  $companyData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CompanyData $companyData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CompanyData  $companyData
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        //1get record(email) from user to be able to delete
        $userEmail = DB::table('company_data')
            ->where('id', $id)
            ->first();

        //2.also delete record from users table
        User::where('email', $userEmail->email)->delete();

        //3.delete record from companyData
        CompanyData::where('id', $id)->firstorfail()->delete();


        return redirect()->route('corporate.members')->with('success', "Team Member Deleted Successfully!");
    }
}
