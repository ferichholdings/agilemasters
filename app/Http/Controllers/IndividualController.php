<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Comment;
use App\Models\Individual;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class IndividualController extends Controller
{


    public function __construct()
    {
        $this->middleware(['subscribed','individualSubscribed']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $questions = Question::latest()->paginate(5);
        $answers = Answer::paginate(5);
        $comments = Comment::all();
        return view('individual.index',['questions' => $questions, 'answers' => $answers, 'comments' => $comments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
     * @param  \App\Models\Individual  $individual
     * @return \Illuminate\Http\Response
     */
    public function show(Individual $individual)
    {
        $userId = Auth::user()->id;
        return view('individual.show',['userId' => $userId]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Individual  $individual
     * @return \Illuminate\Http\Response
     */
    public function edit(Individual $individual)
    {
        return view('individual.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Individual  $individual
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Individual $individual)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Individual  $individual
     * @return \Illuminate\Http\Response
     */
    public function destroy(Individual $individual)
    {
        //
    }

    public function profile(){

        //retrieve user content based on its ID
        $user = User::find(Auth::user()->id);

        return view('individual.profile', ['user' => $user]);
    }

    public function changePassword($id){
        return view('individual.changePassword',['id' => $id]);
    }

    public function changeImage($id){
        return view('individual.changeimage',['id' => $id]);
    }

    public function changePasswordStore(Request $request){
        $request->validate([
            'password' => 'required|min:8|max:20',
        ]);

        DB::table('users')
            ->where('id', $request->id)
            ->update(['password' => Hash::make($request->password)]);

        return redirect()->route('individual.profile', $request->id)->with('success', "Password has been changed Successfully!");
    }

    public function changeImageStore(Request $request){
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1048',
        ]);
        $imagePath = $request->file('image')->store('avatars');
        DB::table('users')
            ->where('id', $request->id)
            ->update(['avatar' => $imagePath]);

        return redirect()->route('individual.profile', $request->id)->with('success', "Image Uploaded Successfully!");
    }
}
