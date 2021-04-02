<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //also update the comment count    in the questions table
        //get question data via the question id
        $question =   Question::find($request->question_id);
        //get the commentCount from the question db
        $commentCount = $question->comment_count;

        //update comment_count column in question
        //and increment comment_count
//        $question1 = Question::find($request->question_id);
//        $question1->comment_count = $commentCount++;//incremnt comment_count in question db
//        $question->save();
        DB::table('questions')
            ->where('id', $request->question_id)
            ->update(['comment_count' => $commentCount++]);

       //save comment into comment db
        $comment  = new Comment;
        $comment->user_id = $request->user_id;
        $comment->question_id = $request->question_id;
        $comment->body = $request->body;
        $comment->save();



        return redirect()->route('individual.index')->with('success', "A new comment has been posted!");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {
        //
    }
    public function postComment(Request $request)
    {
        //
        $request->validate([
            'comment' => 'required|min:1',
        ]);

        $comment = new Comment();
        $comment->user_id = $request->user_id;
        $comment->post_id = $request->post_id;
        $comment->comment = $request->comment;
        $comment->reply = "";
        $comment->main = "";
        $comment->created_at = date('m/d/Y h:i:s a');
        $comment->save();
        // return back()->with('msg','success');
        $msg = "success";
        return response()->json(array('msg'=> $msg), 200);
    }
    public function postReplies(Request $request)
    {
        //
        $request->validate([
            'reply' => 'required|min:1',
        ]);

        $comment = new Comment();
        $comment->user_id = $request->user_id;
        $comment->post_id = "";
        $comment->comment = "";
        $comment->reply = $request->reply;
        $comment->main = $request->main;
        $comment->created_at = date('m/d/Y h:i:s a');
        $comment->save();
        // return back()->with('msg','success');
        $msg = "success";
        return response()->json(array('msg'=> $msg), 200);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Answer $answer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answer $answer)
    {
        //
    }
}
