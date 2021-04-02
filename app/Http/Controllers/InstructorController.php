<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Certification;
use App\Models\EducationHistory;
use App\Models\EmploymentHistory;
use App\Models\Instructor;
use App\Models\Question;
use App\Models\Reference;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
class InstructorController extends Controller
{

    public function __construct()
    {
        $this->middleware('mustBeInstructor')->except(['create', 'store', 'succesPage']);
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

//         foreach($questions as $question){
//           $userId =  $question->user_id;//get the userid from the question
//           $user = User::find($userId); //get the user details from the id above
//         }
//        foreach($questions as $question){
//
//             array_push($q, $question->user()->user_id );
//        }
//        dd($q);
        //FIND THE answer for a particular answer
        //find the user that asked a particular question
//        foreach($questions as $question){
//           $answer = Answer::find($question->id);
//           $user = User::find($question->user_id);
//        }

       // dd($answer);
        return view('instructor.index', ['questions' => $questions,'answers' => $answers]);
    }

    /**5
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('instructor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //define array to temporarily insert table data

        $emp_data = array();
        $edu_data = array();
        $cert_data = array();
        $ref_data = array();
       global $mail1;

        if($request->ajax()){
            $rules = array(
                'firstname' => 'required|min:3|',
                'lastname' => 'required|min:3|max:255',
                'email' => 'required|min:3|max:255|string|email|unique:instructors',
                'phone' =>  'required|min:11',
                'country'=> 'required',
                'city' => 'required',
                'street' => 'required',
                'cv' => 'required|mimes:doc,docx,pdf, odf|max:1024',
///////////////////values for employment history
                'empname.*' => 'required',
                'emptitle.*' => 'required',
                'empstartdate.*' => 'required',
                'empenddate.*'  => 'required',
//////////////////////////values for education history
                'eduname.*' => 'required',
                'educourse.*' => 'required',
                'edudegree.*' => 'required',
                'edustartdate.*' => 'required',
                'eduenddate.*' => 'required',
                'educert.*'  => 'required|mimes:doc,docx,odf, png, jpg, jpeg,webp, tiff, bmp|max:1024',
//////////////////values for certification
                'certname.*' => 'required',
                'certno.*' => 'required',
                'certcert.*'  => 'required|mimes:doc,docx,odf, png, jpg, jpeg,webp, tiff, bmp|max:1024',
//////////////////values for reference
                'refname.*' => 'required',
                'refemail.*' => 'required',
                'refphone.*' => 'required',
                'refjobtitle.*' => 'required',
                'refcompany.*' => 'required',
            );



            $mail1 = $request->email;
//insert into employment histories table

            $empname = $request->empname;
            $emptitle = $request->emptitle;
            $empstartdate = $request->empstartdate;
            $empenddate = $request->empenddate;
            for($count1 = 0; $count1 < count($empname); $count1++){
                $data = array(
                    'empname' => $empname[$count1],
                    'email' => $mail1,
                    'emptitle' => $emptitle[$count1],
                    'empstartdate' => $empstartdate[$count1],
                    'empenddate' => $empenddate[$count1],
                );
                //$emp_data[] = $data;
                array_push($emp_data, $data);
            }
            EmploymentHistory::insert($emp_data);

//insert into education histories table
            $eduname = $request->eduname;
            $educourse = $request->educourse;
            $edudegree = $request->edudegree;
            $edustartdate = $request->edustartdate;
            $eduenddate = $request->eduenddate;
            //$educert = $request->educert;
            $educert = $request->file('educert');
            for($count2 = 0; $count2 < count($eduname); $count2++){
                $data = array(
                    'eduname' => $eduname[$count2],
                    'email' => $mail1,
                    'educourse' => $educourse[$count2],
                    'edudegree' => $edudegree[$count2],
                    'edustartdate' => $edustartdate[$count2],
                    'eduenddate' => $eduenddate[$count2],
                    'educert' => $educert[$count2]->store('education_certificates'),

                );
                //  $edu_data[] = $data;
                array_push($edu_data, $data);
            }
            EducationHistory::insert($edu_data);

//insert into Certification table
            $certname = $request->certname;
            $certno = $request->certno;
            $certcert = $request->file('certcert');

            for($count3 = 0; $count3 < count($certname); $count3++){
                $data = array(
                    'email' => $mail1,
                    'certname' => $certname[$count3],
                    'certno' => $certno[$count3],
                    'certcert' => $certcert[$count3]->store('certification'),
                );
                //$cert_data[] = $data;//
                array_push($cert_data, $data);
            }
            Certification::insert($cert_data);

//insert into References table
            $refname = $request->refname;
            $refemail = $request->refemail;
            $refphone = $request->refphone;
            $refjobtitle = $request->refjobtitle;
            $refcompany = $request->refcompany;
            for($count4 = 0; $count4 < count($refname); $count4++){
                $data = array(
                    'email' => $mail1,
                    'refname' => $refname[$count4],
                    'refemail' => $refemail[$count4],
                    'refphone' => $refphone[$count4],
                    'refjobtitle' => $refjobtitle[$count4],
                    'refcompany' => $refcompany[$count4],
                );
                //$cert_data[] = $data;//
                array_push($ref_data, $data);
            }
            Reference::insert($ref_data);

            ///insert into Instructor table
            $instructor = new Instructor();
            $instructor->firstname = $request->firstname;
            $instructor->lastname = $request->lastname;
            $instructor->email = $request->email;
             $instructorname = $request->firstname;
            $instructor->phone = $request->phone;
            $instructor->country = $request->country;
            $instructor->city   = $request->city;
            $instructor->street = $request->street;
            $instructor->cv = $request->file('cv')->store('resume' );
            $instructor->save();

            return response()->json([
                'success' => 'Data Added Successfully.'
            ]);
        }
        return redirect()->route('instructor.successpage')->with('success','Congratulations, your registration was successful!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Instructor  $instructor
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {

       // dd($id);
        $instructor = User::find($id);
     //   dd($instructor);
        return view('instructor.show', ['instructor' => $instructor]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Instructor  $instructor
     * @return \Illuminate\Http\Response
     */
    public function edit(Instructor $instructor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Instructor  $instructor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Instructor $instructor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Instructor  $instructor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Instructor $instructor)
    {
        //
    }

