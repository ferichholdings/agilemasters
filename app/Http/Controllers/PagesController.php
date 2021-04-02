<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function index(){
        return view('pages.index');
    }
    public function whyAgile(){
        return view('pages.why_agile');
    }


    public function about(){
        return view('pages.about');
    }

    public function instructors(){
        return view('pages.instructors');
    }
    public function  partners(){
        return view('pages.partners');
    }

    public function contact(){
        return view('pages.contact');
    }

    public function signUp(){
        return view('pages.sign');
    }

    public function dashboard(){
       if(Auth::user()->role == 'student_amc' || Auth::user()->role == 'student_smc' || Auth::user()->role == 'student_poc'){
           //redirect to course dashboard
           return redirect()->route('courses.dashboard');
       }
        return view('pages.dashboard');
    }

    public function faqs(){
        return view('pages.faqs');
    }

    public function termsOfService(){
        return view('pages.terms_of_service');
    }
    public function privacyPolicy(){
        return view ('pages.privacy_policy');
    }

    public function help(){
        return view('pages.help');
    }
    public function morehelp(){
        return view('pages.morehelp');
    }

    public function settings(){
        return view('pages.settings');
    }

    public function blog(){
        return view('pages.blog');
    }
}
