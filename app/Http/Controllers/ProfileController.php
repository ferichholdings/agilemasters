<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = auth()->user()->id;
        //dd($user);
        $profile = DB::table('profiles')->where('user_id', $user)->value('user_id');
        $profileid= DB::table('profiles')->where('user_id', $user)->value('id');
        $profiledetail = DB::table('profiles')->where('id', $profileid)->first();

       // dd($profile);
       //return view('profile.index')->with('profile', $profile);
        return view('profile.index',['profile' => $profile, 'profileid' => $profileid, 'profiledetail' => $profiledetail]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('profile.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'bio' => 'required|min:3',
            'image' => 'required|image|max:1004'
        ]);

        $profile = new Profile();
        $profile->user_id = $request->user_id;
        $profile->bio = $request->bio;
        $path = $request->file('image')->store('profile_images');
        $profile->image = $path;

        if($profile->save()){
            return response()->json($profile, 200);
        }else{
            //return response()->json($category, 500);
            return response()->json([
                'message' => 'An error occurred, please try again',
                'status_code'=> 500
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        $profile1 = Profile::where('id', $profile->id)->first();
        return response()->json($profile1, 200);
       // dd($profile->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        return view('profile.edit',['profile' => $profile->id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        $request->validate([
            'bio' => 'required|min:3',

        ]);

       // dd($request->all());

        $profile->bio = $request->bio;
        $profile->user_id = $request->user_id;
        $oldPath = $profile->image;
        if($request->hasFile('image')){
            $request->validate([
                'image' => 'required|image|max:1004'
            ]);
            $path = $request->file('image')->store('profile_images');
            $profile->image = $path;
            //delete oldimage
            Storage::delete($oldPath);
        }


        if($profile->save()){
            return response()->json($profile, 200);
        }else{
            //return response()->json($category, 500);
            return response()->json([
                'message' => 'An error occured, please try again',
                'status_code'=> 500
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