    public function successPage(){
        return view('instructor.successpage');
    }


    public function answer(Request $request){

        $request->validate([
            'id' => 'required',
            'answer' => 'required|min:5'
        ]);
        //get details about the question from the id
        $question = Question::find($request->id);
         //save answer to db
        $answer = new Answer;
        $answer->user_id = Auth::user()->id;
        $answer->question_id = $request->id;
        $answer->body = $request->answer;
        $answer->save();
        return redirect()->route('instructor.index')->with('success', "A question has been answered!");
    }

    public function profile(){
        //retrieve user content based on its ID
        $user = User::find(Auth::user()->id);
        return view('instructor.profile', ['user' => $user]);
    }

    public function profileStore(Request $request){

        //validate
        $request->validate([
            'name' => ['required', 'string', 'min: 3','max:255'],
            'phone' => ['required', 'min: 11', 'max:14'],
            'country' => ['required', 'string'],
            'city' => ['required', 'string', 'min:3', 'max:100'],
        ]);
      //dd($request->all());
       //dd($request->id);
        //update Instructor profile
        $instructor = User::find($request->id);

        $instructor->name = $request->name;
        $instructor->phone = $request->phone;
        $instructor->country = $request->country;
        $instructor->city = $request->city;
        $instructor->save();
        return redirect()->route('instructor.profile')->with('success', $request->name." profile has been updated successfully!");
    }

    public function review(){
        return view('instructor.review');
    }
}
