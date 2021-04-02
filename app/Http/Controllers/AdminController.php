<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use App\Models\Industry;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('mustBeAdmin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

		return view('admin.index');
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

    public function add_instructors()
    {
        //
        return view('admin.addInstructors');
    }
    public function instructors()
    {
        //
       // $insData = DB::select('select * from instructors JOIN educational_histories ON educational_histories.id=instructors.educational_history_id JOIN employment_histories ON employment_histories.id=instructors.employment_history_id JOIN certifications ON certifications.id=instructors.certification_id JOIN references ON references.id=instructors.reference_id GROUP BY instructors.id');
        $instructors = Instructor::all();
        return view('admin.instructors',['instructors' => $instructors]);
    }

    public function questions()
    {
        //
        $queData = DB::select('select * from questions JOIN answers ON answers.question_id = questions.id JOIN users ON users.id=questions.user_id');
        return view('admin.questions',  ['queData' => $queData ]);
    }
    public function users()
    {
        //
        $userData = DB::select('select * from users');
        return view('admin.users',  ['userData' => $userData ]);
    }
    public function subscriptions()
    {
        //
        $subData = DB::select('select *, users.name as names, subscriptions.name as name, subscriptions.created_at as created from subscriptions JOIN users ON users.id=subscriptions.user_id');
        return view('admin.subscriptions',  ['subData' => $subData ]);
    }
    public function industry_create()
    {
        //
        return view('admin.industry');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function industry_store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3',
            'content' => 'required'
        ]);
        $industry = new Industry();
        $industry->title = $request->title;
      //  $industry->content = $request->content;

        if($industry->save()){
            return response()->json($industry, 200);
        }else{
            return response()->json($industry, 500);
        }

        return $industry;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }

    public function adminAssignLogin($id){
        $instructor = Instructor::find($id);
        return view('admin.assignlogin', ['instructor' => $instructor]);
    }

    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function loginStore(Request $request){
//        dd($request->all());
        //1. insert instructor into user table
         //get some details from instructors table
        $randomString = $this->generateRandomString(25);
        $instructor = Instructor::find($request->id);
          ////add to user table
        $user = new User;
        $user->name = $instructor->firstname. ' ' . $instructor->lastname;
        $user->username = 'Instructor '. $instructor->firstname;
        $user->industry_id = $instructor->id;
        $user->email = $request->email;
        $user->password =Hash::make($randomString);
        $user->phone = $instructor->phone;
        $user->country =$instructor->country;
        $user->city = $instructor->city;
        $user->zipcode =$randomString;
        $user->role = 'instructor';
        $user->status = 'subscribed';


        $user->save();
        //2. send mail to user and confirmation to admin

        //3. redirect back to admin index page
        return redirect()->route('admin.index')->with('success', "An Instructor has been given login details successfully!");
    }
}

