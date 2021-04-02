<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{

    public function __construct()
    {
        $this->middleware(['subscribed','individualSubscribed','verified']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user()->id;
        $questions = Question::all();
        return view('individual.index',['questions' => $questions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userId = Auth::user()->id;
        return view('students.create',['userId' => $userId]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'min: 3','unique:users'],
            'phone' => ['required', 'min: 11'],
            'country' => ['required', 'string'],
            'city' => ['required', 'string'],
            'zipcode' => ['required', 'min: 5'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::find($request->id);
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->country = $request->country;
        $user->city = $request->city ;
        $user->zipcode = $request-> zipcode;
        $user->password = Hash::make($request->password) ;

        $user->save();
        return redirect()->route('individual.profile')->with('success', "User Profile Edited Successfully!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }

    public function profile(){

        //retrieve user content based on its ID
        $user = User::find(Auth::user()->id);

        return view('individual.profile', ['user' => $user]);
    }


}
